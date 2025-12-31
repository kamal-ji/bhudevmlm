  @extends('layouts.admin')
  @section('content')
  <div class="content">
      <!-- start row -->
      <div class="row">
          <div class="col-md-10 mx-auto">
              <div>
                  <div class="d-flex align-items-center justify-content-between mb-3">
                      <h6><a href="{{ route('customers') }}"><i class="isax isax-arrow-left me-2"></i>Customer</a></h6>
                      
                  </div>
                  <div class="card">
                      <div class="card-body">
                          <h6 class="mb-3">Basic Details</h6>
                          <form action="{{route('customers.update', $customer['customerid'])}}" id="createForm"
                              data-customer-id="{{ $customer['customerid'] }}" enctype="multipart/form-data">
                              <div class="mb-3">
                                 
                                  <div class="d-flex align-items-center">
                                      <div class="avatar avatar-xxl border border-dashed bg-light me-3 flex-shrink-0"
                                          id="avatarPreview">
                                          @if(!empty($customer['image'])) 
            <img src="{{get('image_url') . $customer['image']}}" 
                 alt="Customer Image" 
                 class="img-fluid h-100 w-100 object-fit-cover">
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
                                      </div>
                                  </div>
                              </div>
                              <div class="row gx-3">
                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">
                                          <label class="form-label">First Name <span
                                                  class="text-danger ms-1">*</span></label>
                                          <input type="text" class="form-control" name="first_name" value="{{$customer['first_name']}}">
                                      </div>
                                  </div>
                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">
                                          <label class="form-label">Last Name <span
                                                  class="text-danger ms-1">*</span></label>
                                          <input type="text" class="form-control" name="last_name" value="{{$customer['last_name']}}">
                                      </div>
                                  </div>
                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">
                                          <label class="form-label">Email <span
                                                  class="text-danger ms-1">*</span></label>
                                          <input type="email" class="form-control" name="email" value="{{$customer['email']}}">
                                      </div>
                                  </div>
                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">
                                          <label class="form-label">Mobile <span
                                                  class="text-danger ms-1">*</span></label>
                                          <input type="text" class="form-control" name="mobile" value="{{$customer['mobile']}}">
                                      </div>
                                  </div>

                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">
                                          <label class="form-label">Gender <span
                                                  class="text-danger ms-1">*</span></label>
                                          <select class="select" name="gender">
    <option value="">Select</option>
    <option value="male" {{ (isset($customer['gender']) && $customer['gender'] === 'male') ? 'selected' : '' }}>Male</option>
    <option value="female" {{ (isset($customer['gender']) && $customer['gender'] === 'female') ? 'selected' : '' }}>Female</option>
</select>

                                      </div>
                                  </div>

                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">


                                          <label class="form-label mb-0">Date of birth</label>

                                          <input type="text" class="form-control" name="dob" id="dob"
                                              data-provider="flatpickr" value="{{$customer['dob']}}">
                                      </div>
                                  </div>
                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">


                                          <label class="form-label mb-0">Anniversary</label>

                                          <input type="text" class="form-control" name="anniversary"
                                              data-provider="flatpickr" id="anniversary" value="{{$customer['anniversary']}}">
                                      </div>
                                  </div>
                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">
                                          <label class="form-label">Currency<span
                                                  class="text-danger ms-1">*</span></label>
                                         <select class="select form-control" name="currency" id="currency">
    <option value="">Select Currency</option>
    @foreach($currency as $item)
        <option value="{{ $item['id'] }}" 
            {{ (isset($customer['currencyid']) && $customer['currencyid'] == $item['id']) ? 'selected' : '' }}>
            {{ $item['name'] }}
        </option>
    @endforeach
</select>

                                      </div>
                                  </div>


                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">
                                          <label class="form-label">Group <span
                                                  class="text-danger ms-1">*</span></label>
                                          <select class="select form-control" name="group" id="group">
    <option value="">Select Group</option>
    @foreach($group as $item)
        <option value="{{ $item['id'] }}" 
            {{ (isset($customer['groupid']) && $customer['groupid'] == $item['id']) ? 'selected' : '' }}>
            {{ $item['name'] }}
        </option>
    @endforeach
</select>

                                      </div>
                                  </div>

                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">
                                          <label class="form-label">Template <span
                                                  class="text-danger ms-1">*</span></label>
                                          <select class="select form-control" name="template" id="template">

                                              @foreach($template as $item)
                                              <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>

                                  <div class="col-lg-4 col-md-6">
                                      <div class="mb-3">
                                          <label class="form-label">Note <span class="text-danger ms-1"></span></label>
                                          <input type="text" class="form-control" name="note" value="{{$customer['note']}}">
                                      </div>
                                  </div>
                              </div>
                              <div class="border-top my-2">
                                  <div class="row gx-5">
                                      <div class="col-md-12 ">
                                          <h6 class="mb-3 pt-4"> Address Details</h6>
                                          <div class="row">

                                              <div class="col-md-6">
                                                  <div class="mb-3">
                                                      <label class="form-label">Address Line 1<span
                                                              class="text-danger ms-1">*</span></label>
                                                      <input type="text" class="form-control" name="address_1"
                                                          id="address_1" value="{{$customer['address1']}}">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="mb-3">
                                                      <label class="form-label">Address Line 2<span
                                                              class="text-danger ms-1"></span></label>
                                                      <input type="text" class="form-control" name="address_2"
                                                          id="address_2" value="{{$customer['address2']}}">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="mb-3">
                                                      <label class="form-label">Country<span
                                                              class="text-danger ms-1">*</span></label>
                                                     <select class="select form-control" name="countryid" id="editcountryid">
    <option value="">Select</option>
    @foreach($countries as $c)
        <option value="{{ $c['id'] }}"
            {{ old('countryid', $customer['countryid']) == $c['id'] ? 'selected' : '' }}>
            {{ $c['name'] }}
        </option>
    @endforeach
</select>

                                                  </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="mb-3">
                                                      <label class="form-label">region<span
                                                              class="text-danger ms-1">*</span></label>
                                                      <select class="select" name="regionid" id="editregionid">
                                                         
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="mb-3">
                                                      <label class="form-label">City <span
                                                              class="text-danger ms-1">*</span></label>
                                                      <input type="text" class="form-control" name="city" id="city" value="{{$customer['city']}}">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="mb-3">
                                                      <label class="form-label">Zip code <span
                                                              class="text-danger ms-1">*</span></label>
                                                      <input type="text" class="form-control" name="zipcode"
                                                          id="zipcode"  value="{{$customer['zip']}}">
                                                  </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="mb-3">
                                                      <label class="form-label">Building no <span
                                                              class="text-danger ms-1">*</span></label>
                                                      <input type="text" class="form-control" name="buildingno"
                                                          id="buildingno"   value="{{$customer['buildingno']}}">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                  </div>
                              </div>
                              <div class="border-top my-2">
                                  <h6 class="mb-3 pt-4">Card Details</h6>
                                  <div class="row gx-3">
                                      <div class="col-lg-4 col-md-6">
                                          <div class="mb-3">
                                              <label class="form-label">Card no</label>
                                              <input type="text" class="form-control" name="card_no" value="{{$customer['card_no']}}">
                                          </div>
                                      </div>
                                      <div class="col-lg-4 col-md-6">
                                          <div class="mb-3">
                                              <label class="form-label">Card issue</label>
                                              <input type="text" class="form-control" name="card_issue" id="card_issue" data-provider="flatpickr"    value="{{$customer['card_issue']}}">
                                          </div>
                                      </div>
                                      <div class="col-lg-4 col-md-6">
                                          <div class="mb-3">
                                              <label class="form-label">Card Expiry</label>
                                              <input type="text" class="form-control" name="card_expiry" id="card_expiry" data-provider="flatpickr" value="{{$customer['card_expiry']}}">
                                          </div>
                                      </div>


                                  </div>
                              </div>
                              <div class="d-flex align-items-center justify-content-between pt-4 border-top">
                                  <button type="button" class="btn btn-outline-white">Cancel</button>
                                  <button type="submit" class="btn btn-primary submitBtn">Create New</button>
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
  @endsection
  @push('scripts')

  <script>
$(document).ready(function() {
   
    
    $('#editcountryid').on('change', function() {
                var countryId = $(this).val();
                $.ajax({
                    url: '/getstates/' + countryId,
                    method: 'GET',
                    success: function(response) {
                        $('#editregionid').empty();
                        $('#editregionid').append('<option value="">Select State</option>');
                        $.each(response.states, function(index, state) {
                            $('#editregionid').append('<option value="' + state.id + '">' +
                                state.name + '</option>');
                        });
                         // Optional: pre-select a state when editing
            @if(isset($customer['regionid']))
                $('#editregionid').val('{{ $customer['regionid'] }}');
            @endif
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        showError('An error occurred while fetching states');
                    }
                });
            });
   
            $('#editcountryid').trigger('change');

    flatpickr("#dob", {
        altInput: true,
        altFormat: "d M, Y", // shown to the user
        dateFormat: "Y-m-d", // submitted to backend (Laravel likes this)
    });
    flatpickr("#anniversary", {
        altInput: true,
        altFormat: "d M, Y", // shown to the user
        dateFormat: "Y-m-d", // submitted to backend (Laravel likes this)
    });
      flatpickr("#card_issue", {
    altInput: true,
    altFormat: "d M, Y",    // shown to the user
    dateFormat: "Y-m-d",    // submitted to backend (Laravel likes this)
});
  flatpickr("#card_expiry", {
    altInput: true,
    altFormat: "d M, Y",    // shown to the user
    dateFormat: "Y-m-d",    // submitted to backend (Laravel likes this)
});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#createForm').on('submit', async function(e) {
        e.preventDefault();

        $('.submitBtn').prop('disabled', true);
        $('.loadingSpinner').removeClass('d-none');

        const form = $('#createForm')[0];
        const formData = new FormData(form);
        const customerId = $('#createForm').data('customer-id');
        formData.append('_method', 'PUT');
        // Manually append device_token and any additional fields not in inputs


        $.ajax({
            url: "{{ route('customers.update', ['customer' => $customer['customerid']]) }}",
            method: 'POST',
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function(response) {
                if (response.success) {
                    showSuccess(response.message || 'Customer updated successfully');
                    window.location.href = response.redirect_url || '/customers';
                } else {

                    showError(response.message || 'Something went wrong');
                }
            },
            error: function(xhr) {
                $('.form-error').remove();
                let errorMsg = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.errors) {

                    for (let field in xhr.responseJSON.errors) {
                        if (xhr.responseJSON.errors.hasOwnProperty(field)) {
                            let errorMsg = xhr.responseJSON.errors[field][0];

                            // Find the field's input or label element
                            let fieldElement = $('[name="' + field + '"]');

                            // Create an error message element
                            let errorElement = $('<div class="form-error"></div>').text(
                                errorMsg);

                            // Append the error message below the field
                            fieldElement.after(errorElement);
                        }
                    }

                } else if (xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                    showError(errorMsg);
                } else {
                    // If no specific error, show a generic error
                    showError('An error occurred');
                }


            },
            complete: function() {
                $('.submitBtn').prop('disabled', false);
                $('.loadingSpinner').addClass('d-none');
            }
        });
    });
});

$(document).ready(function() {
    $('.image-sign').on('change', function(e) {
        const file = e.target.files[0];

        if (file && file.type.startsWith('image/')) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Image must not exceed 2MB.');
                $(this).val(''); // clear the input
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove existing image/icon inside the avatar
                $('#avatarPreview').html('<img src="' + e.target.result +
                    '" alt="Preview" class="w-100 h-100 object-fit-cover rounded-circle">');
            };
            reader.readAsDataURL(file);
        } else {
            alert('Please select a valid image file (JPG or PNG).');
            $(this).val('');
        }
    });
});
  </script>
  @endpush