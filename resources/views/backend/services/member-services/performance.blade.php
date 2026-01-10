@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Service Performance</h6>
            <p class="text-muted mb-0">Track performance of members across services</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="reportrange-picker d-flex align-items-center">
                <i class="isax isax-calendar text-gray-5 fs-14 me-1"></i>
                <span class="reportrange-picker-field">Last 30 Days</span>
            </div>
            <a href="{{ route('member-services.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back to Assignments
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg bg-primary-subtle text-primary rounded-circle me-3">
                                    <i class="isax isax-dollar-circle"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Total Service Sales</p>
                                    <h3 class="mb-0">${{ number_format($totalSales, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg bg-success-subtle text-success rounded-circle me-3">
                                    <i class="isax isax-money-add"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Total Commission Paid</p>
                                    <h3 class="mb-0">${{ number_format($totalCommission, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg bg-info-subtle text-info rounded-circle me-3">
                                    <i class="isax isax-shopping-cart"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Total Orders</p>
                                    <h3 class="mb-0">{{ $totalOrders }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg bg-warning-subtle text-warning rounded-circle me-3">
                                    <i class="isax isax-profile-2user"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Active Members</p>
                                    <h3 class="mb-0">{{ $activeMembers }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Performance Trends</h6>
                    <div id="performance-trends-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Top Performing Services</h6>
                    <div class="list-group">
                        @foreach($topServices as $index => $service)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2">#{{ $index + 1 }}</span>
                                    <span class="avatar avatar-xs me-2" style="background-color: {{ $service->color }};">
                                        <i class="isax {{ $service->icon }}"></i>
                                    </span>
                                    <span>{{ $service->name }}</span>
                                </div>
                                <div class="text-end">
                                    <strong>${{ number_format($service->total_sales, 2) }}</strong>
                                    <br>
                                    <small class="text-success">{{ $service->member_count }} active</small>
                                </div>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
    <div class="progress-bar" style="width: {{ $totalSales > 0 ? ($service->total_sales / $totalSales) * 100 : 0 }}%; 
         background-color: {{ $service->color }};"></div>
</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Member Service Performance</h6>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm w-auto" id="categoryFilter">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select form-select-sm w-auto" id="sortBy">
                        <option value="sales">Sort by Sales</option>
                        <option value="commission">Sort by Commission</option>
                        <option value="rate">Sort by Rate</option>
                        <option value="referrals">Sort by Referrals</option>
                    </select>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover" id="performanceTable">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Service</th>
                            <th>Commission Rate</th>
                            <th>Total Sales</th>
                            <th>Total Commission</th>
                            <th>Referrals</th>
                            <th>Avg Order Value</th>
                            <th>Conversion</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                        @php
                            $conversionRate = $assignment->referral_count > 0 ? 
                                ($assignment->orders()->count() / $assignment->referral_count) * 100 : 0;
                            $avgOrderValue = $assignment->orders()->count() > 0 ? 
                                $assignment->total_sales / $assignment->orders()->count() : 0;
                        @endphp
                        <tr data-category="{{ $assignment->service_category_id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm rounded-circle me-2">
                                        <span class="avatar-initial">{{ substr($assignment->member->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $assignment->member->name }}</h6>
                                        <small class="text-muted">{{ $assignment->referral_code }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-xs me-2" style="background-color: {{ $assignment->serviceCategory->color }};">
                                        <i class="isax {{ $assignment->serviceCategory->icon }}"></i>
                                    </span>
                                    <span>{{ $assignment->serviceCategory->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $assignment->commission_rate > $assignment->serviceCategory->commission_rate ? 'success' : ($assignment->commission_rate < $assignment->serviceCategory->commission_rate ? 'warning' : 'primary') }}">
                                    {{ $assignment->commission_rate }}%
                                </span>
                            </td>
                            <td data-sort="{{ $assignment->total_sales }}">
                                <strong>${{ number_format($assignment->total_sales, 2) }}</strong>
                            </td>
                            <td data-sort="{{ $assignment->total_commission }}">
                                <span class="text-success">${{ number_format($assignment->total_commission, 2) }}</span>
                            </td>
                            <td data-sort="{{ $assignment->referral_count }}">
                                <span class="badge bg-info">{{ $assignment->referral_count }}</span>
                            </td>
                            <td>
                                ${{ number_format($avgOrderValue, 2) }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                        <div class="progress-bar bg-{{ $conversionRate > 50 ? 'success' : ($conversionRate > 20 ? 'warning' : 'danger') }}" 
                                             style="width: {{ min($conversionRate, 100) }}%"></div>
                                    </div>
                                    <span>{{ number_format($conversionRate, 1) }}%</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('member-services.edit', $assignment->id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Edit">
                                        <i class="isax isax-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Details">
                                        <i class="isax isax-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($assignments->hasPages())
            <div class="mt-3">
                {{ $assignments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Performance Trends Chart
    var trendsOptions = {
        series: [{
            name: 'Sales',
            data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
        }, {
            name: 'Commission',
            data: [23, 12, 54, 61, 32, 45, 41, 65, 89]
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        colors: ['#4dabf7', '#40c057'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: 'Monthly Performance',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'],
                opacity: 0.5
            },
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
    };
    
    var trendsChart = new ApexCharts(document.querySelector("#performance-trends-chart"), trendsOptions);
    trendsChart.render();
    
    // Filter and sort functionality
    document.getElementById('categoryFilter').addEventListener('change', function() {
        const categoryId = this.value;
        const rows = document.querySelectorAll('#performanceTable tbody tr');
        
        rows.forEach(row => {
            if (!categoryId || row.getAttribute('data-category') === categoryId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    document.getElementById('sortBy').addEventListener('change', function() {
        const sortBy = this.value;
        const tbody = document.querySelector('#performanceTable tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aValue = parseFloat(a.querySelector(`td[data-sort]`).getAttribute('data-sort') || 0);
            const bValue = parseFloat(b.querySelector(`td[data-sort]`).getAttribute('data-sort') || 0);
            return bValue - aValue; // Descending order
        });
        
        // Clear and re-append sorted rows
        rows.forEach(row => tbody.appendChild(row));
    });
</script>
@endpush
@endsection