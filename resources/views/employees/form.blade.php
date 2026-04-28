@php $isEdit = isset($employee) && $employee->exists; @endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- ── Left column – personal ──────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Card: Personal Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h3 class="font-semibold text-slate-800">Personal Information</h3>
            </div>
            <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2">

                {{-- National ID --}}
                <div class="sm:col-span-2">
                    <label for="national_id" class="form-label">National ID <span class="text-red-500">*</span></label>
                    <input type="text" id="national_id" name="national_id"
                        value="{{ old('national_id', $employee->national_id ?? '') }}"
                        class="form-input font-mono @error('national_id') border-red-400 @enderror"
                        placeholder="e.g. 1234567890123">
                    @error('national_id') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- First name --}}
                <div>
                    <label for="first_name" class="form-label">First Name <span class="text-red-500">*</span></label>
                    <input type="text" id="first_name" name="first_name"
                        value="{{ old('first_name', $employee->first_name ?? '') }}"
                        class="form-input @error('first_name') border-red-400 @enderror">
                    @error('first_name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Last name --}}
                <div>
                    <label for="last_name" class="form-label">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" id="last_name" name="last_name"
                        value="{{ old('last_name', $employee->last_name ?? '') }}"
                        class="form-input @error('last_name') border-red-400 @enderror">
                    @error('last_name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Middle name --}}
                <div>
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name"
                        value="{{ old('middle_name', $employee->middle_name ?? '') }}"
                        class="form-input @error('middle_name') border-red-400 @enderror">
                    @error('middle_name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Date of birth --}}
                <div>
                    <label for="date_of_birth" class="form-label">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" id="date_of_birth" name="date_of_birth"
                        value="{{ old('date_of_birth', isset($employee->date_of_birth) ? $employee->date_of_birth->format('Y-m-d') : '') }}"
                        class="form-input @error('date_of_birth') border-red-400 @enderror">
                    @error('date_of_birth') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Gender --}}
                <div>
                    <label for="gender" class="form-label">Gender <span class="text-red-500">*</span></label>
                    <select id="gender" name="gender"
                        class="form-input @error('gender') border-red-400 @enderror">
                        <option value="">Select gender</option>
                        @foreach(['male','female','other'] as $g)
                        <option value="{{ $g }}" {{ old('gender', $employee->gender ?? '') === $g ? 'selected' : '' }}>
                            {{ ucfirst($g) }}
                        </option>
                        @endforeach
                    </select>
                    @error('gender') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="form-label">Phone <span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone"
                        value="{{ old('phone', $employee->phone ?? '') }}"
                        class="form-input @error('phone') border-red-400 @enderror"
                        placeholder="+000 000 000 000">
                    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email', $employee->email ?? '') }}"
                        class="form-input @error('email') border-red-400 @enderror"
                        placeholder="employee@example.com">
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- District --}}
                <div>
                    <label for="district" class="form-label">District</label>
                    <input type="text" id="district" name="district"
                        value="{{ old('district', $employee->district ?? '') }}"
                        class="form-input @error('district') border-red-400 @enderror">
                    @error('district') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Province --}}
                <div>
                    <label for="province" class="form-label">Province</label>
                    <input type="text" id="province" name="province"
                        value="{{ old('province', $employee->province ?? '') }}"
                        class="form-input @error('province') border-red-400 @enderror">
                    @error('province') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Highest qualification --}}
                <div class="sm:col-span-2">
                    <label for="highest_qualification" class="form-label">Highest Qualification</label>
                    <input type="text" id="highest_qualification" name="highest_qualification"
                        value="{{ old('highest_qualification', $employee->highest_qualification ?? '') }}"
                        class="form-input @error('highest_qualification') border-red-400 @enderror"
                        placeholder="e.g. Bachelor of Science in Computer Science">
                    @error('highest_qualification') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Skills --}}
                <div class="sm:col-span-2">
                    <label for="skills" class="form-label">Skills</label>
                    <textarea id="skills" name="skills" rows="3"
                        class="form-input resize-none @error('skills') border-red-400 @enderror"
                        placeholder="List relevant skills…">{{ old('skills', $employee->skills ?? '') }}</textarea>
                    @error('skills') <p class="form-error">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- Card: Employment --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h3 class="font-semibold text-slate-800">Employment</h3>
            </div>
            <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2">

                {{-- Current employer --}}
                <div>
                    <label for="current_employer_id" class="form-label">Current Employer</label>
                    <select id="current_employer_id" name="current_employer_id"
                        class="form-input @error('current_employer_id') border-red-400 @enderror">
                        <option value="">— None / Unemployed —</option>
                        @foreach($employers as $employer)
                        <option value="{{ $employer->id }}"
                            {{ old('current_employer_id', $employee->current_employer_id ?? '') == $employer->id ? 'selected' : '' }}>
                            {{ $employer->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('current_employer_id') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                    <select id="status" name="status"
                        class="form-input @error('status') border-red-400 @enderror">
                        @foreach(['active','unemployed','blacklisted'] as $s)
                        <option value="{{ $s }}"
                            {{ old('status', $employee->status ?? 'unemployed') === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
                    </select>
                    @error('status') <p class="form-error">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>
    </div>

    {{-- ── Right column – photo ─────────────────────────────────────────── --}}
    <div class="space-y-6">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h3 class="font-semibold text-slate-800">Photo</h3>
            </div>
            <div class="flex flex-col items-center gap-4 p-6">

                {{-- Preview --}}
                <div id="photo-preview" class="relative">
                    @if($isEdit && $employee->photo)
                    <img id="preview-img"
                        src="{{ Storage::url($employee->photo) }}"
                        alt="Current photo"
                        class="h-36 w-36 rounded-full object-cover ring-4 ring-white shadow-md">
                    @else
                    <div id="preview-placeholder"
                        class="flex h-36 w-36 items-center justify-center rounded-full bg-slate-100 text-slate-400 ring-4 ring-white shadow-md">
                        <svg class="w-14 h-14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <img id="preview-img" src="" alt="" class="hidden h-36 w-36 rounded-full object-cover ring-4 ring-white shadow-md">
                    @endif
                </div>

                <label for="photo"
                    class="cursor-pointer rounded-lg border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-center text-sm text-slate-600 hover:border-blue-400 hover:bg-blue-50 transition w-full">
                    <svg class="mx-auto mb-1 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Click to upload
                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden"
                        onchange="previewPhoto(this)">
                </label>
                <p class="text-xs text-slate-400">JPG, PNG or WEBP · Max 2 MB</p>

                @error('photo') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

</div>

{{-- ── Form actions ─────────────────────────────────────────────────────── --}}
<div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
    <a href="{{ $isEdit ? route('employees.show', $employee) : route('employees.index') }}"
        class="rounded-lg border border-slate-200 bg-white px-5 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
        Cancel
    </a>
    <button type="submit"
        class="rounded-lg bg-blue-700 px-6 py-2 text-sm font-semibold text-white shadow hover:bg-blue-800 transition">
        {{ $isEdit ? 'Save Changes' : 'Create Employee' }}
    </button>
</div>

{{-- ── Inline styles / JS for this partial ────────────────────────────── --}}
<style>
    .form-label {
        @apply block mb-1.5 text-sm font-medium text-slate-700;
    }

    .form-input {
        @apply block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition;
    }

    .form-error {
        @apply mt-1 text-xs text-red-600;
    }
</style>

<script>
    function previewPhoto(input) {
        const img = document.getElementById('preview-img');
        const placeholder = document.getElementById('preview-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                img.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>