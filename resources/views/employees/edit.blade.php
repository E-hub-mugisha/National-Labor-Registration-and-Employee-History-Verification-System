@extends('layouts.app')

@section('title', isset($employee) && $employee->exists ? 'Edit Employee' : 'New Employee')

@section('content')

@php $isEdit = isset($employee) && $employee->exists; @endphp

<style>
    /* ── Required star & optional tag ── */
    .req-star {
        color: #DC2626;
        font-size: .85em;
        margin-left: 1px;
    }

    .optional-tag {
        font-size: .68rem;
        font-weight: 500;
        color: var(--slate-400);
        background: var(--slate-100);
        padding: 1px 6px;
        border-radius: 20px;
        margin-left: .3rem;
        vertical-align: middle;
    }

    /* ── Card header icon ── */
    .card-header-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: var(--blue-100);
        color: var(--navy-600);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        flex-shrink: 0;
    }

    /* ── Form hint ── */
    .form-hint {
        font-size: .73rem;
        color: var(--slate-400);
        margin-top: .4rem;
        line-height: 1.4;
    }

    /* ── Input group fixes ── */
    .input-group .input-group-text {
        background: var(--slate-100);
        border-color: var(--slate-200);
        color: var(--slate-400);
        font-size: .85rem;
    }

    .input-group .form-control {
        border-left: none;
    }

    .input-group .form-control:focus {
        border-color: var(--navy-500);
        box-shadow: none;
    }

    .input-group:focus-within .input-group-text {
        border-color: var(--navy-500);
        color: var(--navy-600);
    }

    /* ── Monospace for National ID ── */
    .font-mono {
        font-family: 'DM Mono', monospace;
        letter-spacing: .03em;
    }

    /* ── Photo preview ── */
    .photo-preview-wrap {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid var(--slate-200);
        background: var(--slate-50);
        position: relative;
        transition: var(--transition);
    }

    .photo-preview-wrap:hover {
        border-color: var(--navy-500);
    }

    .photo-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .photo-preview-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--slate-100);
    }

    /* ── Upload zone ── */
    .upload-zone {
        display: block;
        padding: .85rem 1rem;
        border: 1.5px dashed var(--slate-300);
        border-radius: var(--radius-md);
        background: var(--slate-50);
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
    }

    .upload-zone:hover {
        border-color: var(--navy-500);
        background: var(--blue-100);
    }

    .upload-zone-icon {
        font-size: 1.4rem;
        color: var(--slate-400);
        display: block;
        margin-bottom: .25rem;
        transition: var(--transition);
    }

    .upload-zone:hover .upload-zone-icon {
        color: var(--navy-600);
    }

    .upload-zone-label {
        font-size: .8rem;
        font-weight: 600;
        color: var(--slate-600);
    }

    .upload-zone-hint {
        font-size: .7rem;
        color: var(--slate-400);
        margin-top: .15rem;
    }

    /* ── Tips card ── */
    .tips-card {
        border-color: #FEF3C7;
        background: #FFFBEB;
    }

    .tips-icon {
        width: 30px;
        height: 30px;
        background: #FDE68A;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #92400E;
        flex-shrink: 0;
    }

    .tips-title {
        font-size: .82rem;
        font-weight: 700;
        color: #92400E;
        margin-top: .2rem;
    }

    .tips-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tips-list li {
        font-size: .78rem;
        color: #92400E;
        opacity: .85;
        padding: .3rem 0;
        border-bottom: 1px solid rgba(146, 64, 14, .1);
        display: flex;
        gap: .5rem;
        align-items: flex-start;
        line-height: 1.4;
    }

    .tips-list li:last-child {
        border-bottom: none;
    }

    .tips-list li::before {
        content: '·';
        font-weight: 900;
        color: #D97706;
        flex-shrink: 0;
        margin-top: .05rem;
    }

    /* ── Form actions bar ── */
    .form-actions-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .75rem;
        padding: 1.1rem 0;
        border-top: 1px solid var(--slate-200);
    }

    /* ── Validation states ── */
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #DC2626;
        background-image: none;
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .12);
    }

    .invalid-feedback {
        font-size: .73rem;
        color: #DC2626;
        display: block;
    }
</style>

{{-- ── Page Header ───────────────────────────────────────────────────────── --}}
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                <li class="breadcrumb-item active">{{ $isEdit ? 'Edit Employee' : 'New Employee' }}</li>
            </ol>
        </nav>
        <h1 class="page-title">{{ $isEdit ? 'Edit Employee' : 'Add New Employee' }}</h1>
        <p class="page-subtitle">
            {{ $isEdit ? 'Update the details for ' . $employee->full_name : 'Register a new employee in the national labor registry' }}
        </p>
    </div>
</div>

<form method="POST"
    action="{{ $isEdit ? route('employees.update', $employee) : route('employees.store') }}"
    enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="row g-4">

        {{-- ══════════════════════════════════
             LEFT COLUMN  (personal + employment)
        ══════════════════════════════════ --}}
        <div class="col-12 col-lg-8">

            {{-- Card: Personal Information --}}
            <div class="card mb-4">
                <div class="card-header">
                    <span class="card-header-icon">
                        <i class="bi bi-person-vcard"></i>
                    </span>
                    <span class="card-header-title">Personal Information</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        {{-- National ID --}}
                        <div class="col-12">
                            <label for="national_id" class="form-label">
                                National ID <span class="req-star">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-credit-card-2-front" style="font-size:.85rem;"></i>
                                </span>
                                <input type="text"
                                    id="national_id"
                                    name="national_id"
                                    value="{{ old('national_id', $employee->national_id ?? '') }}"
                                    placeholder="e.g. 1234567890123456"
                                    class="form-control font-mono @error('national_id') is-invalid @enderror">
                                @error('national_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- First name --}}
                        <div class="col-12 col-sm-6">
                            <label for="first_name" class="form-label">First Name <span class="req-star">*</span></label>
                            <input type="text"
                                id="first_name"
                                name="first_name"
                                value="{{ old('first_name', $employee->first_name ?? '') }}"
                                class="form-control @error('first_name') is-invalid @enderror">
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Last name --}}
                        <div class="col-12 col-sm-6">
                            <label for="last_name" class="form-label">Last Name <span class="req-star">*</span></label>
                            <input type="text"
                                id="last_name"
                                name="last_name"
                                value="{{ old('last_name', $employee->last_name ?? '') }}"
                                class="form-control @error('last_name') is-invalid @enderror">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Middle name --}}
                        <div class="col-12 col-sm-6">
                            <label for="middle_name" class="form-label">
                                Middle Name
                                <span class="optional-tag">optional</span>
                            </label>
                            <input type="text"
                                id="middle_name"
                                name="middle_name"
                                value="{{ old('middle_name', $employee->middle_name ?? '') }}"
                                class="form-control @error('middle_name') is-invalid @enderror">
                            @error('middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Date of birth --}}
                        <div class="col-12 col-sm-6">
                            <label for="date_of_birth" class="form-label">Date of Birth <span class="req-star">*</span></label>
                            <input type="date"
                                id="date_of_birth"
                                name="date_of_birth"
                                value="{{ old('date_of_birth', isset($employee->date_of_birth) ? $employee->date_of_birth->format('Y-m-d') : '') }}"
                                class="form-control @error('date_of_birth') is-invalid @enderror">
                            @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gender --}}
                        <div class="col-12 col-sm-6">
                            <label for="gender" class="form-label">Gender <span class="req-star">*</span></label>
                            <select id="gender"
                                name="gender"
                                class="form-select @error('gender') is-invalid @enderror">
                                <option value="">Select gender…</option>
                                @foreach(['male','female','other'] as $g)
                                <option value="{{ $g }}"
                                    {{ old('gender', $employee->gender ?? '') === $g ? 'selected' : '' }}>
                                    {{ ucfirst($g) }}
                                </option>
                                @endforeach
                            </select>
                            @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="col-12 col-sm-6">
                            <label for="phone" class="form-label">Phone <span class="req-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-telephone" style="font-size:.85rem;"></i>
                                </span>
                                <input type="text"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', $employee->phone ?? '') }}"
                                    placeholder="+250 7XX XXX XXX"
                                    class="form-control @error('phone') is-invalid @enderror">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-12 col-sm-6">
                            <label for="email" class="form-label">Email <span class="req-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope" style="font-size:.85rem;"></i>
                                </span>
                                <input type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $employee->email ?? '') }}"
                                    placeholder="name@example.com"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Card: Location --}}
            <div class="card mb-4">
                <div class="card-header">
                    <span class="card-header-icon">
                        <i class="bi bi-geo-alt"></i>
                    </span>
                    <span class="card-header-title">Location</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        {{-- District --}}
                        <div class="col-12 col-sm-6">
                            <label for="district" class="form-label">
                                District
                                <span class="optional-tag">optional</span>
                            </label>
                            <input type="text"
                                id="district"
                                name="district"
                                value="{{ old('district', $employee->district ?? '') }}"
                                placeholder="e.g. Gasabo"
                                class="form-control @error('district') is-invalid @enderror">
                            @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Province --}}
                        <div class="col-12 col-sm-6">
                            <label for="province" class="form-label">
                                Province
                                <span class="optional-tag">optional</span>
                            </label>
                            <input type="text"
                                id="province"
                                name="province"
                                value="{{ old('province', $employee->province ?? '') }}"
                                placeholder="e.g. Kigali City"
                                class="form-control @error('province') is-invalid @enderror">
                            @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Card: Qualifications & Skills --}}
            <div class="card mb-4">
                <div class="card-header">
                    <span class="card-header-icon">
                        <i class="bi bi-mortarboard"></i>
                    </span>
                    <span class="card-header-title">Qualifications &amp; Skills</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        {{-- Highest qualification --}}
                        <div class="col-12">
                            <label for="highest_qualification" class="form-label">
                                Highest Qualification
                                <span class="optional-tag">optional</span>
                            </label>
                            <input type="text"
                                id="highest_qualification"
                                name="highest_qualification"
                                value="{{ old('highest_qualification', $employee->highest_qualification ?? '') }}"
                                placeholder="e.g. Bachelor of Science in Computer Science"
                                class="form-control @error('highest_qualification') is-invalid @enderror">
                            @error('highest_qualification')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Skills --}}
                        <div class="col-12">
                            <label for="skills" class="form-label">
                                Skills
                                <span class="optional-tag">optional</span>
                            </label>
                            <textarea id="skills"
                                name="skills"
                                rows="4"
                                placeholder="List relevant skills, separated by commas or new lines…"
                                class="form-control @error('skills') is-invalid @enderror"
                                style="resize:vertical;">{{ old('skills', $employee->skills ?? '') }}</textarea>
                            @error('skills')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Card: Employment --}}
            {{-- Card: Employment --}}
            <div class="card mb-0">
                <div class="card-header">
                    <span class="card-header-icon">
                        <i class="bi bi-briefcase"></i>
                    </span>
                    <span class="card-header-title">Employment</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        {{-- Current Employer ──────────────────────────────────────── --}}
                        <div class="col-12 col-sm-6">
                            <label for="current_employer_id" class="form-label">
                                Current Employer
                                @if(in_array(auth()->user()->role, ['admin', 'government']))
                                <span class="optional-tag">optional</span>
                                @endif
                            </label>

                            @if(in_array(auth()->user()->role, ['admin', 'government']))
                            {{-- Admin / Gov: free selection --}}
                            <select id="current_employer_id"
                                name="current_employer_id"
                                class="form-select @error('current_employer_id') is-invalid @enderror"
                                onchange="syncStatusToEmployer(this)">
                                <option value="">— None / Unemployed —</option>
                                @foreach($employers as $employer)
                                <option value="{{ $employer->id }}"
                                    {{ old('current_employer_id', $employee->current_employer_id ?? '') == $employer->id ? 'selected' : '' }}>
                                    {{ $employer->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-hint">
                                <i class="bi bi-info-circle me-1"></i>
                                Leave blank if the employee is currently unemployed.
                            </div>

                            @else
                            {{-- Employer: locked to own company --}}
                            <input type="hidden"
                                name="current_employer_id"
                                value="{{ auth()->user()->employer->id }}">
                            <input type="text"
                                class="form-control"
                                value="{{ auth()->user()->employer->name }}"
                                disabled>
                            <div class="form-hint">
                                <i class="bi bi-lock me-1"></i>
                                Employees you register are automatically linked to your organisation.
                            </div>
                            @endif

                            @error('current_employer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status ──────────────────────────────────────────────────── --}}
                        <div class="col-12 col-sm-6">
                            <label for="status" class="form-label">Status <span class="req-star">*</span></label>
                            <select id="status"
                                name="status"
                                class="form-select @error('status') is-invalid @enderror">
                                @foreach(['active','unemployed','blacklisted'] as $s)
                                <option value="{{ $s }}"
                                    {{ old('status', $employee->status ?? 'unemployed') === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                                @endforeach
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-hint">
                                <i class="bi bi-info-circle me-1"></i>
                                Setting to <em>Blacklisted</em> will flag this employee across all employer accounts.
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <script>
                /**
                 * When admin/gov changes the employer dropdown, auto-set a sensible
                 * default status (active if an employer is chosen, unemployed if blank).
                 * The user can still override manually.
                 */
                function syncStatusToEmployer(select) {
                    const statusSelect = document.getElementById('status');
                    if (!statusSelect) return;

                    if (select.value) {
                        // An employer was chosen → default to active
                        if (statusSelect.value === 'unemployed') {
                            statusSelect.value = 'active';
                        }
                    } else {
                        // Cleared → default to unemployed
                        if (statusSelect.value === 'active') {
                            statusSelect.value = 'unemployed';
                        }
                    }
                }
            </script>

        </div>

        {{-- ══════════════════════════════════
             RIGHT COLUMN  (photo + summary)
        ══════════════════════════════════ --}}
        <div class="col-12 col-lg-4">

            {{-- Card: Photo --}}
            <div class="card mb-4">
                <div class="card-header">
                    <span class="card-header-icon">
                        <i class="bi bi-camera"></i>
                    </span>
                    <span class="card-header-title">Profile Photo</span>
                </div>
                <div class="card-body text-center">

                    {{-- Avatar preview --}}
                    <div class="photo-preview-wrap mx-auto mb-3" id="photo-wrap">
                        @if($isEdit && $employee->photo)
                        <img id="preview-img"
                            src="{{ Storage::url($employee->photo) }}"
                            alt="Profile photo"
                            class="photo-preview-img">
                        <div id="preview-placeholder" class="photo-preview-placeholder d-none">
                            <i class="bi bi-person" style="font-size:2.5rem;color:var(--slate-400);"></i>
                        </div>
                        @else
                        <img id="preview-img" src="" alt="" class="photo-preview-img d-none">
                        <div id="preview-placeholder" class="photo-preview-placeholder">
                            <i class="bi bi-person" style="font-size:2.5rem;color:var(--slate-400);"></i>
                        </div>
                        @endif
                    </div>

                    {{-- Upload zone --}}
                    <label for="photo" class="upload-zone w-100" id="upload-zone">
                        <i class="bi bi-cloud-arrow-up upload-zone-icon"></i>
                        <div class="upload-zone-label">Click to upload photo</div>
                        <div class="upload-zone-hint">JPG, PNG or WEBP · Max 2 MB</div>
                        <input type="file"
                            id="photo"
                            name="photo"
                            accept="image/*"
                            class="d-none"
                            onchange="previewPhoto(this)">
                    </label>

                    @error('photo')
                    <div class="text-danger mt-2" style="font-size:.78rem;">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                    @enderror

                </div>
            </div>

            {{-- Card: Form tips --}}
            <div class="card tips-card">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-2 mb-3">
                        <span class="tips-icon"><i class="bi bi-lightbulb"></i></span>
                        <div>
                            <div class="tips-title">Registry Guidelines</div>
                        </div>
                    </div>
                    <ul class="tips-list">
                        <li>National ID must match the NIDA database exactly.</li>
                        <li>Use the employee's legal name as it appears on their ID.</li>
                        <li>Verify the phone number is reachable before submitting.</li>
                        <li>Only upload a clear, recent passport-style photo.</li>
                    </ul>
                </div>
            </div>

        </div>

    </div>{{-- /row --}}

    {{-- ── Form Actions ──────────────────────────────────────────────────── --}}
    <div class="form-actions-bar mt-4">
        <a href="{{ $isEdit ? route('employees.show', $employee) : route('employees.index') }}"
            class="btn btn-outline-secondary">
            <i class="bi bi-x-lg me-1"></i> Cancel
        </a>
        <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-{{ $isEdit ? 'floppy' : 'person-check' }} me-1"></i>
            {{ $isEdit ? 'Save Changes' : 'Create Employee' }}
        </button>
    </div>

</form>





<script>
    function previewPhoto(input) {
        const img = document.getElementById('preview-img');
        const placeholder = document.getElementById('preview-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                img.classList.remove('d-none');
                placeholder?.classList.add('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Drag-and-drop on upload zone
    const zone = document.getElementById('upload-zone');

    zone?.addEventListener('dragover', e => {
        e.preventDefault();
        zone.style.borderColor = 'var(--navy-500)';
        zone.style.background = 'var(--blue-100)';
    });

    zone?.addEventListener('dragleave', () => {
        zone.style.borderColor = '';
        zone.style.background = '';
    });

    zone?.addEventListener('drop', e => {
        e.preventDefault();
        zone.style.borderColor = '';
        zone.style.background = '';
        const fileInput = document.getElementById('photo');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            previewPhoto(fileInput);
        }
    });
</script>
@endsection