@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Member Service Assignments</h6>
            <p class="text-muted mb-0">Manage member service categories and referral codes</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('member-services.create') }}" class="btn btn-primary">
                <i class="isax isax-user-add me-1"></i> Assign Service
            </a>
            <a href="{{ route('member-services.generate-codes') }}" class="btn btn-success">
                <i class="isax isax-link me-1"></i> Generate Codes
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
                            <th>Member</th>
                            <th>Service Category</th>
                            <th>Referral Code</th>
                            <th>Commission Rate</th>
                            <th>Performance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                                    <span class="avatar avatar-sm me-2" style="background-color: {{ $assignment->serviceCategory->color }};">
                                        <i class="isax {{ $assignment->serviceCategory->icon }}"></i>
                                    </span>
                                    <span>{{ $assignment->serviceCategory->name }}</span>
                                </div>
                            </td>
                            <td>
                                <code class="bg-light p-1 rounded">{{ $assignment->referral_code }}</code>
                                <button class="btn btn-sm btn-link copy-btn" data-code="{{ $assignment->referral_code }}">
                                    <i class="isax isax-copy"></i>
                                </button>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $assignment->commission_rate }}%</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small>Sales: ${{ number_format($assignment->total_sales, 2) }}</small>
                                    <small>Commission: ${{ number_format($assignment->total_commission, 2) }}</small>
                                    <small>Referrals: {{ $assignment->referral_count }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $assignment->status == 'active' ? 'success' : ($assignment->status == 'suspended' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($assignment->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('member-services.edit', $assignment->id) }}" 
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Edit">
                                        <i class="isax isax-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Performance">
                                        <i class="isax isax-chart"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="isax isax-profile-2user fs-48 mb-2"></i>
                                    <p>No member service assignments found</p>
                                    <a href="{{ route('member-services.create') }}" class="btn btn-primary">
                                        Assign First Service
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
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
</div>

@push('scripts')
<script>
    // Copy referral code
    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function() {
            const code = this.getAttribute('data-code');
            navigator.clipboard.writeText(code).then(() => {
                const originalIcon = this.innerHTML;
                this.innerHTML = '<i class="isax isax-tick-circle text-success"></i>';
                setTimeout(() => {
                    this.innerHTML = originalIcon;
                }, 2000);
            });
        });
    });
</script>
@endpush
@endsection