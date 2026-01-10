@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>{{ $category->name }} - Performance Details</h6>
            <p class="text-muted mb-0">Detailed performance analytics for {{ $category->name }}</p>
        </div>
        <div>
            <a href="{{ route('categories.performance') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back to Performance
            </a>
        </div>
    </div>

    <!-- Category Overview -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <span class="avatar avatar-xxl me-4" style="background-color: {{ $category->color }};">
                    <i class="isax {{ $category->icon }} fs-36"></i>
                </span>
                <div class="flex-grow-1">
                    <h4>{{ $category->name }}</h4>
                    <p class="text-muted mb-3">{{ $category->description }}</p>
                    <div class="d-flex gap-4">
                        <div>
                            <span class="badge bg-primary">{{ $category->commission_rate }}% Commission</span>
                        </div>
                        <div>
                            <span class="badge bg-success">{{ $category->status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="mb-2">{{ $memberCount }}</h2>
                    <p class="text-muted mb-0">Active Members</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="mb-2">${{ number_format($totalSales, 2) }}</h2>
                    <p class="text-muted mb-0">Total Sales</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="mb-2">${{ number_format($totalCommission, 2) }}</h2>
                    <p class="text-muted mb-0">Total Commission</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="mb-2">{{ $totalOrders }}</h2>
                    <p class="text-muted mb-0">Total Orders</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Members Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Members ({{ $category->members->count() }})</h6>
                <a href="{{ route('member-services.create') }}?category={{ $category->id }}" 
                   class="btn btn-sm btn-primary">
                    <i class="isax isax-user-add me-1"></i> Add Member
                </a>
            </div>
            
            @if($category->members->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Referral Code</th>
                            <th>Commission Rate</th>
                            <th>Total Sales</th>
                            <th>Total Commission</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->members as $member)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm rounded-circle me-2">
                                        <span class="avatar-initial">{{ substr($member->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $member->name }}</h6>
                                        <small class="text-muted">{{ $member->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="bg-light p-1 rounded">{{ $member->pivot->referral_code }}</code>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $member->pivot->commission_rate }}%</span>
                            </td>
                            <td>
                                ${{ number_format($member->pivot->total_sales, 2) }}
                            </td>
                            <td>
                                <span class="text-success">${{ number_format($member->pivot->total_commission, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $member->pivot->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($member->pivot->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Edit">
                                        <i class="isax isax-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View">
                                        <i class="isax isax-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <i class="isax isax-profile-2user fs-48 text-muted mb-3"></i>
                <p class="text-muted">No members assigned to this category yet.</p>
                <a href="{{ route('member-services.create') }}?category={{ $category->id }}" 
                   class="btn btn-primary">
                    <i class="isax isax-user-add me-1"></i> Assign First Member
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Packages Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Packages ({{ $category->packages->count() }})</h6>
                <a href="{{ route('packages.create') }}?category={{ $category->id }}" 
                   class="btn btn-sm btn-primary">
                    <i class="isax isax-add me-1"></i> Create Package
                </a>
            </div>
            
            @if($category->packages->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Package Name</th>
                            <th>Price</th>
                            <th>Commission</th>
                            <th>Orders</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->packages as $package)
                        <tr>
                            <td>
                                <h6 class="mb-0">{{ $package->name }}</h6>
                                <small class="text-muted">{{ Str::limit($package->description, 50) }}</small>
                            </td>
                            <td>
                                ${{ number_format($package->price, 2) }}
                            </td>
                            <td>
                                @if($package->commission_type == 'percentage')
                                <span class="badge bg-primary">{{ $package->commission_percentage }}%</span>
                                @elseif($package->commission_type == 'fixed')
                                <span class="badge bg-success">${{ number_format($package->commission_amount, 2) }}</span>
                                @else
                                <span class="badge bg-info">{{ $package->commission_percentage }}% + ${{ number_format($package->commission_amount, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $package->orders_count }}</span>
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
                                    <a href="{{ route('packages.by-category', $category->id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View All">
                                        <i class="isax isax-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <i class="isax isax-gift fs-48 text-muted mb-3"></i>
                <p class="text-muted">No packages created for this category yet.</p>
                <a href="{{ route('packages.create') }}?category={{ $category->id }}" 
                   class="btn btn-primary">
                    <i class="isax isax-add me-1"></i> Create First Package
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-body">
            <h6 class="mb-3">Recent Orders</h6>
            
            @if($category->orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Amount</th>
                            <th>Commission</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->orders as $order)
                        <tr>
                            <td>
                                <a href="#" class="link-default">{{ $order->order_number }}</a>
                            </td>
                            <td>
                                {{ $order->member->name }}
                            </td>
                            <td>
                                {{ $order->servicePackage->name }}
                            </td>
                            <td>
                                ${{ number_format($order->amount, 2) }}
                            </td>
                            <td>
                                <span class="text-success">${{ number_format($order->commission_amount, 2) }}</span>
                            </td>
                            <td>
                                {{ $order->order_date->format('d M Y') }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($category->orders->count() > 10)
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-light">View All Orders</a>
                </div>
                @endif
            </div>
            @else
            <div class="text-center py-4">
                <i class="isax isax-receipt-text fs-48 text-muted mb-3"></i>
                <p class="text-muted">No orders found for this category yet.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Performance Summary -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Performance Metrics</h6>
                    <div class="list-group">
                        @php
                            // Use the variables already passed from controller
                            $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
                            $avgCommissionPerMember = $memberCount > 0 ? $totalCommission / $memberCount : 0;
                            $conversionRate = $memberCount > 0 ? ($totalOrders / $memberCount) * 100 : 0;
                        @endphp
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Avg Order Value</span>
                            <span class="badge bg-primary">${{ number_format($avgOrderValue, 2) }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Avg Commission/Member</span>
                            <span class="badge bg-success">${{ number_format($avgCommissionPerMember, 2) }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Conversion Rate</span>
                            <span class="badge bg-info">{{ number_format($conversionRate, 1) }}%</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Active Packages</span>
                            <span class="badge bg-warning">{{ $category->activePackages()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('packages.create') }}?category={{ $category->id }}" 
                           class="btn btn-light text-start">
                            <i class="isax isax-add me-2"></i> Create New Package
                        </a>
                        <a href="{{ route('member-services.create') }}?category={{ $category->id }}" 
                           class="btn btn-light text-start">
                            <i class="isax isax-user-add me-2"></i> Assign New Member
                        </a>
                        <a href="{{ route('categories.edit', $category->id) }}" 
                           class="btn btn-light text-start">
                            <i class="isax isax-edit me-2"></i> Edit Category Settings
                        </a>
                        <a href="{{ route('packages.by-category', $category->id) }}" 
                           class="btn btn-light text-start">
                            <i class="isax isax-gift me-2"></i> View All Packages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection