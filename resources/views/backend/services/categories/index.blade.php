@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Service Categories</h6>
            <p class="text-muted mb-0">Manage service categories for your MLM system</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="isax isax-add me-1"></i> Add Category
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Commission Rate</th>
                            <th>Members</th>
                            <th>Packages</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-sm me-2" style="background-color: {{ $category->color }};">
                                        <i class="isax {{ $category->icon }}"></i>
                                    </span>
                                    <div>
                                        <h6 class="mb-0">{{ $category->name }}</h6>
                                        <small class="text-muted">{{ $category->description }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $category->commission_rate }}%</span>
                            </td>
                            <td>{{ $category->activeMembers()->count() }}</td>
                            <td>{{ $category->activePackages()->count() }}</td>
                            <td>
                                <span class="badge bg-{{ $category->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($category->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('categories.edit', $category->id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Edit">
                                        <i class="isax isax-edit"></i>
                                    </a>
                                    <a href="{{ route('packages.by-category', $category->id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Packages">
                                        <i class="isax isax-gift"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light" 
                                                data-bs-toggle="tooltip" title="Delete"
                                                onclick="return confirm('Are you sure?')">
                                            <i class="isax isax-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="isax isax-category-2 fs-48 mb-2"></i>
                                    <p>No service categories found</p>
                                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                        Create First Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection