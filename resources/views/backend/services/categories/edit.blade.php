@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Create Service Category</h6>
            <p class="text-muted mb-0">Add a new service category for your MLM system</p>
        </div>
        <div>
            <a href="{{ route('categories.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                 @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $category->name }}" name="name" required 
                                   placeholder="e.g., Matrimony Services">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Commission Rate (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="commission_rate" 
                                   step="0.01" min="0" max="100" value="{{ $category->commission_rate }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Icon <span class="text-danger">*</span></label>
                            <select class="form-select" name="icon" required>
                                <option value="isax-heart" @if($category->icon == 'isax-heart') selected @endif>Heart (Matrimony)</option>
                                <option value="isax-code" @if($category->icon == 'isax-code') selected @endif>Code (Development)</option>
                                <option value="isax-chart" @if($category->icon == 'isax-chart') selected @endif >Chart (Marketing)</option>
                                <option value="isax-mobile" @if($category->icon == 'isax-mobile') selected @endif>Mobile (App)</option>
                                <option value="isax-search-normal" @if($category->icon == 'isax-search-normal') selected @endif>Search (SEO)</option>
                                <option value="isax-briefcase" @if($category->icon == 'isax-briefcase') selected @endif>Briefcase (Business)</option>
                                <option value="isax-cpu" @if($category->icon == 'isax-cpu') selected @endif>CPU (IT Services)</option>
                                <option value="isax-music" @if($category->icon == 'isax-music') selected @endif>Music (Entertainment)</option>
                                <option value="isax-book" @if($category->icon == 'isax-book') selected @endif)>Book (Education)</option>
                                <option value="isax-health" @if($category->icon == 'isax-health') selected @endif) >Health (Healthcare)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Color <span class="text-danger">*</span></label>
                            <div class="input-group colorpicker">
                                <input type="color" class="form-control form-control-color" 
                                       name="color" value="{{ $category->color ? $category->color : '#4dabf7' }}" required >
                               <span class="input-group-text">
    {{ $category->color ? $category->color : '#4dabf7' }}
</span>

                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" 
                                      placeholder="Describe this service category...">{{ $category->description ? $category->description : '' }}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control" name="sort_order" value="{{ $category->sort_order ? $category->sort_order : '' }}">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-light">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="isax isax-add me-1"></i> Update Category
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
    // Color picker
    document.querySelector('input[name="color"]').addEventListener('input', function(e) {
        document.querySelector('.colorpicker .input-group-text').textContent = e.target.value;
    });
</script>
@endpush
@endsection