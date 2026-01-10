@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Service Packages - {{ $category->name }}</h6>
            <p class="text-muted mb-0">Manage packages for {{ $category->name }} category</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('packages.create') }}" class="btn btn-primary">
                <i class="isax isax-add me-1"></i> Add Package
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <span class="avatar avatar-lg me-3" style="background-color: {{ $category->color }};">
                    <i class="isax {{ $category->icon }} fs-24"></i>
                </span>
                <div>
                    <h5 class="mb-1">{{ $category->name }}</h5>
                    <p class="text-muted mb-2">{{ $category->description }}</p>
                    <div class="d-flex gap-3">
                        <span class="badge bg-primary">{{ $category->commission_rate }}% Commission</span>
                        <span class="badge bg-success">{{ $category->activeMembers()->count() }} Members</span>
                        <span class="badge bg-info">{{ $packages->total() }} Packages</span>
                    </div>
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
                            <th>Price</th>
                            <th>Commission</th>
                            <th>Duration</th>
                            <th>Features</th>
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
                                @if($package->duration_days)
                                <span class="badge bg-info">{{ $package->duration_days }} days</span>
                                @else
                                <span class="badge bg-secondary">One-time</span>
                                @endif
                            </td>
                            <td>
                                @if($package->features && count($package->features) > 0)
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        {{ count($package->features) }} features
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach($package->features as $feature)
                                        <li><span class="dropdown-item-text">{{ $feature }}</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                                @else
                                <span class="text-muted">No features</span>
                                @endif
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
                                    <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Orders">
                                        <i class="isax isax-receipt-text"></i>
                                    </a>
                                    <form action="{{ route('packages.destroy', $package->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light" 
                                                data-bs-toggle="tooltip" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this package?')">
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
                                    <p>No packages found for this category</p>
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