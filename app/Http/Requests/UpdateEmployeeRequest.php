<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'first_name'           => 'sometimes|required|string|max:100',
            'last_name'            => 'sometimes|required|string|max:100',
            'middle_name'          => 'nullable|string|max:100',
            'date_of_birth'        => 'sometimes|required|date|before:-18 years',
            'gender'               => 'sometimes|required|in:male,female,other',
            'nationality'          => 'sometimes|required|string|max:60',
            'province'             => 'nullable|string|max:60',
            'district'             => 'nullable|string|max:60',
            'sector'               => 'nullable|string|max:60',
            'phone_primary'        => 'sometimes|required|string|max:20',
            'phone_secondary'      => 'nullable|string|max:20',
            'email'                => 'nullable|email|max:191',
            'address'              => 'nullable|string|max:500',
            'current_job_title'    => 'nullable|string|max:100',
            'employment_status'    => 'sometimes|required|in:employed,unemployed,self_employed,inactive,student',
            'professional_summary' => 'nullable|string|max:2000',
            'languages'            => 'nullable|array',
            'languages.*'          => 'string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'      => 'First name is required.',
            'last_name.required'       => 'Last name is required.',
            'date_of_birth.before'     => 'You must be at least 18 years old.',
            'phone_primary.required'   => 'Primary phone number is required.',
            'employment_status.required' => 'Employment status is required.',
            'employment_status.in'     => 'Please select a valid employment status.',
        ];
    }
}