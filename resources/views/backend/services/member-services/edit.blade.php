@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Edit Member Service Assignment</h6>
            <p class="text-muted mb-0">Update member service category settings</p>
        </div>
        <div>
            <a href="{{ route('member-services.index') }}" class="btn btn-light">
                <i class="isax isax-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('member-services.update', $assignment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="mb-2">Member Information</h6>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-lg rounded-circle me-3">
                                                <span class="avatar-initial bg-primary">{{ substr($assignment->member->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h5 class="mb-0">{{ $assignment->member->name }}</h5>
                                                <p class="text-muted mb-0">{{ $assignment->member->email }}</p>
                                                <small>Member ID: {{ $assignment->member->id }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="mb-2">Service Category</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-lg me-3" style="background-color: {{ $assignment->serviceCategory->color }};">
                                                <i class="isax {{ $assignment->serviceCategory->icon }} fs-24"></i>
                                            </span>
                                            <div>
                                                <h5 class="mb-0">{{ $assignment->serviceCategory->name }}</h5>
                                                <p class="text-muted mb-0">{{ $assignment->serviceCategory->description }}</p>
                                                <small>Default Rate: {{ $assignment->serviceCategory->commission_rate }}%</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Referral Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $assignment->referral_code }}" readonly>
                                <button type="button" class="btn btn-primary copy-btn" data-code="{{ $assignment->referral_code }}">
                                    <i class="isax isax-copy"></i> Copy
                                </button>
                            </div>
                            <small class="text-muted">Referral code is unique and cannot be changed</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Commission Rate (%) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="commission_rate" 
                                           step="0.01" min="0" max="100" required
                                           value="{{ old('commission_rate', $assignment->commission_rate) }}">
                                    <small class="text-muted">Override the default category rate for this member</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="active" {{ $assignment->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $assignment->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="suspended" {{ $assignment->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Performance Statistics</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h3 class="mb-1">${{ number_format($assignment->total_sales, 2) }}</h3>
                                            <p class="text-muted mb-0">Total Sales</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h3 class="mb-1">${{ number_format($assignment->total_commission, 2) }}</h3>
                                            <p class="text-muted mb-0">Total Commission</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h3 class="mb-1">{{ $assignment->referral_count }}</h3>
                                            <p class="text-muted mb-0">Referrals</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h3 class="mb-1">{{ $assignment->orders()->count() }}</h3>
                                            <p class="text-muted mb-0">Total Orders</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('member-services.index') }}" class="btn btn-light">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="isax isax-save me-1"></i> Update Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Recent Referrals</h6>
                    @if($assignment->orders()->count() > 0)
                        @foreach($assignment->orders()->latest()->take(5)->get() as $order)
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm rounded-circle me-2">
                                <span class="avatar-initial bg-success">{{ substr($order->member->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $order->member->name }}</h6>
                                <small class="text-muted">Order: {{ $order->order_number }}</small>
                            </div>
                            <div class="text-end">
                                <strong>${{ number_format($order->amount, 2) }}</strong>
                                <br>
                                <small class="text-success">+ ${{ number_format($order->commission_amount, 2) }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-center py-3">
                        <i class="isax isax-receipt-text fs-48 text-muted mb-2"></i>
                        <p class="text-muted mb-0">No referrals yet</p>
                    </div>
                    @endif
                    
                    <hr>
                    
                    <h6 class="mb-3">Share Referral</h6>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" 
                               value="{{ url('/register?ref=' . $assignment->referral_code) }}" 
                               id="referral_link" readonly>
                        <button class="btn btn-primary copy-btn" 
                                data-code="{{ url('/register?ref=' . $assignment->referral_code) }}">
                            <i class="isax isax-copy"></i>
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="https://wa.me/?text={{ urlencode('Join using my referral code: ' . $assignment->referral_code) }}" 
                           class="btn btn-success btn-sm flex-fill" target="_blank">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="mailto:?subject=Join Our Service&body=Use my referral code: {{ $assignment->referral_code }}" 
                           class="btn btn-danger btn-sm flex-fill">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Copy functionality
    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function() {
            const code = this.getAttribute('data-code');
            const input = this.closest('.input-group').querySelector('input');
            
            if (input) {
                input.select();
                input.setSelectionRange(0, 99999);
            }
            
            navigator.clipboard.writeText(code).then(() => {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="isax isax-tick-circle"></i> Copied!';
                this.classList.remove('btn-primary');
                this.classList.add('btn-success');
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-primary');
                }, 2000);
            });
        });
    });
</script>
@endpush
@endsection