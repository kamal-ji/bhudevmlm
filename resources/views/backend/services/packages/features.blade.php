@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Package Features</h6>
            <p class="text-muted mb-0">Manage and compare package features</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('packages.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back to Packages
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h6 class="mb-3">Feature Comparison</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Features</th>
                            @foreach($packages as $package)
                            <th class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <h6 class="mb-1">{{ $package->name }}</h6>
                                    <span class="badge bg-primary">${{ number_format($package->price, 2) }}</span>
                                    <small class="text-muted">{{ $package->serviceCategory->name }}</small>
                                </div>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Get all unique features across packages
                            $allFeatures = [];
                            foreach ($packages as $package) {
                                if ($package->features) {
                                    foreach ($package->features as $feature) {
                                        if (!in_array($feature, $allFeatures)) {
                                            $allFeatures[] = $feature;
                                        }
                                    }
                                }
                            }
                        @endphp
                        
                        @foreach($allFeatures as $feature)
                        <tr>
                            <td>{{ $feature }}</td>
                            @foreach($packages as $package)
                            <td class="text-center">
                                @if($package->features && in_array($feature, $package->features))
                                <i class="isax isax-tick-circle text-success fs-18"></i>
                                @else
                                <i class="isax isax-close-circle text-danger fs-18"></i>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                        
                        <!-- Package Duration -->
                        <tr>
                            <td>Duration</td>
                            @foreach($packages as $package)
                            <td class="text-center">
                                @if($package->duration_days)
                                <span class="badge bg-info">{{ $package->duration_days }} days</span>
                                @else
                                <span class="badge bg-secondary">One-time</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        
                        <!-- Commission -->
                        <tr>
                            <td>Commission</td>
                            @foreach($packages as $package)
                            <td class="text-center">
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
                            @endforeach
                        </tr>
                        
                        <!-- Status -->
                        <tr>
                            <td>Status</td>
                            @foreach($packages as $package)
                            <td class="text-center">
                                <span class="badge bg-{{ $package->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($package->status) }}
                                </span>
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Manage Features</h6>
                    <form action="{{ route('packages.update-features') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Select Package</label>
                            <select class="form-select" name="package_id" id="packageSelect" required>
                                <option value="">Choose package...</option>
                                @foreach($allPackages as $package)
                                <option value="{{ $package->id }}">
                                    {{ $package->name }} - {{ $package->serviceCategory->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Current Features</label>
                            <div id="currentFeatures">
                                <div class="text-muted text-center py-3">
                                    Select a package to view its features
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Edit Features</label>
                            <div id="featuresContainer">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="features[]" 
                                           placeholder="e.g., 24/7 Support">
                                    <button type="button" class="btn btn-danger removeFeature">
                                        <i class="isax isax-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-light" id="addFeature">
                                <i class="isax isax-add me-1"></i> Add Feature
                            </button>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Common Features</label>
                            <div class="row">
                                @foreach($commonFeatures as $feature)
                                <div class="col-md-6 mb-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary w-100 text-start add-common-feature"
                                            data-feature="{{ $feature }}">
                                        <i class="isax isax-add me-1"></i> {{ $feature }}
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="isax isax-save me-1"></i> Update Features
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Feature Statistics</h6>
                    
                    <div class="mb-4">
                        <p class="mb-2">Most Common Features</p>
                        <div class="list-group">
                            @foreach($featureStats as $feature => $count)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $feature }}</span>
                                <span class="badge bg-primary rounded-pill">{{ $count }} packages</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="mb-2">Features by Category</p>
                        <div id="features-by-category-chart"></div>
                    </div>
                    
                    <div>
                        <p class="mb-2">Feature Density</p>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: {{ $avgFeatures > 10 ? 100 : ($avgFeatures * 10) }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small>Average features per package: {{ number_format($avgFeatures, 1) }}</small>
                            <small>Total unique features: {{ count($allUniqueFeatures) }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Package selection
    document.getElementById('packageSelect').addEventListener('change', function() {
        const packageId = this.value;
        const currentFeaturesDiv = document.getElementById('currentFeatures');
        const featuresContainer = document.getElementById('featuresContainer');
        
        if (!packageId) {
            currentFeaturesDiv.innerHTML = '<div class="text-muted text-center py-3">Select a package to view its features</div>';
            featuresContainer.innerHTML = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="features[]" 
                           placeholder="e.g., 24/7 Support">
                    <button type="button" class="btn btn-danger removeFeature">
                        <i class="isax isax-minus"></i>
                    </button>
                </div>
            `;
            return;
        }
        
        // Fetch package features via AJAX
        fetch(`/admin/services/packages/${packageId}/features`)
            .then(response => response.json())
            .then(data => {
                // Display current features
                if (data.features && data.features.length > 0) {
                    let html = '<div class="list-group">';
                    data.features.forEach(feature => {
                        html += `
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>${feature}</span>
                                    <button type="button" class="btn btn-sm btn-light copy-feature" data-feature="${feature}">
                                        <i class="isax isax-copy"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    currentFeaturesDiv.innerHTML = html;
                    
                    // Add copy functionality
                    document.querySelectorAll('.copy-feature').forEach(button => {
                        button.addEventListener('click', function() {
                            const feature = this.getAttribute('data-feature');
                            addFeatureToForm(feature);
                        });
                    });
                } else {
                    currentFeaturesDiv.innerHTML = '<div class="text-muted text-center py-3">No features defined for this package</div>';
                }
                
                // Populate edit form
                featuresContainer.innerHTML = '';
                if (data.features && data.features.length > 0) {
                    data.features.forEach(feature => {
                        addFeatureInput(feature);
                    });
                } else {
                    addFeatureInput('');
                }
            });
    });
    
    // Add feature input
    function addFeatureInput(value = '') {
        const container = document.getElementById('featuresContainer');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="features[]" 
                   value="${value}" placeholder="e.g., 24/7 Support">
            <button type="button" class="btn btn-danger removeFeature">
                <i class="isax isax-minus"></i>
            </button>
        `;
        container.appendChild(div);
        
        // Add remove functionality
        div.querySelector('.removeFeature').addEventListener('click', function() {
            div.remove();
        });
    }
    
    // Add new feature button
    document.getElementById('addFeature').addEventListener('click', function() {
        addFeatureInput();
    });
    
    // Add common features
    document.querySelectorAll('.add-common-feature').forEach(button => {
        button.addEventListener('click', function() {
            const feature = this.getAttribute('data-feature');
            addFeatureInput(feature);
        });
    });
    
    // Add feature to form
    function addFeatureToForm(feature) {
        addFeatureInput(feature);
    }
    
    // Features by Category Chart
    var categoryFeatures = @json($categoryFeatures);
    
    var featuresOptions = {
        series: [{
            name: 'Features',
            data: Object.values(categoryFeatures)
        }],
        chart: {
            type: 'bar',
            height: 300
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            }
        },
        colors: ['#4dabf7'],
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: Object.keys(categoryFeatures)
        }
    };
    
    var featuresChart = new ApexCharts(document.querySelector("#features-by-category-chart"), featuresOptions);
    featuresChart.render();
</script>
@endpush
@endsection