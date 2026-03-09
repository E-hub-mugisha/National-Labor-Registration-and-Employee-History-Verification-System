<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'national_id'       => 'required|string|min:10|max:20|unique:employees,national_id',
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'middle_name'       => 'nullable|string|max:100',
            'date_of_birth'     => 'required|date|before:-18 years',
            'gender'            => 'required|in:male,female,other',
            'nationality'       => 'required|string|max:60',
            'province'          => 'nullable|string|max:60',
            'district'          => 'nullable|string|max:60',
            'sector'            => 'nullable|string|max:60',
            'phone_primary'     => 'required|string|max:20',
            'phone_secondary'   => 'nullable|string|max:20',
            'email'             => 'nullable|email|max:191',
            'address'           => 'nullable|string|max:500',
            'employment_status' => 'required|in:employed,unemployed,self_employed,inactive,student',
        ];
    }

    public function messages(): array
    {
        return [
            'national_id.required' => 'National ID number is required.',
            'national_id.unique'   => 'This National ID is already registered.',
            'national_id.min'      => 'Please enter a valid National ID number.',
            'date_of_birth.before' => 'You must be at least 18 years old to register.',
            'first_name.required'  => 'First name is required.',
            'last_name.required'   => 'Last name is required.',
            'phone_primary.required' => 'Primary phone number is required.',
        ];
    }
}