@extends('layouts.app')
@section('title', 'Submit Professional Feedback')

@section('content')

<div class="row justify-content-center">
<div class="col-xl-8">

    <div class="section-header mb-4">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-star me-2"></i>Submit Professional Feedback
        </h5>
        <small class="text-muted">
            {{ $record->employee->full_name }} ·
            {{ $record->job_title }} ·
            {{ $record->start_date->format('M Y') }} —
            {{ $record->end_date->format('M Y') }}
        </small>
    </div>

    <form method="POST" action="{{ route('employer.feedback.store', $record) }}">
        @csrf

        {{-- Ratings --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-star-half me-2 text-primary"></i>Performance Ratings
                </h6>
                <small class="text-muted">Rate each dimension from 1 (Poor) to 5 (Excellent)</small>
            </div>
            <div class="card-body">
                <div class="row g-4">

                    @foreach([
                        ['name' => 'rating_overall',          'label' => 'Overall Performance',  'required' => true],
                        ['name' => 'rating_punctuality',      'label' => 'Punctuality',           'required' => true],
                        ['name' => 'rating_teamwork',         'label' => 'Teamwork',              'required' => true],
                        ['name' => 'rating_communication',    'label' => 'Communication',         'required' => true],
                        ['name' => 'rating_technical_skills', 'label' => 'Technical Skills',      'required' => true],
                        ['name' => 'rating_integrity',        'label' => 'Integrity',             'required' => true],
                        ['name' => 'rating_adaptability',     'label' => 'Adaptability',          'required' => true],
                        ['name' => 'rating_leadership',       'label' => 'Leadership',            'required' => false],
                    ] as $rating)

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            {{ $rating['label'] }}
                            @if($rating['required'])
                                <span class="text-danger">*</span>
                            @else
                                <span class="text-muted small">(optional)</span>
                            @endif
                        </label>
                        <div class="d-flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input type="radio"
                                       name="{{ $rating['name'] }}"
                                       value="{{ $i }}"
                                       id="{{ $rating['name'] }}_{{ $i }}"
                                       class="form-check-input"
                                       {{ old($rating['name']) == $i ? 'checked' : '' }}
                                       {{ $rating['required'] ? 'required' : '' }}>
                                <label class="form-check-label"
                                       for="{{ $rating['name'] }}_{{ $i }}">
                                    {{ $i }}
                                </label>
                            </div>
                            @endfor
                        </div>
                        @error($rating['name'])
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            1=Poor · 2=Below Avg · 3=Average · 4=Good · 5=Excellent
                        </small>
                    </div>

                    @endforeach

                </div>
            </div>
        </div>

        {{-- Qualitative Feedback --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-chat-square-text me-2 text-primary"></i>
                    Qualitative Assessment
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Strengths</label>
                        <textarea name="strengths"
                                  class="form-control @error('strengths') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Key strengths demonstrated...">{{ old('strengths') }}</textarea>
                        @error('strengths')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Areas for Improvement</label>
                        <textarea name="areas_for_improvement"
                                  class="form-control @error('areas_for_improvement') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Areas that need development...">{{ old('areas_for_improvement') }}</textarea>
                        @error('areas_for_improvement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">General Comments</label>
                        <textarea name="general_comments"
                                  class="form-control @error('general_comments') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Any additional comments...">{{ old('general_comments') }}</textarea>
                        @error('general_comments')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Would Rehire --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Would you rehire this employee?
                            <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input type="radio"
                                       name="would_rehire"
                                       value="1"
                                       id="rehire_yes"
                                       class="form-check-input"
                                       {{ old('would_rehire') == '1' ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label text-success fw-semibold"
                                       for="rehire_yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio"
                                       name="would_rehire"
                                       value="0"
                                       id="rehire_no"
                                       class="form-check-input"
                                       {{ old('would_rehire') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label text-danger fw-semibold"
                                       for="rehire_no">
                                    No
                                </label>
                            </div>
                        </div>
                        @error('would_rehire')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Rehire Condition
                        </label>
                        <input type="text"
                               name="rehire_condition"
                               class="form-control"
                               placeholder="If conditional, specify..."
                               value="{{ old('rehire_condition') }}">
                    </div>

                </div>
            </div>
        </div>

        {{-- Misconduct --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-exclamation-triangle me-2 text-danger"></i>
                    Misconduct Report
                    <span class="text-muted fw-normal small ms-1">(if applicable)</span>
                </h6>
            </div>
            <div class="card-body">

                <div class="form-check mb-3">
                    <input type="checkbox"
                           name="has_misconduct_flag"
                           value="1"
                           id="has_misconduct"
                           class="form-check-input"
                           {{ old('has_misconduct_flag') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold text-danger"
                           for="has_misconduct">
                        Flag this employee for misconduct
                    </label>
                </div>

                <div id="misconductSection"
                     style="{{ old('has_misconduct_flag') ? '' : 'display:none;' }}">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Misconduct Categories
                        </label>
                        <div class="row g-2">
                            @foreach(['theft','harassment','insubordination','substance_abuse','fraud','violence','other'] as $cat)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox"
                                           name="misconduct_categories[]"
                                           value="{{ $cat }}"
                                           id="cat_{{ $cat }}"
                                           class="form-check-input"
                                           {{ in_array($cat, old('misconduct_categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label small"
                                           for="cat_{{ $cat }}">
                                        {{ ucfirst(str_replace('_', ' ', $cat)) }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Misconduct Details</label>
                        <textarea name="misconduct_details"
                                  class="form-control @error('misconduct_details') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Describe the misconduct in detail...">{{ old('misconduct_details') }}</textarea>
                        @error('misconduct_details')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox"
                                       name="misconduct_legally_adjudicated"
                                       value="1"
                                       id="legally_adj"
                                       class="form-check-input"
                                       {{ old('misconduct_legally_adjudicated') ? 'checked' : '' }}>
                                <label class="form-check-label small"
                                       for="legally_adj">
                                    Legally adjudicated
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="text"
                                   name="misconduct_case_reference"
                                   class="form-control form-control-sm"
                                   placeholder="Case reference number (if any)"
                                   value="{{ old('misconduct_case_reference') }}">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Visibility --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-eye me-2 text-primary"></i>Feedback Visibility
                </h6>
            </div>
            <div class="card-body">
                <select name="visibility"
                        class="form-select @error('visibility') is-invalid @enderror"
                        required>
                    <option value="all_employers"
                            {{ old('visibility') === 'all_employers' ? 'selected' : '' }}>
                        All Verified Employers
                    </option>
                    <option value="verified_employers_only"
                            {{ old('visibility') === 'verified_employers_only' ? 'selected' : '' }}>
                        Verified Employers Only
                    </option>
                    <option value="hidden"
                            {{ old('visibility') === 'hidden' ? 'selected' : '' }}>
                        Hidden (Admin Only)
                    </option>
                </select>
                @error('visibility')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted mt-1 d-block">
                    All feedback is reviewed by an administrator before publication.
                </small>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('employer.dashboard') }}"
               class="btn btn-outline-secondary px-4">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-send me-2"></i>Submit Feedback
            </button>
        </div>

    </form>
</div>
</div>

@push('scripts')
<script>
    document.getElementById('has_misconduct').addEventListener('change', function () {
        document.getElementById('misconductSection').style.display =
            this.checked ? 'block' : 'none';
    });
</script>
@endpush

@endsection