@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Category Commission Rates</h6>
            <p class="text-muted mb-0">Manage commission rates for all service categories</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('categories.update-commission-rates') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Current Rate</th>
                                <th>New Rate (%)</th>
                                <th>Members</th>
                                <th>Avg Member Rate</th>
                                <th>Total Commission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            @php
                                $memberRates = $category->members()->pluck('commission_rate')->filter();
                                $avgRate = $memberRates->isNotEmpty() ? $memberRates->avg() : $category->commission_rate;
                                $totalCommission = $category->members()->sum('total_commission');
                            @endphp
                            <tr>
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
                                    <span class="badge bg-primary fs-14">{{ $category->commission_rate }}%</span>
                                </td>
                                <td>
                                    <div class="input-group" style="width: 150px;">
                                        <input type="number" class="form-control" 
                                               name="rates[{{ $category->id }}]" 
                                               step="0.01" min="0" max="100"
                                               value="{{ $category->commission_rate }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </td>
                                <td>{{ $category->activeMembers()->count() }}</td>
                                <td>
                                    <span class="badge bg-{{ $avgRate > $category->commission_rate ? 'success' : ($avgRate < $category->commission_rate ? 'warning' : 'info') }}">
                                        {{ number_format($avgRate, 2) }}%
                                    </span>
                                </td>
                                <td>
                                    <strong>${{ number_format($totalCommission, 2) }}</strong>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 p-3 bg-light rounded">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="mb-2">Bulk Update Options</h6>
                            <div class="d-flex gap-2 align-items-center">
                                <span>Apply to all categories:</span>
                                <input type="number" class="form-control w-auto" 
                                       id="bulk_rate" placeholder="Rate %" step="0.01" min="0" max="100">
                                <button type="button" class="btn btn-sm btn-primary" onclick="applyBulkRate()">
                                    Apply
                                </button>
                            </div>
                            <small class="text-muted">This will fill all "New Rate" fields with the specified value</small>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="isax isax-save me-1"></i> Update All Rates
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Commission Rate Distribution</h6>
                    <div id="commission-distribution-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Rate vs Performance</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Rate</th>
                                    <th>Sales</th>
                                    <th>Commission</th>
                                    <th>Efficiency</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                @php
                                    $totalSales = $category->members()->sum('total_sales');
                                    $totalCommission = $category->members()->sum('total_commission');
                                    $efficiency = $totalSales > 0 ? ($totalCommission / $totalSales) * 100 : 0;
                                @endphp
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td><span class="badge bg-primary">{{ $category->commission_rate }}%</span></td>
                                    <td>${{ number_format($totalSales, 2) }}</td>
                                    <td>${{ number_format($totalCommission, 2) }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $efficiency > $category->commission_rate ? 'success' : ($efficiency < $category->commission_rate ? 'warning' : 'info') }}" 
                                                 style="width: {{ min($efficiency, 100) }}%"></div>
                                        </div>
                                        <small>{{ number_format($efficiency, 2) }}%</small>
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
    function applyBulkRate() {
        const bulkRate = document.getElementById('bulk_rate').value;
        if (bulkRate && !isNaN(bulkRate) && bulkRate >= 0 && bulkRate <= 100) {
            document.querySelectorAll('input[name^="rates["]').forEach(input => {
                input.value = bulkRate;
            });
        }
    }
    
    // Commission Distribution Chart
    var distributionOptions = {
        series: [
            @foreach($categories as $category)
            {{ $category->commission_rate }},
            @endforeach
        ],
        chart: {
            type: 'pie',
            height: 350
        },
        labels: [
            @foreach($categories as $category)
            "{{ $category->name }}",
            @endforeach
        ],
        colors: [
            @foreach($categories as $category)
            "{{ $category->color }}",
            @endforeach
        ],
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true,
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex] + "%";
            }
        }
    };
    
    var distributionChart = new ApexCharts(document.querySelector("#commission-distribution-chart"), distributionOptions);
    distributionChart.render();
</script>
@endpush
@endsection