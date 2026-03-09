@extends('layouts.app')
@section('title', 'Employee Registration')

@section('content')

<div class="row justify-content-center">
<div class="col-xl-8">

    <div class="section-header mb-4">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-person-plus me-2"></i>Employee Registration
        </h5>
        <small class="text-muted">Create your verified professional profile</small>
    </div>

    <form method="POST" action="{{ route('employee.store') }}">
        @csrf

        {{-- Personal Information --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-person me-2 text-primary"></i>Personal Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    {{-- National ID --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            National ID Number <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="national_id"
                               class="form-control @error('national_id') is-invalid @enderror"
                               placeholder="e.g. 1199880123456789"
                               value="{{ old('national_id') }}"
                               maxlength="20"
                               required>
                        @error('national_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Your 16-digit Rwanda National ID number
                        </small>
                    </div>

                    {{-- First Name --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            First Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="first_name"
                               class="form-control @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name') }}"
                               required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Middle Name --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Middle Name</label>
                        <input type="text"
                               name="middle_name"
                               class="form-control @error('middle_name') is-invalid @enderror"
                               value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Last Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="last_name"
                               class="form-control @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name') }}"
                               required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Date of Birth --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Date of Birth <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               name="date_of_birth"
                               class="form-control @error('date_of_birth') is-invalid @enderror"
                               value="{{ old('date_of_birth') }}"
                               required>
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Gender <span class="text-danger">*</span>
                        </label>
                        <select name="gender"
                                class="form-select @error('gender') is-invalid @enderror"
                                required>
                            <option value="">Select gender...</option>
                            <option value="male"   {{ old('gender') === 'male'   ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other"  {{ old('gender') === 'other'  ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nationality --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Nationality <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="nationality"
                               class="form-control @error('nationality') is-invalid @enderror"
                               value="{{ old('nationality', 'Rwandan') }}"
                               required>
                        @error('nationality')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- Location --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-geo-alt me-2 text-primary"></i>Location
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Province</label>
                        <select name="province"
                                class="form-select @error('province') is-invalid @enderror">
                            <option value="">Select province...</option>
                            <option value="Kigali City"    {{ old('province') === 'Kigali City'    ? 'selected' : '' }}>Kigali City</option>
                            <option value="Northern"       {{ old('province') === 'Northern'       ? 'selected' : '' }}>Northern</option>
                            <option value="Southern"       {{ old('province') === 'Southern'       ? 'selected' : '' }}>Southern</option>
                            <option value="Eastern"        {{ old('province') === 'Eastern'        ? 'selected' : '' }}>Eastern</option>
                            <option value="Western"        {{ old('province') === 'Western'        ? 'selected' : '' }}>Western</option>
                        </select>
                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">District</label>
                        <input type="text"
                               name="district"
                               class="form-control @error('district') is-invalid @enderror"
                               placeholder="e.g. Gasabo"
                               value="{{ old('district') }}">
                        @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sector</label>
                        <input type="text"
                               name="sector"
                               class="form-control @error('sector') is-invalid @enderror"
                               placeholder="e.g. Remera"
                               value="{{ old('sector') }}">
                        @error('sector')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact & Employment --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-telephone me-2 text-primary"></i>Contact & Employment
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Primary Phone <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="phone_primary"
                               class="form-control @error('phone_primary') is-invalid @enderror"
                               placeholder="+250788000000"
                               value="{{ old('phone_primary') }}"
                               required>
                        @error('phone_primary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Secondary Phone</label>
                        <input type="text"
                               name="phone_secondary"
                               class="form-control @error('phone_secondary') is-invalid @enderror"
                               value="{{ old('phone_secondary') }}">
                        @error('phone_secondary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Employment Status <span class="text-danger">*</span>
                        </label>
                        <select name="employment_status"
                                class="form-select @error('employment_status') is-invalid @enderror"
                                required>
                            <option value="">Select status...</option>
                            <option value="employed"     {{ old('employment_status') === 'employed'     ? 'selected' : '' }}>Employed</option>
                            <option value="unemployed"   {{ old('employment_status') === 'unemployed'   ? 'selected' : '' }}>Unemployed</option>
                            <option value="self_employed"{{ old('employment_status') === 'self_employed'? 'selected' : '' }}>Self Employed</option>
                            <option value="student"      {{ old('employment_status') === 'student'      ? 'selected' : '' }}>Student</option>
                            <option value="inactive"     {{ old('employment_status') === 'inactive'     ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('employment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-2"></i>Create Profile
            </button>
        </div>

    </form>
</div>
</div>

@endsection