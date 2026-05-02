<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Employee::with('currentEmployer')->withTrashed(false);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('first_name',  'like', "%{$s}%")
                    ->orWhere('last_name',  'like', "%{$s}%")
                    ->orWhere('national_id', 'like', "%{$s}%")
                    ->orWhere('email',      'like', "%{$s}%")
                    ->orWhere('phone',      'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        $employees = $query->latest()->paginate(15)->withQueryString();

        $provinces = Employee::distinct()->pluck('province')->filter()->sort()->values();

        return view('employees.index', compact('employees', 'provinces'));
    }

    // ── Create ─────────────────────────────────────────────────────────────────
    public function create()
    {
        $employers = Employer::orderBy('name')->get();
        return view('employees.create', compact('employers'));
    }

    public function store(Request $request)
    {
        $employer = auth()->user()->employer;
        $data     = $request->validate($this->rules());

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        $user = User::create([
            'name'     => $data['first_name'] . ' ' . $data['last_name'],
            'email'    => $data['email'],
            'password' => Hash::make('passwordEmployee12'),
        ]);

        $employee = new Employee($data);
        $employee->user()->associate($user);          // sets user_id on employee
        $employee->currentEmployer()->associate($employer);
        $employee->save();

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', "Employee {$employee->full_name} created successfully.");
    }

    // ── Show ───────────────────────────────────────────────────────────────────
    public function show(Employee $employee)
    {
        $employee->load([
            'currentEmployer',
            'employmentRecords.employer',
            'claims',
            'transferRequests',
        ]);

        return view('employees.show', compact('employee'));
    }

    // ── Edit ───────────────────────────────────────────────────────────────────
    public function edit(Employee $employee)
    {
        $employers = Employer::orderBy('name')->get();
        return view('employees.edit', compact('employee', 'employers'));
    }

    // ── Update ─────────────────────────────────────────────────────────────────
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate($this->rules($employee->id));

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $data['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        $employee->update($data);

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', "Employee {$employee->full_name} updated successfully.");
    }

    // ── Destroy ────────────────────────────────────────────────────────────────
    public function destroy(Employee $employee)
    {
        $name = $employee->full_name;
        $employee->delete(); // soft delete

        return redirect()
            ->route('employees.index')
            ->with('success', "{$name} has been removed.");
    }

    // ── Search by National ID ──────────────────────────────────────────────────
    public function search(Request $request)
    {
        $employee = null;
        $searched = false;

        if ($request->filled('national_id')) {
            $searched  = true;
            $employee  = Employee::with([
                'currentEmployer',
                'employmentRecords.employer',
                'claims',
            ])->where('national_id', $request->national_id)->first();
        }

        return view('employees.search', compact('employee', 'searched'));
    }

    // ── Validation Rules ───────────────────────────────────────────────────────
    private function rules(?int $ignoreId = null): array
    {
        return [
            'national_id'          => [
                'required',
                'string',
                'max:20',
                Rule::unique('employees', 'national_id')->ignore($ignoreId)
            ],
            'first_name'           => ['required', 'string', 'max:100'],
            'last_name'            => ['required', 'string', 'max:100'],
            'middle_name'          => ['nullable', 'string', 'max:100'],
            'date_of_birth'        => ['required', 'date', 'before:today'],
            'gender'               => ['required', Rule::in(['male', 'female', 'other'])],
            'phone'                => ['required', 'string', 'max:20'],
            'email'                => [
                'required',
                'email',
                'max:191',
                Rule::unique('employees', 'email')->ignore($ignoreId)
            ],
            'district'             => ['nullable', 'string', 'max:100'],
            'province'             => ['nullable', 'string', 'max:100'],
            'photo'                => ['nullable', 'image', 'max:2048'],
            'current_employer_id'  => ['nullable', 'exists:employers,id'],
            'status'               => ['required', Rule::in(['active', 'unemployed', 'blacklisted'])],
            'skills'               => ['nullable', 'string'],
            'highest_qualification' => ['nullable', 'string', 'max:191'],
        ];
    }
}
