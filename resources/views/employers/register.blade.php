@extends('layouts.app')
@section('title', 'Employer Registration')

@section('content')

<div class="row justify-content-center">
<div class="col-xl-8">

    <div class="section-header mb-4">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-building-plus me-2"></i>Employer Registration
        </h5>
        <small class="text-muted">Register your organization on the national labor registry</small>
    </div>

    <form method="POST" action="{{ route('employer.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Company Information --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-building me-2 text-primary"></i>Company Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    {{-- RDB Number --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            RDB Registration Number <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="rdb_number"
                               class="form-control @error('rdb_number') is-invalid @enderror"
                               placeholder="e.g. RDB/2020/001234"
                               value="{{ old('rdb_number') }}"
                               required>
                        @error('rdb_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Your Rwanda Development Board company registration number
                        </small>
                    </div>

                    {{-- Company Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Company Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="company_name"
                               class="form-control @error('company_name') is-invalid @enderror"
                               value="{{ old('company_name') }}"
                               required>
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Trading Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Trading Name</label>
                        <input type="text"
                               name="trading_name"
                               class="form-control @error('trading_name') is-invalid @enderror"
                               placeholder="If different from company name"
                               value="{{ old('trading_name') }}">
                        @error('trading_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Business Type --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Business Type <span class="text-danger">*</span>
                        </label>
                        <select name="business_type"
                                class="form-select @error('business_type') is-invalid @enderror"
                                required>
                            <option value="">Select type...</option>
                            <option value="sole_proprietorship" {{ old('business_type') === 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                            <option value="partnership"         {{ old('business_type') === 'partnership'         ? 'selected' : '' }}>Partnership</option>
                            <option value="limited_company"     {{ old('business_type') === 'limited_company'     ? 'selected' : '' }}>Limited Company</option>
                            <option value="public_institution"  {{ old('business_type') === 'public_institution'  ? 'selected' : '' }}>Public Institution</option>
                            <option value="ngo"                 {{ old('business_type') === 'ngo'                 ? 'selected' : '' }}>NGO</option>
                            <option value="cooperative"         {{ old('business_type') === 'cooperative'         ? 'selected' : '' }}>Cooperative</option>
                            <option value="other"               {{ old('business_type') === 'other'               ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('business_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Industry Sector --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Industry Sector <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="industry_sector"
                               class="form-control @error('industry_sector') is-invalid @enderror"
                               placeholder="e.g. Information Technology"
                               value="{{ old('industry_sector') }}"
                               required>
                        @error('industry_sector')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Company Description --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Company Description</label>
                        <textarea name="company_description"
                                  class="form-control @error('company_description') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Brief description of your organization...">{{ old('company_description') }}</textarea>
                        @error('company_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Website --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Website</label>
                        <input type="url"
                               name="website"
                               class="form-control @error('website') is-invalid @enderror"
                               placeholder="https://www.company.rw"
                               value="{{ old('website') }}">
                        @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Company Logo --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Company Logo</label>
                        <input type="file"
                               name="company_logo"
                               class="form-control @error('company_logo') is-invalid @enderror"
                               accept="image/*">
                        @error('company_logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">JPG, PNG or WebP. Max 2MB.</small>
                    </div>

                </div>
            </div>
        </div>

        {{-- Headquarters --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-geo-alt me-2 text-primary"></i>Headquarters Location
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Province <span class="text-danger">*</span>
                        </label>
                        <select name="headquarters_province"
                                class="form-select @error('headquarters_province') is-invalid @enderror"
                                required>
                            <option value="">Select province...</option>
                            <option value="Kigali City" {{ old('headquarters_province') === 'Kigali City' ? 'selected' : '' }}>Kigali City</option>
                            <option value="Northern"    {{ old('headquarters_province') === 'Northern'    ? 'selected' : '' }}>Northern</option>
                            <option value="Southern"    {{ old('headquarters_province') === 'Southern'    ? 'selected' : '' }}>Southern</option>
                            <option value="Eastern"     {{ old('headquarters_province') === 'Eastern'     ? 'selected' : '' }}>Eastern</option>
                            <option value="Western"     {{ old('headquarters_province') === 'Western'     ? 'selected' : '' }}>Western</option>
                        </select>
                        @error('headquarters_province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            District <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="headquarters_district"
                               class="form-control @error('headquarters_district') is-invalid @enderror"
                               placeholder="e.g. Nyarugenge"
                               value="{{ old('headquarters_district') }}"
                               required>
                        @error('headquarters_district')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Address</label>
                        <input type="text"
                               name="headquarters_address"
                               class="form-control @error('headquarters_address') is-invalid @enderror"
                               placeholder="Street address"
                               value="{{ old('headquarters_address') }}">
                        @error('headquarters_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-telephone me-2 text-primary"></i>Contact Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Contact Phone <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="contact_phone"
                               class="form-control @error('contact_phone') is-invalid @enderror"
                               placeholder="+250788000000"
                               value="{{ old('contact_phone') }}"
                               required>
                        @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Contact Email <span class="text-danger">*</span>
                        </label>
                        <input type="email"
                               name="contact_email"
                               class="form-control @error('contact_email') is-invalid @enderror"
                               placeholder="info@company.rw"
                               value="{{ old('contact_email') }}"
                               required>
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">HR Contact Name</label>
                        <input type="text"
                               name="hr_contact_name"
                               class="form-control @error('hr_contact_name') is-invalid @enderror"
                               value="{{ old('hr_contact_name') }}">
                        @error('hr_contact_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">HR Contact Phone</label>
                        <input type="text"
                               name="hr_contact_phone"
                               class="form-control @error('hr_contact_phone') is-invalid @enderror"
                               value="{{ old('hr_contact_phone') }}">
                        @error('hr_contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">HR Contact Email</label>
                        <input type="email"
                               name="hr_contact_email"
                               class="form-control @error('hr_contact_email') is-invalid @enderror"
                               value="{{ old('hr_contact_email') }}">
                        @error('hr_contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Notice --}}
        <div class="alert alert-info mb-4">
            <i class="bi bi-info-circle me-2"></i>
            Your registration will be reviewed by a government administrator before activation.
            You will be notified once your account is verified.
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-2"></i>Submit Registration
            </button>
        </div>

    </form>
</div>
</div>

@endsection