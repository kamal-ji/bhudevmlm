@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Service Packages</h6>
            <p class="text-muted mb-0">Manage all service packages across categories</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('packages.create') }}" class="btn btn-primary">
                <i class="isax isax-add me-1"></i> Create Package
            </a>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $packages->total() }}</h3>
                    <p class="text-muted mb-0">Total Packages</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $packages->where('status', 'active')->count() }}</h3>
                    <p class="text-muted mb-0">Active Packages</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ \App\Models\ServiceCategory::count() }}</h3>
                    <p class="text-muted mb-0">Categories</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ \App\Models\ServiceOrder::count() }}</h3>
                    <p class="text-muted mb-0">Total Orders</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Package Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Commission</th>
                            <th>Orders</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <h6 class="mb-0">{{ $package->name }}</h6>
                                <small class="text-muted">{{ Str::limit($package->description, 50) }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-sm me-2" style="background-color: {{ $package->serviceCategory->color }};">
                                        <i class="isax {{ $package->serviceCategory->icon }}"></i>
                                    </span>
                                    <span>{{ $package->serviceCategory->name }}</span>
                                </div>
                            </td>
                            <td>
                                <strong>${{ number_format($package->price, 2) }}</strong>
                            </td>
                            <td>
                                @if($package->commission_type == 'percentage')
                                <span class="badge bg-primary">{{ $package->commission_percentage }}%</span>
                                @elseif($package->commission_type == 'fixed')
                                <span class="badge bg-success">${{ number_format($package->commission_amount, 2) }}</span>
                                @else
                                <div class="d-flex flex-column">
                                    <span class="badge bg-primary mb-1">{{ $package->commission_percentage }}%</span>
                                    <span class="badge bg-success">+ ${{ number_format($package->commission_amount, 2) }}</span>
                                </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $package->orders()->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $package->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($package->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('packages.edit', $package->id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Edit">
                                        <i class="isax isax-edit"></i>
                                    </a>
                                    <a href="{{ route('packages.by-category', $package->service_category_id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Category">
                                        <i class="isax isax-category-2"></i>
                                    </a>
                                    <form action="{{ route('packages.destroy', $package->id) }}" 
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
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="isax isax-gift fs-48 mb-2"></i>
                                    <p>No service packages found</p>
                                    <a href="{{ route('packages.create') }}" class="btn btn-primary">
                                        Create First Package
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                @if($packages->hasPages())
                <div class="mt-3">
                    {{ $packages->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection