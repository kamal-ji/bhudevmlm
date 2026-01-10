@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Edit Service Package</h6>
            <p class="text-muted mb-0">Update service package details</p>
        </div>
        <div>
            <a href="{{ route('packages.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('packages.update', $package->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Service Category <span class="text-danger">*</span></label>
                            <select class="form-select" name="service_category_id" required>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ $package->service_category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->commission_rate }}% commission)
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Package Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required 
                                   value="{{ old('name', $package->name) }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="price" 
                                   step="0.01" min="0" required 
                                   value="{{ old('price', $package->price) }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Duration (Days)</label>
                            <input type="number" class="form-control" name="duration_days" 
                                   min="1" value="{{ old('duration_days', $package->duration_days) }}">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3">{{ old('description', $package->description) }}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Commission Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="commission_type" required id="commission_type">
                                <option value="percentage" {{ $package->commission_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ $package->commission_type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                <option value="both" {{ $package->commission_type == 'both' ? 'selected' : '' }}>Percentage + Fixed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6" id="percentage_field">
                        <div class="mb-3">
                            <label class="form-label">Commission Percentage (%)</label>
                            <input type="number" class="form-control" name="commission_percentage" 
                                   step="0.01" min="0" max="100" 
                                   value="{{ old('commission_percentage', $package->commission_percentage) }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6" id="fixed_field" style="{{ $package->commission_type == 'fixed' || $package->commission_type == 'both' ? '' : 'display: none;' }}">
                        <div class="mb-3">
                            <label class="form-label">Fixed Commission Amount ($)</label>
                            <input type="number" class="form-control" name="commission_amount" 
                                   step="0.01" min="0" 
                                   value="{{ old('commission_amount', $package->commission_amount) }}">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Features</label>
                            <div id="features-container">
                                @if($package->features && count($package->features) > 0)
                                    @foreach($package->features as $index => $feature)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="features[]" 
                                               value="{{ $feature }}">
                                        <button type="button" class="btn btn-danger remove-feature">
                                            <i class="isax isax-minus"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                @else
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="features[]" 
                                           placeholder="e.g., 5 Pages Website">
                                    <button type="button" class="btn btn-danger remove-feature">
                                        <i class="isax isax-minus"></i>
                                    </button>
                                </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-light" id="add-feature">
                                <i class="isax isax-add me-1"></i> Add Feature
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="active" {{ $package->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $package->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('packages.index') }}" class="btn btn-light">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="isax isax-save me-1"></i> Update Package
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
    // Commission type toggle
    document.getElementById('commission_type').addEventListener('change', function(e) {
        const type = e.target.value;
        const percentageField = document.getElementById('percentage_field');
        const fixedField = document.getElementById('fixed_field');
        
        if (type === 'percentage') {
            percentageField.style.display = 'block';
            fixedField.style.display = 'none';
        } else if (type === 'fixed') {
            percentageField.style.display = 'none';
            fixedField.style.display = 'block';
        } else {
            percentageField.style.display = 'block';
            fixedField.style.display = 'block';
        }
    });
    
    // Dynamic features
    document.getElementById('add-feature').addEventListener('click', function() {
        const container = document.getElementById('features-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="features[]" 
                   placeholder="e.g., 24/7 Support">
            <button type="button" class="btn btn-danger remove-feature">
                <i class="isax isax-minus"></i>
            </button>
        `;
        container.appendChild(div);
        
        // Add event listener to remove button
        div.querySelector('.remove-feature').addEventListener('click', function() {
            div.remove();
        });
    });
    
    // Add remove functionality to existing features
    document.querySelectorAll('.remove-feature').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.input-group').remove();
        });
    });
</script>
@endpush
@endsection