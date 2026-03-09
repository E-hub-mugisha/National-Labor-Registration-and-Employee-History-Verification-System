<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEmployerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'rdb_number'              => 'required|string|max:50|unique:employers,rdb_number',
            'company_name'            => 'required|string|max:200',
            'trading_name'            => 'nullable|string|max:200',
            'business_type'           => 'required|in:sole_proprietorship,partnership,limited_company,public_institution,ngo,cooperative,other',
            'industry_sector'         => 'required|string|max:100',
            'company_description'     => 'nullable|string|max:2000',
            'website'                 => 'nullable|url|max:200',
            'headquarters_province'   => 'required|string|max:60',
            'headquarters_district'   => 'required|string|max:60',
            'headquarters_address'    => 'nullable|string|max:500',
            'contact_phone'           => 'required|string|max:20',
            'contact_email'           => 'required|email|max:191',
            'hr_contact_name'         => 'nullable|string|max:100',
            'hr_contact_phone'        => 'nullable|string|max:20',
            'hr_contact_email'        => 'nullable|email|max:191',
            'company_logo'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'rdb_number.required'           => 'RDB registration number is required.',
            'rdb_number.unique'             => 'This RDB number is already registered.',
            'company_name.required'         => 'Company name is required.',
            'business_type.required'        => 'Business type is required.',
            'business_type.in'              => 'Please select a valid business type.',
            'industry_sector.required'      => 'Industry sector is required.',
            'headquarters_province.required'=> 'Province is required.',
            'headquarters_district.required'=> 'District is required.',
            'contact_phone.required'        => 'Contact phone is required.',
            'contact_email.required'        => 'Contact email is required.',
            'contact_email.email'           => 'Please enter a valid email address.',
            'company_logo.image'            => 'Logo must be an image file.',
            'company_logo.max'              => 'Logo must not exceed 2MB.',
        ];
    }
}