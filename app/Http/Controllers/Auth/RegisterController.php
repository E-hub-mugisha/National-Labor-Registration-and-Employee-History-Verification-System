<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmployerWelcomeMail;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{

    // ── Show registration page ────────────────────────────────
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    // ── Handle registration POST ──────────────────────────────
    public function register(Request $request): RedirectResponse
    {
        $role = $request->input('role');

        return match ($role) {
            'government' => $this->registerGovernment($request),
            'employer'   => $this->registerEmployer($request),
            default      => back()->withErrors(['role' => 'Please select a valid role.'])->withInput(),
        };
    }

    // ══════════════════════════════════════════════════════════
    // GOVERNMENT REGISTRATION
    // ══════════════════════════════════════════════════════════
    private function registerGovernment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'ministry'              => ['required', 'string', 'max:255'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'government',
            'is_active' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('gov.dashboard');
    }

    // ══════════════════════════════════════════════════════════
    // EMPLOYER REGISTRATION
    // ══════════════════════════════════════════════════════════
    private function registerEmployer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'emp_name'            => ['required', 'string', 'max:255'],
            'tin_number'          => ['required', 'string', 'max:20', 'unique:employers,tin_number'],
            'registration_number' => ['nullable', 'string', 'max:100'],
            'sector'              => ['required', 'string', 'in:public_administration,banking_finance,hospitality_tourism,bpo_call_center,healthcare,education,manufacturing,construction,agriculture,ngo,technology,retail,other'],
            'emp_email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'               => ['required', 'string', 'max:20'],
            'province'            => ['required', 'string', 'in:Kigali,Northern,Southern,Eastern,Western'],
            'district'            => ['required', 'string', 'max:100'],
            'address'             => ['nullable', 'string', 'max:255'],
            'website'             => ['nullable', 'url', 'max:255'],
            'description'         => ['nullable', 'string', 'max:1000'],
            'logo'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Auto-generate a secure random password
        $plainPassword = Str::password(12, letters: true, numbers: true, symbols: false);

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        [$user, $employer] = DB::transaction(function () use ($validated, $plainPassword, $logoPath) {

            // 1. Create the User account
            $user = User::create([
                'name'      => $validated['emp_name'],
                'email'     => $validated['emp_email'],
                'password'  => Hash::make($plainPassword),
                'role'      => 'employer',
                'is_active' => false, // stays inactive until admin/gov verifies
            ]);

            // 2. Create the Employer profile
            $employer = Employer::create([
                'user_id'             => $user->id,
                'name'                => $validated['emp_name'],
                'tin_number'          => $validated['tin_number'],
                'registration_number' => $validated['registration_number'] ?? null,
                'sector'              => $validated['sector'],
                'email'               => $validated['emp_email'],
                'phone'               => $validated['phone'],
                'province'            => $validated['province'],
                'district'            => $validated['district'],
                'address'             => $validated['address'] ?? null,
                'website'             => $validated['website'] ?? null,
                'description'         => $validated['description'] ?? null,
                'logo'                => $logoPath,
                'status'              => 'pending',
            ]);

            return [$user, $employer];
        });

        // 3. Send welcome email with credentials (outside transaction — network failure shouldn't rollback the DB)
        Mail::to($validated['emp_email'])->send(
            new EmployerWelcomeMail($user, $employer, $plainPassword)
        );

        return redirect()
            ->route('employer.pending')
            ->with('success', 'Registration submitted! Check your email for login credentials. Your account will be activated after review.');
    }
}