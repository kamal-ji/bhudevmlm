@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Service Commission Override</h6>
            <p class="text-muted mb-0">Override commission rates for specific members</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('member-services.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back to Assignments
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Service Category</th>
                            <th>Default Rate</th>
                            <th>Current Rate</th>
                            <th>Override Rate (%)</th>
                            <th>Status</th>
                            <th>Performance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm rounded-circle me-2">
                                        <span class="avatar-initial">{{ substr($assignment->member->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $assignment->member->name }}</h6>
                                        <small class="text-muted">{{ $assignment->member->email }}</small>
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
                                <span class="badge bg-secondary">{{ $assignment->serviceCategory->commission_rate }}%</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $assignment->commission_rate > $assignment->serviceCategory->commission_rate ? 'success' : ($assignment->commission_rate < $assignment->serviceCategory->commission_rate ? 'warning' : 'primary') }}">
                                    {{ $assignment->commission_rate }}%
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('member-services.update-commission', $assignment->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="number" class="form-control" name="commission_rate"
                                               step="0.01" min="0" max="100"
                                               value="{{ $assignment->commission_rate }}">
                                        <span class="input-group-text">%</span>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="isax isax-save"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <span class="badge bg-{{ $assignment->status == 'active' ? 'success' : ($assignment->status == 'suspended' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($assignment->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small>Sales: ${{ number_format($assignment->total_sales, 2) }}</small>
                                    <small>Comm: ${{ number_format($assignment->total_commission, 2) }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-light" 
                                            onclick="resetCommission({{ $assignment->id }}, {{ $assignment->serviceCategory->commission_rate }})"
                                            data-bs-toggle="tooltip" title="Reset to Default">
                                        <i class="isax isax-refresh"></i>
                                    </button>
                                    <a href="{{ route('member-services.edit', $assignment->id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Edit">
                                        <i class="isax isax-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($assignments->hasPages())
                <div class="mt-3">
                    {{ $assignments->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Bulk Commission Update</h6>
                    <form action="{{ route('member-services.bulk-update-commission') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Select Category</label>
                            <select class="form-select" name="service_category_id" id="bulk_category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">New Commission Rate (%)</label>
                            <input type="number" class="form-control" name="commission_rate"
                                   step="0.01" min="0" max="100" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Apply To</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="apply_to[]" value="all" id="apply_all">
                                <label class="form-check-label" for="apply_all">
                                    All members in selected category
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="apply_to[]" value="active" id="apply_active">
                                <label class="form-check-label" for="apply_active">
                                    Only active members
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="apply_to[]" value="below_default" id="apply_below">
                                <label class="form-check-label" for="apply_below">
                                    Members with rate below default
                                </label>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <div class="d-flex align-items-center">
                                <i class="isax isax-warning-2 me-2"></i>
                                <div>
                                    <h6 class="mb-1">Warning</h6>
                                    <p class="mb-0">This will update commission rates for multiple members at once.</p>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="isax isax-refresh me-1"></i> Apply Bulk Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Commission Rate Distribution</h6>
                    <div id="override-distribution-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function resetCommission(assignmentId, defaultRate) {
        if (confirm('Reset commission rate to default ' + defaultRate + '%?')) {
            fetch(`/admin/services/member-services/${assignmentId}/reset-commission`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ commission_rate: defaultRate })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
    
    // Commission Distribution Chart
    var distributionData = {
        belowDefault: {{ $belowDefault }},
        atDefault: {{ $atDefault }},
        aboveDefault: {{ $aboveDefault }}
    };
    
    var overrideOptions = {
        series: [distributionData.belowDefault, distributionData.atDefault, distributionData.aboveDefault],
        chart: {
            type: 'donut',
            height: 320
        },
        labels: ['Below Default', 'At Default', 'Above Default'],
        colors: ['#ff6b6b', '#4dabf7', '#40c057'],
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true,
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex] + ' members';
            }
        }
    };
    
    var overrideChart = new ApexCharts(document.querySelector("#override-distribution-chart"), overrideOptions);
    overrideChart.render();
</script>
@endpush
@endsection