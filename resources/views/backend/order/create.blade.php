@extends('layouts.admin')

@section('content')
@php
$homeClient = getHomeClient();
$currency =$homeClient['data']['currency'] ?? '';
@endphp
<!-- Start Content -->
<!-- Start Content -->
<style>
.cart-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.cart-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    border: 1px solid #ddd;
    padding: 1rem;
    border-radius: 8px;
    background: #fff;
    transition: box-shadow 0.3s ease;
}

.cart-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.cart-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
}

.cart-details {
    flex: 1;
}

.cart-title {
    font-size: 1.1rem;
    margin: 0 0 0.3rem;
}

.cart-desc {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0.5rem;
}

.cart-prices {
    margin-bottom: 0.8rem;
}

.cart-prices .price {
    color: #28a745;
    font-weight: 600;
    margin-right: 8px;
}

.cart-prices .regular-price {
    color: #999;
    text-decoration: line-through;
    font-size: 0.9rem;
}
.invalid-feedback{

}
.table thead tr th {
    color: #fff !important;
}
</style>
<div class="content">
    @if(!empty($cartlists['items']) && count($cartlists['items']) > 0)
    <!-- start row -->
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6><a href="{{ route('orders') }}"><i class="isax isax-arrow-left me-2"></i>Order/Estimate</a></h6>

                </div>
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3">Quotation Details</h6>
                       <form action="{{ route('orders.store') }}" id="createForm" method="POST" enctype="multipart/form-data">
    @csrf
                            <div class="border-bottom mb-3 pb-1">

                                <!-- start row -->
                                <div class="row justify-content-between">
                                    <div class="col-xl-5 col-lg-7">

                                        <!-- start row -->
                                        <div class="row gx-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Order Type</label>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="ordertype"
                                                            id="Radio-sm-1" checked="" value="order">
                                                        <label class="form-check-label" for="Radio-sm-1">
                                                            Order
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="ordertype"
                                                            id="Radio-sm-2" value="estimate">
                                                        <label class="form-check-label" for="Radio-sm-2">
                                                            Estimate
                                                        </label>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->


                                        </div>
                                        <!-- end row -->

                                    </div><!-- end col -->

                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                            </div>

                            <div class="border-bottom mb-3">

                                <!-- start row -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <h6 class="mb-3">Bill To</h6>

                                                <div>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <label class="form-label">Customer Name</label>
                                                     
                                                    </div>

                                                    <div class="mb-3">
                                                        <select id="customer-list"  name="clientid" class="form-select w-100"></select>
                                                         <div class="invalid-feedback">Please select a customer.</div>
                                                    </div>

                                                    <div id="customer-details"
                                                        class="bg-light border rounded p-3 d-none d-flex align-items-start">
                                                        <span
                                                            class="avatar avatar-lg border bg-dark flex-shrink-0 me-3">
                                                            <img id="customer-avatar"
                                                                src="{{ asset('assets/img/icons/black-icon.png') }}"
                                                                alt="User Img">
                                                        </span>
                                                        <div>
                                                            <h6 id="customer-name" class="fs-14 fw-semibold mb-1"></h6>
                                                            <p id="customer-address" class="mb-1 fs-13"></p>
                                                            <p id="customer-phone" class="mb-1 fs-13"></p>
                                                            <p id="customer-email" class="mb-1 fs-13"></p>
                                                            <p id="customer-gst" class="text-dark fs-13"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <h6 class="mb-3">Bill From</h6>
                                                <div class="mb-3">
                                                    <label class="form-label">Billed By</label>

                                                    <select id="shipping-list" name="shippingid" class=" select form-select"></select>
                                                    <div class="invalid-feedback">Please select a shipping option.</div>
                                                </div>
                                                <div id="shipping-details" class="bg-light border rounded p-3 d-none">
                                                    <span class="avatar avatar-lg border bg-dark flex-shrink-0 me-3">
                                                        
                                                    </span>
                                                    <div>
                                                        <h6 id="shipping-name" class="fs-14 fw-semibold mb-1"></h6>
                                                        <p id="shipping-address" class="mb-1 fs-13"></p>
                                                        <p id="shipping-phone" class="mb-1 fs-13"></p>
                                                        <p id="shipping-email" class="mb-1 fs-13"></p>
                                                        <p id="shipping-gst" class="text-dark fs-13"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end col -->

                                </div>
                                <!-- end row -->

                            </div>

                            <div class="border-bottom mb-3 pb-3">

                                <!-- start row -->
                                <div class="row">
                                    <div class="col-xl-4 col-md-6">
                                        <h6 class="mb-3">Items & Details</h6>

                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="table-responsive rounded table-nowrap border-bottom-0 border mb-3">
                                    <table class="table mb-0 add-table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Pcs</th>
                                                <th>Price</th>

                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="add-tbody">
                                            @foreach($cartlists['items'] as $item)
                                            <tr id="cartitem-{{ $item['id'] }}">
                                                <td>
                                                    <img src="{{ get('image_url') . $item['image'] ?? asset('images/no-image.png') }}"
                                                        alt="{{ $item['name'] }}" class="cart-image" width="80">

                                                </td>
                                                <td>
                                                    {{ $item['name'] }}
                                                </td>
                                                <td>
                                                    {{ $item['description'] ?? 'No description available' }}
                                                </td>
                                                <td>
                                                    {{ $item['pcs'] }}
                                                </td>
                                                <td>
                                                    <div class="cart-prices">
                                                        <span class="price">{{ $item['currency'] }}
                                                            {{ number_format($item['price'], 2) }}</span>
                                                        @if($item['tagprice'] > $item['price'])
                                                        <span class="regular-price">{{ $item['currency'] }}
                                                            {{ number_format($item['tagprice'], 2) }}</span>
                                                        @endif
                                                    </div>
                                                </td>


                                                <td>
                                                    <div>
                                                        <a href="javascript:void(0);"
                                                            class="text-danger remove-table movecart" data-id="{{ $item['id'] }}"><i
                                                                class="isax isax-close-circle"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div>
                                   
                                </div>
                            </div>
                            <div class="border-bottom mb-3">

                                <!-- start row -->
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="mb-3">
                                            <h6 class="mb-3">Extra Information</h6>
                                            <div>
                                                <ul class="nav nav-tabs nav-solid-primary tab-style-1 border-0 p-0 d-flex flex-wrap gap-3 mb-3"
                                                    role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active d-inline-flex align-items-center border fs-12 fw-semibold rounded-2"
                                                            data-bs-toggle="tab" data-bs-target="#notes"
                                                            aria-current="page" href="javascript:void(0);"><i
                                                                class="isax isax-document-text me-1"></i>Add Notes</a>
                                                    </li>

                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active show" id="notes" role="tabpanel">
                                                        <label class="form-label">Additional Notes</label>
                                                        <textarea class="form-control"></textarea>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-lg-5">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <h6 class="fs-14 fw-semibold">Amount</h6>
                                                <h6 class="fs-14 fw-semibold">{{ $currency ?? '' }}
                                                    {{ number_format($cartlists['summary']['subtotal'], 2) }}</h6>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <h6 class="fs-14 fw-semibold">Discount</h6>
                                                <h6 class="fs-14 fw-semibold">- {{ $currency ?? '' }}
                                                    {{ number_format($cartlists['summary']['discount'], 2) }}</h6>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <h6 class="fs-14 fw-semibold">Shipping</h6>
                                                <h6 class="fs-14 fw-semibold">{{ $currency ?? '' }}
                                                    {{ number_format($cartlists['summary']['shipping'], 2) }}</h6>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <h6 class="fs-14 fw-semibold">Tax</h6>
                                                <h6 class="fs-14 fw-semibold">{{ $currency ?? '' }}
                                                    {{ number_format($cartlists['summary']['tax'], 2) }}</h6>
                                            </div>


                                            <div
                                                class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                                <h6>Total</h6>

                                                <h6>{{ $currency ?? '' }}
                                                    {{ number_format($cartlists['summary']['total'], 2) }}</h6>
                                            </div>
                                            <div class="border-bottom mb-3 pb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Total In Words</h6>
                                                <p>{{ numberToWords($cartlists['summary']['total'], $currency ?? 'Dollars') }}
                                                </p>
                                            </div>

                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <button type="button" class="btn btn-outline-white" id="cancelBtn">Cancel</button>
        <button type="submit" class="btn btn-primary" id="submitBtn">
            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            Save
        </button>
                            </div>
                        </form>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
        </div><!-- end col -->
    </div>
    @else
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <div class="empty-box">
                    <i class="isax isax-shopping-cart fs-40 text-muted mb-3 d-block"></i>
                    <h4 class="text-muted mb-2">Your Cart is Empty</h4>
                    <p class="text-secondary mb-3">Add some products to create an order or estimate.</p>
                    <a href="{{ route('products') }}" class="btn btn-primary">
                        <i class="isax isax-bag-2 me-1"></i> Browse Products
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- end row -->
</div>
<!-- End Content -->

<!-- End Content -->
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    let selectedCustomerId = null;

    // Initialize customer list dropdown using AJAX
    $('#customer-list').select2({
        placeholder: 'Select Customer',
        ajax: {
            url: "{{ route('customer.list') }}", // your controller route
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                if (data.success) {
                    return {
                        results: data.results // must be in [{id, text, full}, ...] format
                    };
                } else {
                    return {
                        results: []
                    };
                }
            },
            cache: true
        },
        templateResult: function(data) {
            if (!data.id) return data.text;
            return $('<div>' + data.text + '</div>');
        },
        templateSelection: function(data) {
            return data.text || data.id;
        }
    });

    // When a customer is selected
    $('#customer-list').on('select2:select', function(e) {
        var selected = e.params.data.full;
        selectedCustomerId = selected.customerid;

        console.log('✅ Selected Customer ID:', selectedCustomerId);
        if (selected) {
            // Populate customer details
            $('#customer-name').text(selected.name || '');
            $('#customer-address').text(selected.country || '');
            $('#customer-phone').text('Phone: ' + (selected.mobile || ''));
            $('#customer-email').text('Email: ' + (selected.emailid || ''));


            // Optional: Update avatar if provided by API
            if (selected.image) {
                // Update avatar
                var imageUrl = "{{ get('image_url') }}";
                $('#customer-avatar').attr('src', imageUrl + '/' + selected.image);
            }

            // Show the detail box
            $('#customer-details').removeClass('d-none');
        }

        // Reset and reload shipping list for this customer
        // Clear and reload shipping list
        $('#shipping-list').val(null).trigger('change').empty();
        $('#shipping-list').trigger('reloadShippingList');
    });


    // Initialize Select2 with AJAX
    $('#shipping-list').select2({
        placeholder: 'Select Shipping Address',
        ajax: {
            url: "{{ route('shipping.list') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                console.log('Customer ID:', selectedCustomerId);
                console.log('Customer ID:', 'not');
                // ✅ Pass customerid dynamically in AJAX request
                return {
                    search: params.term || '',
                    customerid: selectedCustomerId // sent to backend
                };
            },
            processResults: function(data) {
                if (data.success) {
                    return {
                        results: data.results
                    };
                } else {
                    return {
                        results: []
                    };
                }
            },
            cache: true
        },
        templateResult: function(data) {
            if (!data.id) return data.text;
            return $('<div>' + data.text + '</div>');
        },
        templateSelection: function(data) {
            return data.text || data.id;
        }
    });

    // ✅ Custom event to force reload and auto-select first address
    $('#shipping-list').on('reloadShippingList', function() {
        if (!selectedCustomerId) return;

        // Wait briefly to let AJAX complete
        setTimeout(() => {
            $.ajax({
                url: "{{ route('shipping.list') }}",
                data: {
                    customerid: selectedCustomerId
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success && data.results.length > 0) {
                        let firstAddress = data.results[0];
                        let firstOption = new Option(firstAddress.text, firstAddress
                            .id, true, true);
                        $('#shipping-list').append(firstOption).trigger('change');

                        // Display address details immediately
                        let full = firstAddress.full;
                        $('#shipping-name').text(full.ship_name);
                        $('#shipping-address').text(
                            `${full.address1}, ${full.address2}, ${full.city}, ${full.region}, ${full.zip}, ${full.country}`
                        );
                        $('#shipping-phone').text('Phone: ' + full.mobile);
                        $('#shipping-email').text('Email: ' + full.email);
                        $('#shipping-gst').text('Building no: ' + full.buildingno);
                        $('#shipping-details').removeClass('d-none');
                    }
                }
            });
        }, 400); // delay slightly after customer select
    });
    // Handle selection
    $('#shipping-list').on('select2:select', function(e) {
        var selected = e.params.data.full;

        if (selected) {
            $('#shipping-name').text(selected.ship_name);
            $('#shipping-address').text(selected.address1 + ', ' + selected.address2 + ', ' + selected
                .city + ', ' + selected.region + ', ' + selected.zip + ', ' + selected.country);
            $('#shipping-phone').text('Phone: ' + selected.mobile);
            $('#shipping-email').text('Email: ' + selected.email);
            $('#shipping-gst').text('Building no: ' + selected.buildingno);

            $('#shipping-details').removeClass('d-none');
        }
    });



});

document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('createForm');
    const submitBtn = document.getElementById('submitBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    // Form submission handler
    createForm.addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm();
    });

    // Cancel button handler
    cancelBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
            window.location.href = "{{ route('orders.create') }}";
        }
    });

    function submitForm() {
        const formData = new FormData(createForm);
        
        // Show loading state
        setLoadingState(true);

        // Make AJAX request
        $.ajax({
            url: createForm.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                setLoadingState(false);
                if (response.success) {
                    showSuccess(response.message);
                    setTimeout(() => {
                        window.location.href = response.redirect_url || '{{ route("orders") }}';
                    }, 1500);
                } else {
                    showError(response.message);
                    // Display validation errors if any
                    if (response.errors) {
                        displayValidationErrors(response.errors);
                    }
                }
            },
            error: function(xhr, status, error) {
                setLoadingState(false);
                let errorMessage = 'An error occurred while creating the order.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    errorMessage = 'Validation failed. Please check your inputs.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        displayValidationErrors(xhr.responseJSON.errors);
                    }
                }
                
                showError(errorMessage);
            }
        });
    }

    function displayValidationErrors(errors) {
        // Reset previous errors
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.textContent = '';
        });

        // Display new errors
        for (const field in errors) {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = input.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = errors[field][0];
                }
            }
        }
    }

    function setLoadingState(loading) {
        const spinner = submitBtn.querySelector('.spinner-border');
        const btnText = submitBtn.querySelector('.btn-text') || submitBtn;
        
        if (loading) {
            spinner.classList.remove('d-none');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';
        } else {
            spinner.classList.add('d-none');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Place Order';
        }
    }

   
});


document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('createForm');
    const submitBtn = document.getElementById('submitBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    // Form submission handler
    createForm.addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm();
    });

    // Cancel button handler
    cancelBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
            window.location.href = "{{ route('orders.create') }}";
        }
    });

    function submitForm() {
        const formData = new FormData(createForm);
        
        // Show loading state
        setLoadingState(true);

        // Make AJAX request
        $.ajax({
            url: createForm.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                setLoadingState(false);
                if (response.success) {
                    showSuccess(response.message);
                    setTimeout(() => {
                        window.location.href = response.redirect_url || '{{ route("orders") }}';
                    }, 1500);
                } else {
                    showError(response.message);
                    // Display validation errors if any
                    if (response.errors) {
                        displayValidationErrors(response.errors);
                    }
                }
            },
            error: function(xhr, status, error) {
                setLoadingState(false);
                let errorMessage = 'An error occurred while creating the order.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    errorMessage = 'Validation failed. Please check your inputs.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        displayValidationErrors(xhr.responseJSON.errors);
                    }
                }
                
                showError(errorMessage);
            }
        });
    }

    function displayValidationErrors(errors) {
        // Reset previous errors
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.textContent = '';
        });

        // Display new errors
        for (const field in errors) {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = input.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = errors[field][0];
                }
            }
        }
    }

    function setLoadingState(loading) {
        const spinner = submitBtn.querySelector('.spinner-border');
        const btnText = submitBtn.querySelector('.btn-text') || submitBtn;
        
        if (loading) {
            spinner.classList.remove('d-none');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';
        } else {
            spinner.classList.add('d-none');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Save';
        }
    }

     /* remove from list */
    $('.add-table').on('click', '.movecart', function() {
        console.log('test');
        $this = $(this);
        var item_id = $this.data('id');

        $.ajax({
            url: "{{ route('products.removecart') }}",
            method: "POST",
            data: {
                item_id: item_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    showSuccess(response.data.message);
                    setTimeout(() => {
                        $('#cartitem-' + item_id).remove();
                        $('.wishlist-counter').text(response.data.wishlist || '0');
                        $('.cart-counter').text(response.data.cart || '0');
                        window.location.reload();
                    }, 200);
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr, status, error) {
                showError(error);
            }
        });
    });
});
</script>
@endpush