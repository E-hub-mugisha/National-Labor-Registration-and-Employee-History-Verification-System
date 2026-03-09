@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')

<div class="row justify-content-center">
<div class="col-xl-9">

    <div class="section-header mb-4">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-person-circle me-2"></i>Edit Profile
        </h5>
        <small class="text-muted">Keep your profile updated to appear in employer searches</small>
    </div>

    <form method="POST" action="{{ route('employee.profile.update') }}">
        @csrf
        @method('PUT')

        {{-- Personal Information --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-person me-2 text-primary"></i>Personal Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">First Name</label>
                        <input type="text"
                               name="first_name"
                               class="form-control @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name', $employee->first_name) }}"
                               required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Middle Name</label>
                        <input type="text"
                               name="middle_name"
                               class="form-control"
                               value="{{ old('middle_name', $employee->middle_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Last Name</label>
                        <input type="text"
                               name="last_name"
                               class="form-control @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name', $employee->last_name) }}"
                               required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date of Birth</label>
                        <input type="date"
                               name="date_of_birth"
                               class="form-control @error('date_of_birth') is-invalid @enderror"
                               value="{{ old('date_of_birth', $employee->date_of_birth?->format('Y-m-d')) }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Gender</label>
                        <select name="gender"
                                class="form-select @error('gender') is-invalid @enderror">
                            <option value="">Select...</option>
                            <option value="male"   {{ old('gender', $employee->gender) === 'male'   ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $employee->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other"  {{ old('gender', $employee->gender) === 'other'  ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nationality</label>
                        <input type="text"
                               name="nationality"
                               class="form-control"
                               value="{{ old('nationality', $employee->nationality) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Professional Summary</label>
                        <textarea name="professional_summary"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Brief summary of your professional background...">{{ old('professional_summary', $employee->professional_summary) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Current Job Title</label>
                        <input type="text"
                               name="current_job_title"
                               class="form-control"
                               placeholder="e.g. Software Engineer"
                               value="{{ old('current_job_title', $employee->current_job_title) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Employment Status</label>
                        <select name="employment_status" class="form-select">
                            <option value="employed"      {{ old('employment_status', $employee->employment_status) === 'employed'      ? 'selected' : '' }}>Employed</option>
                            <option value="unemployed"    {{ old('employment_status', $employee->employment_status) === 'unemployed'    ? 'selected' : '' }}>Unemployed</option>
                            <option value="self_employed" {{ old('employment_status', $employee->employment_status) === 'self_employed' ? 'selected' : '' }}>Self Employed</option>
                            <option value="student"       {{ old('employment_status', $employee->employment_status) === 'student'       ? 'selected' : '' }}>Student</option>
                            <option value="inactive"      {{ old('employment_status', $employee->employment_status) === 'inactive'      ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        {{-- Location & Contact --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-geo-alt me-2 text-primary"></i>Location & Contact
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Province</label>
                        <select name="province" class="form-select">
                            <option value="">Select...</option>
                            @foreach(['Kigali City','Northern','Southern','Eastern','Western'] as $p)
                                <option value="{{ $p }}"
                                    {{ old('province', $employee->province) === $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">District</label>
                        <input type="text"
                               name="district"
                               class="form-control"
                               value="{{ old('district', $employee->district) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sector</label>
                        <input type="text"
                               name="sector"
                               class="form-control"
                               value="{{ old('sector', $employee->sector) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Primary Phone</label>
                        <input type="text"
                               name="phone_primary"
                               class="form-control"
                               value="{{ old('phone_primary', $employee->phone_primary) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Secondary Phone</label>
                        <input type="text"
                               name="phone_secondary"
                               class="form-control"
                               value="{{ old('phone_secondary', $employee->phone_secondary) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Personal Email</label>
                        <input type="email"
                               name="personal_email"
                               class="form-control"
                               value="{{ old('personal_email', $employee->personal_email) }}">
                    </div>

                </div>
            </div>
        </div>

        {{-- Skills --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-tools me-2 text-primary"></i>Skills
                </h6>
            </div>
            <div class="card-body">

                {{-- Existing Skills --}}
                @forelse($employee->skills as $skill)
                <div class="d-flex align-items-center justify-content-between mb-2 p-2 rounded"
                     style="background:#F8FAFB;">
                    <div>
                        <span class="fw-medium small">{{ $skill->skill_name }}</span>
                        <span class="badge ms-2"
                              style="background:var(--light-blue);color:var(--primary);">
                            {{ ucfirst($skill->proficiency_level) }}
                        </span>
                    </div>
                    <form method="POST"
                          action="{{ route('employee.skills.delete', $skill) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
                @empty
                    <p class="text-muted small mb-3">No skills added yet.</p>
                @endforelse

                {{-- Add New Skill --}}
                <div class="border rounded p-3 mt-3"
                     style="background:#F8FAFB;">
                    <div class="section-label mb-2" style="font-size:.75rem;font-weight:700;color:#9CA3AF;text-transform:uppercase;">
                        Add New Skill
                    </div>
                    <form method="POST" action="{{ route('employee.skills.store') }}">
                        @csrf
                        <div class="row g-2">
                            <div class="col-md-5">
                                <input type="text"
                                       name="skill_name"
                                       class="form-control form-control-sm"
                                       placeholder="Skill name e.g. Python">
                            </div>
                            <div class="col-md-4">
                                <select name="proficiency_level" class="form-select form-select-sm">
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate" selected>Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                    <option value="expert">Expert</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-plus me-1"></i>Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        {{-- Qualifications --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-mortarboard me-2 text-primary"></i>Qualifications
                </h6>
            </div>
            <div class="card-body">

                {{-- Existing Qualifications --}}
                @forelse($employee->qualifications as $qual)
                <div class="p-2 rounded mb-2" style="background:#F8FAFB;">
                    <div class="fw-medium small">{{ $qual->qualification_title }}</div>
                    <div class="text-muted small">
                        {{ $qual->institution_name }} · {{ $qual->duration }}
                    </div>
                </div>
                @empty
                    <p class="text-muted small mb-3">No qualifications added yet.</p>
                @endforelse

                {{-- Add New Qualification --}}
                <div class="border rounded p-3 mt-3" style="background:#F8FAFB;">
                    <div class="section-label mb-2" style="font-size:.75rem;font-weight:700;color:#9CA3AF;text-transform:uppercase;">
                        Add Qualification
                    </div>
                    <form method="POST" action="{{ route('employee.qualifications.store') }}">
                        @csrf
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text"
                                       name="qualification_title"
                                       class="form-control form-control-sm"
                                       placeholder="e.g. BSc Computer Science"
                                       required>
                            </div>
                            <div class="col-md-6">
                                <input type="text"
                                       name="institution_name"
                                       class="form-control form-control-sm"
                                       placeholder="Institution name"
                                       required>
                            </div>
                            <div class="col-md-4">
                                <select name="type" class="form-select form-select-sm">
                                    <option value="certificate">Certificate</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="bachelors">Bachelor's</option>
                                    <option value="masters">Master's</option>
                                    <option value="phd">PhD</option>
                                    <option value="professional">Professional</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="date"
                                       name="start_date"
                                       class="form-control form-control-sm"
                                       placeholder="Start date">
                            </div>
                            <div class="col-md-4">
                                <input type="date"
                                       name="end_date"
                                       class="form-control form-control-sm"
                                       placeholder="End date">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus me-1"></i>Add Qualification
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        {{-- Save Button --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('employee.dashboard') }}"
               class="btn btn-outline-secondary px-4">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-2"></i>Save Changes
            </button>
        </div>

    </form>
</div>
</div>

@endsection