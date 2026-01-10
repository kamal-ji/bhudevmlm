@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Assign Service to Member</h6>
            <p class="text-muted mb-0">Assign service category to member and generate referral code</p>
        </div>
        <div>
            <a href="{{ route('member-services.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('member-services.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Select Member <span class="text-danger">*</span></label>
                            <select class="form-select" name="member_id" required>
                                <option value="">Choose member...</option>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->name }} ({{ $member->email }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Select Service Category <span class="text-danger">*</span></label>
                            <select class="form-select" name="service_category_id" required>
                                <option value="">Choose service category...</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-rate="{{ $category->commission_rate }}">
                                    {{ $category->name }} ({{ $category->commission_rate }}% commission)
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Commission Rate (%)</label>
                            <input type="number" class="form-control" name="commission_rate" 
                                   id="commission_rate" step="0.01" min="0" max="100">
                            <small class="text-muted">Leave empty to use category default rate</small>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="isax isax-info-circle me-2"></i>
                                <div>
                                    <h6 class="mb-1">Referral Code Generation</h6>
                                    <p class="mb-0">A unique referral code will be automatically generated for this member in the selected service category.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('member-services.index') }}" class="btn btn-light">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="isax isax-add me-1"></i> Assign Service
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-fill commission rate based on selected category
    document.querySelector('select[name="service_category_id"]').addEventListener('change', function(e) {
        const selectedOption = this.options[this.selectedIndex];
        const defaultRate = selectedOption.getAttribute('data-rate');
        
        if (defaultRate && !document.querySelector('#commission_rate').value) {
            document.querySelector('#commission_rate').value = defaultRate;
        }
    });
</script>
@endpush
@endsection