@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Category Performance</h6>
            <p class="text-muted mb-0">Analyze performance across service categories</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="reportrange-picker d-flex align-items-center">
                <i class="isax isax-calendar text-gray-5 fs-14 me-1"></i>
                <span class="reportrange-picker-field">Last 30 Days</span>
            </div>
            <a href="{{ route('categories.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-primary-subtle text-primary rounded-circle me-3">
                            <i class="isax isax-dollar-circle"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total Sales</p>
                            <h3 class="mb-0">${{ number_format($totalSales, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-success-subtle text-success rounded-circle me-3">
                            <i class="isax isax-money-add"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total Commission</p>
                            <h3 class="mb-0">${{ number_format($totalCommission, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-info-subtle text-info rounded-circle me-3">
                            <i class="isax isax-profile-2user"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Active Members</p>
                            <h3 class="mb-0">{{ $totalMembers }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-warning-subtle text-warning rounded-circle me-3">
                            <i class="isax isax-shopping-cart"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total Orders</p>
                            <h3 class="mb-0">{{ $totalOrders }}</h3>
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
                    <h6 class="mb-3">Sales by Category</h6>
                    <div id="sales-by-category-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Top Performing Categories</h6>
                    <div class="list-group">
                        @foreach($topCategories as $index => $category)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2">#{{ $index + 1 }}</span>
                                    <span class="avatar avatar-xs me-2" style="background-color: {{ $category->color }};">
                                        <i class="isax {{ $category->icon }}"></i>
                                    </span>
                                    <span>{{ $category->name }}</span>
                                </div>
                                <div class="text-end">
                                    <strong>${{ number_format($category->total_sales, 2) }}</strong>
                                    <br>
                                    <small class="text-success">{{ $category->member_count }} members</small>
                                </div>
                            </div>
                           <div class="progress mt-2" style="height: 5px;">
    @php
        $percentage = $totalSales > 0 ? ($category->total_sales / $totalSales) * 100 : 0;
    @endphp
    <div class="progress-bar" style="width: {{ $percentage }}%; 
         background-color: {{ $category->color }};"></div>
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
            <h6 class="mb-3">Detailed Category Performance</h6>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Active Members</th>
                            <th>Total Sales</th>
                            <th>Total Commission</th>
                            <th>Avg Commission/Member</th>
                            <th>Conversion Rate</th>
                            <th>Growth</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        @php
                            $memberCount = $category->activeMembers()->count();
                            $totalSales = $category->members()->sum('total_sales');
                            $totalCommission = $category->members()->sum('total_commission');
                            $avgCommission = $memberCount > 0 ? $totalCommission / $memberCount : 0;
                            $conversionRate = $memberCount > 0 ? ($category->orders()->count() / $memberCount) * 100 : 0;
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-sm me-2" style="background-color: {{ $category->color }};">
                                        <i class="isax {{ $category->icon }}"></i>
                                    </span>
                                    <div>
                                        <h6 class="mb-0">{{ $category->name }}</h6>
                                        <small class="text-muted">{{ $category->commission_rate }}% commission</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $memberCount }}</span>
                            </td>
                            <td>
                                <strong>${{ number_format($totalSales, 2) }}</strong>
                            </td>
                            <td>
                                <span class="text-success">${{ number_format($totalCommission, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">${{ number_format($avgCommission, 2) }}</span>
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
                                @php
                                    $growth = rand(-20, 50); // This should be calculated from actual data
                                @endphp
                                <span class="badge bg-{{ $growth > 0 ? 'success' : ($growth < 0 ? 'danger' : 'secondary') }}">
                                    {{ $growth > 0 ? '+' : '' }}{{ $growth }}%
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('categories.detail-performance', $category->id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Details">
                                        <i class="isax isax-chart"></i>
                                    </a>
                                    <a href="{{ route('packages.by-category', $category->id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Packages">
                                        <i class="isax isax-gift"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Sales by Category Chart
    var salesOptions = {
        series: [{
            name: 'Sales',
            data: [
                @foreach($categories as $category)
                {{ $category->members()->sum('total_sales') }},
                @endforeach
            ]
        }, {
            name: 'Commission',
            data: [
                @foreach($categories as $category)
                {{ $category->members()->sum('total_commission') }},
                @endforeach
            ]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        colors: ['#4dabf7', '#40c057'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: [
                @foreach($categories as $category)
                "{{ $category->name }}",
                @endforeach
            ]
        },
        yaxis: {
            title: {
                text: 'Amount ($)'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$" + val.toFixed(2);
                }
            }
        }
    };
    
    var salesChart = new ApexCharts(document.querySelector("#sales-by-category-chart"), salesOptions);
    salesChart.render();
</script>
@endpush
@endsection