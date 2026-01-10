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
                            <h5 class="mb-3">Edit Member</h5>
                            <form action="{{ route('members.update', $member->id) }}" id="editForm" enctype="multipart/form-data">
                                @method('PUT')

                                <!-- MLM Sponsor Section -->
                                <div class="border-bottom mb-4 pb-3">
                                    <h6 class="mb-3">MLM Sponsor Information</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Select Sponsor <span class="text-danger ms-1">*</span></label>
                                                <select class="form-control select2" name="sponsor_id" id="sponsor_id" required>
                                                    <option value="">-- Select Sponsor --</option>
                                                    @foreach($sponsors as $sponsor)
                                                        <option value="{{ $sponsor->id }}" {{ $sponsor->id == $member->sponsor_id ? 'selected' : '' }}>
                                                            {{ $sponsor->first_name }} {{ $sponsor->last_name }} 
                                                            ({{ $sponsor->member_id ?? 'N/A' }}) - {{ $sponsor->mobile }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-muted">The sponsor who referred this member</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Sponsor Information</label>
                                                <div id="sponsor-info" class="border p-3 rounded bg-light">
                                                    <p class="mb-1"><strong>No sponsor selected</strong></p>
                                                    <p class="mb-1 text-muted small">Select a sponsor to view details</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <i class="isax isax-info-circle me-2"></i>
                                                <strong>Note:</strong> The sponsor must be an active member. This determines the member's position in the MLM structure.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Image Upload -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xxl border border-dashed bg-light me-3 flex-shrink-0" id="avatarPreview"> 
                                            @if($member->image)
                                                <img src="{{ $member->profile_image }}" alt="Current Image" class="w-100 h-100 object-fit-cover rounded-circle">
                                            @else
                                                <i class="isax isax-image text-primary fs-24"></i>
                                            @endif
                                        </div>
                                        <div class="d-inline-flex flex-column align-items-start">
                                            <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                <i class="isax isax-image me-1"></i>Upload Image
                                                <input type="file" name="image" class="form-control image-sign">
                                            </div>
                                            <span class="text-gray-9">JPG or PNG format, not exceeding 2MB.</span>
                                            @if($member->image)
                                                <div class="mt-2">
                                                    <input type="checkbox" name="remove_image" id="remove_image">
                                                    <label for="remove_image" class="text-danger small">Remove current image</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Personal Information -->
                                <h6 class="mb-3">Personal Information</h6>
                                <div class="row gx-3">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">First Name <span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" name="first_name" value="{{ $member->first_name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Last Name <span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $member->last_name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                                            <input type="email" class="form-control" name="email" value="{{ $member->email }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Mobile <span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" name="mobile" value="{{ $member->mobile }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current password">
                                            <small class="text-muted">Leave empty if you don't want to change password</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-0">Date of Birth</label>
                                            <input type="text" class="form-control" name="dob" id="dob" value="{{ $member->dob }}" data-provider="flatpickr">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-0">Anniversary</label>
                                            <input type="text" class="form-control" name="anniversary" id="anniversary" value="{{ $member->anniversary }}" data-provider="flatpickr">
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
                                                <input type="text" class="form-control" name="address1" value="{{ $member->address1 }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Address Line 2</label>
                                                <input type="text" class="form-control" name="address2" value="{{ $member->address2 }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control" name="city" value="{{ $member->city }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Zip/Postal Code</label>
                                                <input type="text" class="form-control" name="zip" value="{{ $member->zip }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Country</label>
                                                <select class="select form-control" name="countryid" id="countryid">
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $c)
                                                        <option value="{{ $c['id'] }}" {{ $member->countryid == $c['id'] ? 'selected' : '' }}>
                                                            {{ $c['name'] }}
                                                        </option>
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
                                                        <option value="{{ $s['id'] }}" {{ $member->regionid == $s['id'] ? 'selected' : '' }}>
                                                            {{ $s['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex align-items-center justify-content-between pt-4 border-top">
                                    <button type="submit" class="btn btn-primary submitBtn">Update Member</button>
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
    const selectedSponsorId = $('#sponsor_id').val();
if (selectedSponsorId) {
    loadSponsorInfo(selectedSponsorId);
}
    // Initialize date pickers
    flatpickr("#dob", {
        altInput: true,
        altFormat: "d M, Y",
        dateFormat: "Y-m-d",
        defaultDate: "{{ $member->dob }}"
    });
    
    flatpickr("#anniversary", {
        altInput: true,
        altFormat: "d M, Y",
        dateFormat: "Y-m-d",
        defaultDate: "{{ $member->anniversary }}"
    });
 $('#sponsor_id').on('change', function() {
    loadSponsorInfo($(this).val());
});
    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Form submission
    $('#editForm').on('submit', async function(e) {
        e.preventDefault();
        // Validate sponsor selection
        var sponsorId = $('#sponsor_id').val();
        if (!sponsorId) {
            showError('Please select a sponsor');
            return;
        }
        $('.submitBtn').prop('disabled', true);
        $('.loadingSpinner').removeClass('d-none');

        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('members.update', $member->id) }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showSuccess(response.message || 'Member updated successfully');
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
                    showError('An error occurred while updating member');
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

function loadSponsorInfo(sponsorId) {
    if (!sponsorId) {
        $('#sponsor-info').html(`
            <p class="mb-1"><strong>No sponsor selected</strong></p>
            <p class="mb-1 text-muted small">Select a sponsor to view details</p>
        `);
        return;
    }

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
}

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