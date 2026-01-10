@extends('layouts.admin')

@section('content')
    <!-- Start Content -->
    <div class="content">

        <!-- start row -->
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6><a href="{{ route('members.index') }}"><i class="isax isax-arrow-left me-2"></i>Members</a></h6>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Add New Member</h5>
                            <form action="{{ route('members.store') }}" id="createForm" enctype="multipart/form-data">
                               
                               <!-- MLM Sponsor Section -->
                               <!-- In create.blade.php -->
<div class="border-bottom mb-4 pb-3">
    <h6 class="mb-3">MLM Sponsor Information</h6>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Select Sponsor</label>
                <select class="form-control select2" name="sponsor_id" id="sponsor_id">
                    <option value="">-- No Sponsor (Root Member) --</option>
                    @if(count($sponsors) > 0)
                        @foreach($sponsors as $sponsor)
                            <option value="{{ $sponsor->id }}">
                                {{ $sponsor->first_name }} {{ $sponsor->last_name }} 
                                ({{ $sponsor->member_id ?? 'N/A' }}) - {{ $sponsor->mobile }}
                            </option>
                        @endforeach
                    @else
                        <option value="" disabled selected>-- No sponsors available (First Member) --</option>
                    @endif
                </select>
                @if(count($sponsors) == 0)
                    <small class="text-info">
                        <i class="isax isax-info-circle me-1"></i>
                        This will be the first member (Root) of the MLM system
                    </small>
                @else
                    <small class="text-muted">Select a sponsor or leave blank for root member</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Sponsor Information</label>
                <div id="sponsor-info" class="border p-3 rounded bg-light">
                    <p class="mb-1"><strong>No sponsor selected</strong></p>
                    <p class="mb-1 text-muted small">
                        @if(count($sponsors) == 0)
                            This will be the root member of your MLM structure
                        @else
                            Select a sponsor to view details
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    @if(count($sponsors) == 0)
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <i class="isax isax-warning-2 me-2"></i>
                    <strong>Creating First Member:</strong> This member will be the <strong>root/head</strong> of your MLM structure. All future members will be placed under existing sponsors.
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="isax isax-info-circle me-2"></i>
                    <strong>Note:</strong> For best results, select an active member as sponsor. Leave blank only for creating top-level/root members.
                </div>
            </div>
        </div>
    @endif
</div>
                                <!-- Profile Image Upload -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xxl border border-dashed bg-light me-3 flex-shrink-0" id="avatarPreview"> 
                                            <i class="isax isax-image text-primary fs-24"></i>
                                        </div>
                                        <div class="d-inline-flex flex-column align-items-start">
                                            <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                <i class="isax isax-image me-1"></i>Upload Image
                                                <input type="file" name="image" class="form-control image-sign">
                                            </div>
                                            <span class="text-gray-9">JPG or PNG format, not exceeding 2MB.</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Personal Information -->
                                <h6 class="mb-3">Personal Information</h6>
                                <div class="row gx-3">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">First Name <span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" name="first_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Last Name <span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" name="last_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Mobile <span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" name="mobile" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Password <span class="text-danger ms-1">*</span></label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-0">Date of Birth</label>
                                            <input type="text" class="form-control" name="dob" id="dob" data-provider="flatpickr">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-0">Anniversary</label>
                                            <input type="text" class="form-control" name="anniversary" id="anniversary" data-provider="flatpickr">
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Details -->
                                <div class="border-top my-4 pt-4">
                                    <h6 class="mb-3">Address Details</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Address Line 1</label>
                                                <input type="text" class="form-control" name="address1">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Address Line 2</label>
                                                <input type="text" class="form-control" name="address2">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control" name="city">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Zip/Postal Code</label>
                                                <input type="text" class="form-control" name="zip">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Country</label>
                                                <select class="select form-control" name="countryid" id="countryid">
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $c)
                                                        <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Region/State</label>
                                                <select class="select form-control" name="regionid" id="regionid">
                                                    <option value="">Select Region</option>
                                                    @foreach($states as $s)
                                                        <option value="{{ $s['id'] }}">{{ $s['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex align-items-center justify-content-between pt-4 border-top">
                                    <button type="submit" class="btn btn-primary submitBtn">Create Member</button>
                                    <div class="spinner-border spinner-border-sm d-none loadingSpinner" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </form>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

    </div>
    <!-- End Content -->
@endsection

@push('scripts')
<script>
$(document).ready(function() {
     // Initialize Select2 for sponsor dropdown
    $('#sponsor_id').select2({
        placeholder: "Search and select sponsor",
        allowClear: true,
        width: '100%'
    });
    // Initialize date pickers
    flatpickr("#dob", {
        altInput: true,
        altFormat: "d M, Y",
        dateFormat: "Y-m-d",
    });
    
    flatpickr("#anniversary", {
        altInput: true,
        altFormat: "d M, Y",
        dateFormat: "Y-m-d",
    });

    // Sponsor selection change
    $('#sponsor_id').on('change', function() {
        var sponsorId = $(this).val();
        if (sponsorId) {
            // Fetch sponsor details via AJAX
            $.ajax({
                url: "{{ route('members.sponsor.details') }}",
                type: 'GET',
                data: { sponsor_id: sponsorId },
                success: function(response) {
                    if (response.success) {
                        $('#sponsor-info').html(`
                            <p class="mb-1"><strong>${response.data.full_name}</strong></p>
                            <p class="mb-1 small">Member ID: ${response.data.member_id}</p>
                            <p class="mb-1 small">Mobile: ${response.data.mobile}</p>
                            <p class="mb-1 small">Email: ${response.data.email}</p>
                            <p class="mb-1 small">Total Downline: ${response.data.total_downline || 0}</p>
                        `);
                    }
                },
                error: function() {
                    $('#sponsor-info').html('<p class="text-danger">Failed to load sponsor details</p>');
                }
            });
        } else {
            $('#sponsor-info').html(`
                <p class="mb-1"><strong>No sponsor selected</strong></p>
                <p class="mb-1 text-muted small">Select a sponsor to view details</p>
            `);
        }
    });


    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Form submission
    $('#createForm').on('submit', async function(e) {
        e.preventDefault();
        // Validate sponsor selection
     

        $('.submitBtn').prop('disabled', true);
        $('.loadingSpinner').removeClass('d-none');

        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('members.store') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showSuccess(response.message || 'Member created successfully');
                    window.location.href = response.redirect_url;
                } else {
                    showError(response.message || 'Something went wrong');
                }
            },
            error: function(xhr) {
                $('.form-error').remove();
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    for (let field in xhr.responseJSON.errors) {
                        if (xhr.responseJSON.errors.hasOwnProperty(field)) {
                            let errorMsg = xhr.responseJSON.errors[field][0];
                            let fieldElement = $('[name="' + field + '"]');
                            let errorElement = $('<div class="form-error text-danger small mt-1"></div>').text(errorMsg);
                            fieldElement.after(errorElement);
                        }
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    showError(xhr.responseJSON.message);
                } else {
                    showError('An error occurred while creating member');
                }
            },
            complete: function() {
                $('.submitBtn').prop('disabled', false);
                $('.loadingSpinner').addClass('d-none');
            }
        });
    });
    
    // Image preview
    $('.image-sign').on('change', function(e) {
        const file = e.target.files[0];

        if (file && file.type.startsWith('image/')) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Image must not exceed 2MB.');
                $(this).val('');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#avatarPreview').html('<img src="' + e.target.result + '" alt="Preview" class="w-100 h-100 object-fit-cover rounded-circle">');
            };
            reader.readAsDataURL(file);
        } else {
            alert('Please select a valid image file (JPG or PNG).');
            $(this).val('');
        }
    });

    // Load regions based on country
      $('#country_list').change(function() {
             var countryId = $(this).val();

             $.ajax({
                 url: '{{ route('getstates', ['countryId' => '%country%']) }}'.replace('%country%',
                     countryId),
                 type: 'GET',
                 success: function(response) {
                     $('#regionid').html('<option value="">Select</option>');

                     for (var i = 0; i < response.states.length; i++) {
                         $('#regionid').append('<option value="' + response.states[i].id + '">' +
                             response.states[i].name + '</option>');
                     }

                     $('#regionid').trigger('change');
                 }
             });
         });
});

// Helper functions for notifications
function showSuccess(message) {
    // Implement your success notification here
    alert('Success: ' + message);
}

function showError(message) {
    // Implement your error notification here
    alert('Error: ' + message);
}
</script>
@endpush