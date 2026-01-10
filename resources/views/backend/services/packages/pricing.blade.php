@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Package Pricing</h6>
            <p class="text-muted mb-0">Compare and manage package pricing</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('packages.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back to Packages
            </a>
        </div>
    </div>

    <div class="row mb-4">
        @foreach($categories as $category)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="avatar avatar-lg me-3" style="background-color: {{ $category->color }};">
                            <i class="isax {{ $category->icon }}"></i>
                        </span>
                        <div>
                            <h5 class="mb-1">{{ $category->name }}</h5>
                            <p class="text-muted mb-0">{{ $category->packages()->count() }} packages</p>
                        </div>
                    </div>
                    
                    @php
                        $packages = $category->packages()->orderBy('price')->get();
                        $minPrice = $packages->min('price') ?? 0;
                        $maxPrice = $packages->max('price') ?? 0;
                        $avgPrice = $packages->avg('price') ?? 0;
                    @endphp
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Price Range:</span>
                            <span>${{ number_format($minPrice, 2) }} - ${{ number_format($maxPrice, 2) }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" style="width: 100%; background-color: {{ $category->color }};"></div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <div class="text-center">
                            <h4 class="mb-0">${{ number_format($minPrice, 2) }}</h4>
                            <small class="text-muted">Lowest</small>
                        </div>
                        <div class="text-center">
                            <h4 class="mb-0">${{ number_format($avgPrice, 2) }}</h4>
                            <small class="text-muted">Average</small>
                        </div>
                        <div class="text-center">
                            <h4 class="mb-0">${{ number_format($maxPrice, 2) }}</h4>
                            <small class="text-muted">Highest</small>
                        </div>
                    </div>
                    
                    <a href="{{ route('packages.by-category', $category->id) }}" 
                       class="btn btn-light w-100 mt-3">
                        View Packages
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="mb-3">Package Price Comparison</h6>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Package Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Commission</th>
                            <th>Orders</th>
                            <th>Revenue</th>
                            <th>Avg Monthly</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        @php
                            $orderCount = $package->orders()->count();
                            $revenue = $orderCount * $package->price;
                            $monthlyPrice = $package->duration_days ? 
                                ($package->price / ($package->duration_days / 30)) : $package->price;
                        @endphp
                        <tr>
                            <td>
                                <h6 class="mb-0">{{ $package->name }}</h6>
                                <small class="text-muted">{{ Str::limit($package->description, 50) }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-xs me-2" style="background-color: {{ $package->serviceCategory->color }};">
                                        <i class="isax {{ $package->serviceCategory->icon }}"></i>
                                    </span>
                                    <span>{{ $package->serviceCategory->name }}</span>
                                </div>
                            </td>
                            <td>
                                <strong>${{ number_format($package->price, 2) }}</strong>
                            </td>
                            <td>
                                @if($package->duration_days)
                                <span class="badge bg-info">{{ $package->duration_days }} days</span>
                                @else
                                <span class="badge bg-secondary">One-time</span>
                                @endif
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
                                <span class="badge bg-{{ $orderCount > 0 ? 'success' : 'secondary' }}">
                                    {{ $orderCount }}
                                </span>
                            </td>
                            <td>
                                <strong>${{ number_format($revenue, 2) }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">${{ number_format($monthlyPrice, 2) }}/mo</span>
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
                                    <button type="button" class="btn btn-sm btn-light" 
                                            data-bs-toggle="modal" data-bs-target="#priceModal{{ $package->id }}"
                                            data-bs-tooltip title="Adjust Price">
                                        <i class="isax isax-dollar-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Price Adjustment Modal -->
                        <div class="modal fade" id="priceModal{{ $package->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('packages.update-price', $package->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Adjust Price - {{ $package->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Current Price</label>
                                                <input type="text" class="form-control" 
                                                       value="${{ number_format($package->price, 2) }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">New Price ($)</label>
                                                <input type="number" class="form-control" name="price"
                                                       step="0.01" min="0" required
                                                       value="{{ $package->price }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Price Change Reason</label>
                                                <textarea class="form-control" name="reason" rows="3" 
                                                          placeholder="Explain why you're changing the price..."></textarea>
                                            </div>
                                            <div class="alert alert-info">
                                                <div class="d-flex align-items-center">
                                                    <i class="isax isax-info-circle me-2"></i>
                                                    <div>
                                                        <h6 class="mb-1">Note</h6>
                                                        <p class="mb-0">This change will affect new purchases only. Existing orders will not be affected.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update Price</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
          
    <div class="mt-3">
        
    </div>

        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Price Distribution</h6>
                    <div id="price-distribution-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Price vs Popularity</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Package</th>
                                    <th>Price</th>
                                    <th>Orders</th>
                                    <th>Revenue</th>
                                    <th>Popularity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($popularPackages as $package)
                                @php
                                    $orderCount = $package->orders()->count();
                                    $revenue = $orderCount * $package->price;
                                    $popularity = $orderCount > 0 ? ($revenue / $totalRevenue) * 100 : 0;
                                @endphp
                                <tr>
                                    <td>{{ $package->name }}</td>
                                    <td>${{ number_format($package->price, 2) }}</td>
                                    <td>{{ $orderCount }}</td>
                                    <td>${{ number_format($revenue, 2) }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $popularity > 20 ? 'success' : ($popularity > 5 ? 'warning' : 'info') }}" 
                                                 style="width: {{ min($popularity, 100) }}%"></div>
                                        </div>
                                        <small>{{ number_format($popularity, 1) }}%</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Price Distribution Chart
    var priceData = {
        low: {{ $lowPriceCount }},
        medium: {{ $mediumPriceCount }},
        high: {{ $highPriceCount }}
    };
    
    var priceOptions = {
        series: [priceData.low, priceData.medium, priceData.high],
        chart: {
            type: 'pie',
            height: 320
        },
        labels: ['Low ($0-99)', 'Medium ($100-499)', 'High ($500+)'],
        colors: ['#40c057', '#ffc107', '#ff6b6b'],
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true,
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex] + ' packages';
            }
        }
    };
    
    var priceChart = new ApexCharts(document.querySelector("#price-distribution-chart"), priceOptions);
    priceChart.render();
</script>
@endpush
@endsection