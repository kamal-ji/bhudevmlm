@extends('layouts.admin')

@section('content')

<!-- Start Content -->
<div class="content">
    <!-- start row -->
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="mb-0">Order #{{ $order['order_no'] ?? 'N/A' }}</h4>
                    <div>
                        @if($order['iscancelable'])
                        <button class="btn btn-outline-danger btn-sm cancelbtn" data-orderid="{{ $id }}">Cancel Order</button>
                        @endif
                    </div>
                </div>
                
                <!-- Progress Tracker -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Order Progress</h6>
                        <div class="progress-tracker">
                            <div class="progress-steps">
                                @foreach($order['progress_step'] as $index => $step)
                                <div class="step {{ $step['isComplete'] ? 'completed' : '' }}">
                                    <div class="step-icon">
                                        @if($step['isComplete'])
                                        <i class="fas fa-check"></i>
                                        @else
                                        <span>{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                    <div class="step-label">{{ $step['name'] }}</div>
                                </div>
                                @if(!$loop->last)
                                <div class="step-connector {{ $step['isComplete'] ? 'completed' : '' }}"></div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Status & Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">Order Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="mb-1"><strong>Order No: </strong><span>{{ $order['order_no'] ?? 'N/A' }}</span></p>
                                       
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-1"><strong>Order Date: </strong> <span>{{ $order['order_date'] ?? 'N/A' }}</span></p>
                                       
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-1"><strong>Order Status: </strong> <span class="badge bg-primary">{{ $order['order_status'] ?? 'N/A' }}</span></p>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-1"><strong>Payment Method: </strong> <span>{{ $order['payment_method'] ?? 'N/A' }}</span></p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">Shipping Information</h6>
                                <div class="shipping-address">
                                    @if(!empty($order['shipping']['house']))
                                        <p class="mb-1">{{ $order['shipping']['house'] }}</p>
                                    @endif
                                    @if(!empty($order['shipping']['floor']))
                                        <p class="mb-1">{{ $order['shipping']['floor'] }}</p>
                                    @endif
                                    @if(!empty($order['shipping']['address1']))
                                        <p class="mb-1">{{ $order['shipping']['address1'] }}</p>
                                    @endif
                                    @if(!empty($order['shipping']['address2']))
                                        <p class="mb-1">{{ $order['shipping']['address2'] }}</p>
                                    @endif
                                    <p class="mb-1">
                                        {{ $order['shipping']['city'] ?? '' }}, 
                                        {{ $order['shipping']['region'] ?? '' }} 
                                        {{ $order['shipping']['zipcode'] ?? '' }}
                                    </p>
                                    <p class="mb-1">{{ $order['shipping']['country'] ?? '' }}</p>
                                    @if(!empty($order['shipping']['phone']))
                                        <p class="mb-0"><strong>Phone:</strong> {{ $order['shipping']['phone'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tracking Information -->
                @if(isset($order['track_order']) && !empty($order['track_order']['shipper_name']))
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Tracking Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                @if(!empty($order['track_order']['tracking_no']))
                                    <p class="mb-1"><strong>Tracking No:</strong> {{ $order['track_order']['tracking_no'] }}</p>
                                @endif
                                <p class="mb-1"><strong>Shipper:</strong> {{ $order['track_order']['shipper_name'] }}</p>
                                @if(!empty($order['track_order']['package_weight']))
                                    <p class="mb-1"><strong>Package Weight:</strong> {{ $order['track_order']['package_weight'] }}</p>
                                @endif
                                @if(!empty($order['track_order']['package_dimension']))
                                    <p class="mb-1"><strong>Package Dimension:</strong> {{ $order['track_order']['package_dimension'] }}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if(!empty($order['track_order']['tracking_url']))
                                <a href="{{ $order['track_order']['tracking_url'] }}" target="_blank" class="btn btn-primary">Track Package</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Order Items -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Order Items</h6>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order['items'] as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if(!empty($item['image']))
                                                <img src="{{ get('image_url'). $item['image'] }}" alt="{{ $item['name'] }}" class="img-thumbnail me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                <div class="img-thumbnail me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #f8f9fa;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item['name'] }}</h6>
                                                    <small class="text-muted">ID: {{ $item['productid'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ Str::limit($item['description'], 50) }}</td>
                                        <td>{{ $item['pcs'] }}</td>
                                        <td>{{ $item['currency'] }}{{ number_format($item['price'], 2) }}</td>
                                        <td>{{ $item['currency'] }}{{ number_format($item['price'] * $item['pcs'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="row mb-4">
                    <div class="col-md-6 offset-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">Order Summary</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Items ({{ $order['order_summary']['pcs'] ?? 0 }}):</span>
                                    <span>{{ $order['items'][0]['currency'] ?? '$' }}{{ number_format($order['order_summary']['subtotal'] ?? 0, 2) }}</span>
                                </div>
                                @if(($order['order_summary']['discount'] ?? 0) > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount:</span>
                                    <span class="text-danger">-{{ $order['items'][0]['currency'] ?? '$' }}{{ number_format($order['order_summary']['discount'] ?? 0, 2) }}</span>
                                </div>
                                @endif
                                @if(($order['order_summary']['shipping'] ?? 0) > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span>{{ $order['items'][0]['currency'] ?? '$' }}{{ number_format($order['order_summary']['shipping'] ?? 0, 2) }}</span>
                                </div>
                                @endif
                                @if(($order['order_summary']['tax'] ?? 0) > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax:</span>
                                    <span>{{ $order['items'][0]['currency'] ?? '$' }}{{ number_format($order['order_summary']['tax'] ?? 0, 2) }}</span>
                                </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between mb-0">
                                    <strong>Total:</strong>
                                    <strong>{{ $order['items'][0]['currency'] ?? '$' }}{{ number_format($order['order_summary']['total'] ?? 0, 2) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reviews & Rating -->
                @if(($order['rating'] ?? 0) > 0 || !empty($order['reviews']))
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Review & Rating</h6>
                        @if(($order['rating'] ?? 0) > 0)
                        <div class="mb-2">
                            <strong>Rating:</strong>
                            <div class="d-inline-block ms-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $order['rating'])
                                    <i class="fas fa-star text-warning"></i>
                                    @else
                                    <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ms-1">({{ $order['rating'] }}/5)</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($order['reviews']))
                        <div>
                            <strong>Review:</strong>
                            <p class="mt-1 mb-0">{{ $order['reviews'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Similar Products -->
                @if(isset($order['similar']) && count($order['similar']) > 0)
                 <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fs-16 mb-0">Similar Designs</h6>
                </div>

                <div id="relatedProductsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                        $chunks = array_chunk($order['similar'], 4); // 4 items per slide
                       
                        @endphp
                           
                        @foreach($chunks as $index => $chunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row g-3">
                                @foreach($chunk as $relatedProduct)
                                <div class="col-lg-3 col-md-6">
                                    <div class="card border shadow-none mb-md-3 h-100">
                                        <div class="wishlist-box">
                                            <a href="javascript:void(0);"
                                                data-productid="{{ $relatedProduct['productid'] }}"
                                                data-wishlist="{{ $relatedProduct['wishlist'] }}"
                                                data-barcodeid="{{ $relatedProduct['barcodeid'] }}"
                                                class="btn btn-sm btn-soft-danger border-0 d-inline-flex align-items-center fs-12 fw-regular applywishlist">
                                                <i
                                                    class="{{ $relatedProduct['wishlist'] ? 'fa fa-heart' : 'fa-regular fa-heart' }}"></i>
                                            </a>
                                        </div>
                                        <img src="{{ ($relatedProduct['image'] ? get('image_url') . $relatedProduct['image'] : asset('assets/backend/img/users/user-08.jpg')) }}"
                                            class="card-img-top" alt="{{ $relatedProduct['name'] }}">

                                        <div class="card-body">
                                            <h5 class="card-title">{{ $relatedProduct['name'] }}</h5>

                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <span class="fs-14 fw-semibold">
                                                    {{ $relatedProduct['currency'] }}{{ number_format($relatedProduct['price'], 2) }}
                                                </span>

                                                @if($relatedProduct['cart'])
                                                <a href="javascript:void(0);"
                                                    data-productid="{{ $relatedProduct['productid'] }}"
                                                    data-cart="{{ $relatedProduct['cart'] }}"
                                                    data-barcodeid="{{ $relatedProduct['barcodeid'] }}"
                                                    class="btn btn-sm btn-soft-success border-0 d-inline-flex align-items-center me-1 fs-12 fw-regular applycart">
                                                    <span class="">Remove from Cart</span>
                                                </a>
                                                @else
                                                <a href="javascript:void(0);"
                                                    data-productid="{{ $relatedProduct['productid'] }}"
                                                    data-cart="{{ $relatedProduct['cart'] }}"
                                                    data-barcodeid="{{ $relatedProduct['barcodeid'] }}"
                                                    class="btn btn-sm btn-soft-primary border-0 d-inline-flex align-items-center me-1 fs-12 fw-regular applycart">
                                                    <span class="">Add to Cart</span>
                                                </a>
                                                @endif
                                            </div>
                                        </div><!-- end card body -->
                                    </div>
                                </div><!-- end col -->
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Carousel Controls -->
                    @if(count($chunks) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#relatedProductsCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#relatedProductsCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif
                </div>
            </div>
                @endif
                
            </div>
        </div><!-- end col -->
    </div>
    <!-- end row -->
</div>
<!-- End Content -->

@endsection

@push('styles')
<style>
    /* Progress Tracker Styles */
    .progress-tracker {
        padding: 20px 0;
    }
    
    .progress-steps {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }
    
    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
        color: #6c757d;
        font-weight: bold;
        margin-bottom: 8px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .step.completed .step-icon {
        background-color: #198754;
        color: white;
        border-color: #198754;
    }
    
    .step-label {
        font-size: 0.875rem;
        text-align: center;
        color: #6c757d;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .step.completed .step-label {
        color: #198754;
        font-weight: 600;
    }
    
    .step-connector {
        flex: 1;
        height: 4px;
        background-color: #e9ecef;
        margin: 0 10px;
        position: relative;
        top: -18px;
        z-index: 1;
        transition: all 0.3s ease;
    }
    
    .step-connector.completed {
        background-color: #198754;
    }
    
    /* Product Card Styles */
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .progress-steps {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .step {
            flex-direction: row;
            margin-bottom: 15px;
            width: 100%;
        }
        
        .step-icon {
            margin-bottom: 0;
            margin-right: 15px;
        }
        
        .step-connector {
            width: 4px;
            height: 30px;
            margin: 5px 18px;
        }
        
        .shipping-address p {
            margin-bottom: 0.25rem;
        }
    }
    
    @media (max-width: 576px) {
        .d-flex.justify-content-between.mb-3 {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .d-flex.justify-content-between.mb-3 > div:last-child {
            margin-top: 10px;
        }
    }
    
#relatedProductsCarousel .carousel-item {
    padding: 10px 0;
}

#relatedProductsCarousel .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

#relatedProductsCarousel .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.wishlist-box {
    position: absolute;
    top: 5px;
    right: 5px;
}

.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    opacity: 0.8;

    border-radius: 50%;
}

.carousel-control-prev {
    left: -20px;
}

.carousel-control-next {
    right: -20px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1);
}

@media (max-width: 768px) {

    .carousel-control-prev,
    .carousel-control-next {
        display: none;
    }

    #relatedProductsCarousel .carousel-item .row {
        margin: 0 -5px;
    }

    #relatedProductsCarousel .carousel-item .col-lg-3 {
        padding: 0 5px;
    }
}

/* Ensure cards have consistent height */
#relatedProductsCarousel .card-body {
    display: flex;
    flex-direction: column;
    height: 100%;
}

#relatedProductsCarousel .card-title {
    flex-grow: 1;
}

</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any interactive functionality here
        console.log('Order details page loaded');
        
        // Example: Cancel order button confirmation
        const cancelBtn = document.querySelector('.cancelbtn');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to cancel this order?')) {
                    e.preventDefault();
                }

              
                var orderId = $(this).data('orderid');
                $.ajax({
                    url: '{{ route('orders.cancel') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        orderid: orderId
                    },
                    success: function(response) {
                        if (response.success) {
                           showSuccess(response.message);
                            setTimeout(() => {
                                window.location.href = response.redirect_url || '{{ route("orders") }}';
                            }, 1500);
                            //window.location.reload();
                        } else {
                           showError(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                      
                        showError('An error occurred while canceling the order.');
                    }
            });
        });

    }
       
    });
</script>
@endpush