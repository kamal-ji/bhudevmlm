   @extends('layouts.admin')

   @section('content')
   <!-- Start Content -->
   <div class="content">

       <!-- start row -->
       <div class="row">
           <div class="col-md-10 mx-auto">
               <div>
                   <div class="d-flex align-items-center justify-content-between mb-3">
                       <h6><a href="{{route('customers.address_list', ['customer' => $id])}}"><i class="isax isax-arrow-left me-2"></i>Address</a></h6>
                     
                   </div>
                   <div class="card">
                       <div class="card-body">
                           <h5 class="mb-3">Add Address</h5>
                           <form action="{{route('customers.address.store')}}" id="createForm" enctype="multipart/form-data">
                               
                               <div class="row gx-3">
                                   <div class="col-lg-4 col-md-6">
                                       <div class="mb-3">
                                           <label class="form-label">ship name <span
                                                   class="text-danger ms-1">*</span></label>
                                           <input type="text" class="form-control" name="ship_name">
                                            <input type="hidden" class="form-control" name="id" value="{{$id}}">
                                       </div>
                                   </div>
                                   <div class="col-lg-4 col-md-6">
                                       <div class="mb-3">
                                           <label class="form-label">Contact name <span
                                                   class="text-danger ms-1">*</span></label>
                                           <input type="text" class="form-control" name="contact_name">
                                       </div>
                                   </div>
                               
                                     <div class="col-lg-4 col-md-6">
                                       <div class="mb-3">
                                           <label class="form-label">Mobile <span
                                                   class="text-danger ms-1">*</span></label>
                                           <input type="text" class="form-control" name="mobile">
                                       </div>
                                   </div>
                                   
                                    <div class="col-lg-4 col-md-6">
                                       <div class="mb-3">
                                           <label class="form-label">Email <span
                                                   class="text-danger ms-1">*</span></label>
                                           <input type="text" class="form-control" name="email">
                                       </div>
                                   </div>

                                    <div class="col-lg-4 col-md-6">
                                       <div class="mb-3">
                                           <label class="form-label">Note <span
                                                   class="text-danger ms-1"></span></label>
                                           <input type="text" class="form-control" name="note">
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
                                                       <input type="text" class="form-control" name="address_1" id="address_1">
                                                   </div>
                                               </div>
                                               <div class="col-md-6">
                                                   <div class="mb-3">
                                                       <label class="form-label">Address Line 2<span
                                                   class="text-danger ms-1"></span></label>
                                                       <input type="text" class="form-control" name="address_2" id="address_2">
                                                   </div>
                                               </div>
                                              <div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Country<span
                                                   class="text-danger ms-1">*</span></label>
        <select class="select form-control" name="countryid" id="countryid">
            <option value="">Select</option>
            @foreach($countries as $c)
                <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
            @endforeach
        </select>
    </div>
</div>

                                               <div class="col-md-6">
                                                   <div class="mb-3">
                                                       <label class="form-label">region<span
                                                   class="text-danger ms-1">*</span></label>
                                                       <select class="select" name="regionid" id="regionid">
                                                         
                                                       </select>
                                                   </div>
                                               </div>
                                               <div class="col-md-6">
                                                   <div class="mb-3">
                                                       <label class="form-label">City <span
                                                   class="text-danger ms-1">*</span></label>
                                                       <input type="text" class="form-control" name="city" id="city">
                                                   </div>
                                               </div>
                                               <div class="col-md-6">
                                                   <div class="mb-3">
                                                       <label class="form-label">Zip code <span
                                                   class="text-danger ms-1">*</span></label>
                                                       <input type="text" class="form-control" name="zipcode" id="zipcode">
                                                   </div>
                                               </div>

                                               <div class="col-md-6">
                                                   <div class="mb-3">
                                                       <label class="form-label">Building no <span
                                                   class="text-danger ms-1">*</span></label>
                                                       <input type="text" class="form-control" name="buildingno" id="buildingno">
                                                   </div>
                                               </div>
                                           </div>
                                       </div>

                                   </div>
                               </div>
                             
                               <div class="d-flex align-items-center justify-content-between pt-4 border-top">
                                   
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
   <!-- End Content -->

   @endsection
   @push('scripts')
   
   <script>
$(document).ready(function() {

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

        // Manually append device_token and any additional fields not in inputs
     const customerId = "{{ $id }}";

        $.ajax({
            url: form.action,
            method: 'POST',
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function(response) {
                if (response.success) {
                    showSuccess(response.message || 'Address created successfully');
                    window.location.href = response.redirect_url || `/customers/${customerId}/address_list`;
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
                let errorElement = $('<div class="form-error"></div>').text(errorMsg);

                // Append the error message below the field
                fieldElement.after(errorElement);
                        }
                        }
                   
                }else if (xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                        showError(errorMsg);
                    }else {
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


   </script>
   @endpush