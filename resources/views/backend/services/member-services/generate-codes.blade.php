@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Generate Referral Codes</h6>
            <p class="text-muted mb-0">Bulk generate referral codes for members</p>
        </div>
        <div>
            <a href="{{ route('member-services.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('member-services.bulk-generate') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label">Select Members <span class="text-danger">*</span></label>
                            <select class="form-select select2-multiple" name="member_ids[]" multiple required>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->name }} ({{ $member->email }})
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple members</small>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Select Service Categories <span class="text-danger">*</span></label>
                            <div class="row">
                                @foreach($categories as $category)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="service_category_ids[]" 
                                               value="{{ $category->id }}" 
                                               id="category_{{ $category->id }}">
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-xs me-2" style="background-color: {{ $category->color }};">
                                                    <i class="isax {{ $category->icon }}"></i>
                                                </span>
                                                <span>{{ $category->name }}</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <div class="d-flex align-items-center">
                                <i class="isax isax-warning-2 me-2"></i>
                                <div>
                                    <h6 class="mb-1">Note</h6>
                                    <p class="mb-0">
                                        This will generate referral codes for selected members in selected categories.<br>
                                        Existing assignments will be skipped automatically.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="isax isax-link me-1"></i> Generate Codes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Quick Stats</h6>
                    <div class="mb-3">
                        <p class="mb-1">Total Members</p>
                        <h4 class="mb-0">{{ $members->count() }}</h4>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1">Total Categories</p>
                        <h4 class="mb-0">{{ $categories->count() }}</h4>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1">Total Assignments</p>
                        <h4 class="mb-0">{{ \App\Models\MemberServiceCategory::count() }}</h4>
                    </div>
                    
                    <hr>
                    
                    <h6 class="mb-3">Code Format</h6>
                    <div class="alert alert-light">
                        <p class="mb-2"><strong>Format:</strong></p>
                        <code>[CATEGORY PREFIX]-[MEMBER INITIALS]-[RANDOM 4]</code>
                        <p class="mt-2 mb-1"><strong>Example:</strong></p>
                        <code>MAT-JOH-XY7Z</code>
                        <p class="mt-2 mb-0 text-muted">Where:</p>
                        <ul class="mb-0">
                            <li>MAT = Matrimony (first 3 letters of category)</li>
                            <li>JOH = John (first 3 letters of member name)</li>
                            <li>XY7Z = Random 4 characters</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Initialize Select2
    $('.select2-multiple').select2({
        placeholder: "Select members...",
        allowClear: true
    });
    
    // Select all categories
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        document.querySelectorAll('input[name="service_category_ids[]"]').forEach(checkbox => {
            checkbox.checked = false;
        });
    });
</script>
@endpush
@endsection