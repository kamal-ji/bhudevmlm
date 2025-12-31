@extends('layouts.admin')

@section('content')
@php
$homeClient = getHomeClient();
$currency =$homeClient['data']['currency'] ?? '';
@endphp
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

.cart-controls {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 6px;
    overflow: hidden;
}

.qty-btn {
    border: none;
    background: #f8f9fa;
    padding: 0.4rem 0.7rem;
    font-size: 1.2rem;
    cursor: pointer;
}

.qty-btn:hover {
    background: #e2e6ea;
}

.qty-input {
    width: 40px;
    text-align: center;
    border: none;
    outline: none;
}

.cart-actions {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.remove-btn {
    background: none;
    border: none;
    color: #dc3545;
    font-weight: 500;
    cursor: pointer;
}

.remove-btn:hover {
    text-decoration: underline;
}

.wishlist-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
}

.wishlist-btn:hover svg {
    stroke: #dc3545;
}

/* Summary Section */
.cart-summary {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1rem;
    background: #fafafa;
}

.cart-summary h4 {
    margin-bottom: 1rem;
}

.summary-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.95rem;
}

.summary-row.total strong {
    font-size: 1.1rem;
}
.cart-list {
  margin-right: 1rem;
}

.cart-summary {
 
  margin-left: auto;
  background: #fff;
  padding: 1.5rem;
  border: 1px solid #ddd;
  border-radius: 8px;
}

.cart-summary h4 {
  margin-bottom: 1rem;
  font-weight: 600;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.4rem;
  font-size: 0.95rem;
}

.summary-row.total strong {
  font-size: 1.1rem;
}

.checkout-btn {
  width: 100%;
  font-weight: 600;
  font-size: 0.95rem;
}
</style>
<!-- Start Container  -->
<div class="content content-two">

    <!-- Page Header -->
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>🛒 Your Cart</h6>
        </div>

    </div>
    <!-- End Page Header -->

   <div class="container my-4">
    @if(!empty($lists['items']) && count($lists['items']) > 0)
    <div class="row">
        <!-- LEFT SIDE — CART ITEMS -->
        <div class="col-lg-8 col-md-7">
            <div class="cart-list">
                @foreach($lists['items'] as $item)
                <div class="cart-card" id="cartitem-{{ $item['id'] }}">
                    <img src="{{ get('image_url') . $item['image'] ?? asset('images/no-image.png') }}" 
                        alt="{{ $item['name'] }}" class="cart-image">

                    <div class="cart-details">
                        <h5 class="cart-title">{{ $item['name'] }}</h5>
                        <p class="cart-desc">{{ $item['description'] ?? 'No description available' }}</p>

                        <div class="cart-prices">
                            <span class="price">{{ $item['currency'] }} {{ number_format($item['price'], 2) }}</span>
                            @if($item['tagprice'] > $item['price'])
                            <span class="regular-price">{{ $item['currency'] }} {{ number_format($item['tagprice'], 2) }}</span>
                            @endif
                        </div>

                        <div class="cart-controls">
                            <div class="quantity-control">
                                <button class="qty-btn minus" data-id="{{ $item['id'] }}">−</button>
                                <input type="text" value="{{ $item['pcs'] }}" data-id="{{ $item['id'] }}" class="qty-input" readonly>
                                <button class="qty-btn plus" data-id="{{ $item['id'] }}">+</button>
                            </div>

                            <div class="cart-actions">
                                <a href="javascript:void(0);" data-productid="{{ $item['productid'] }}" data-id="{{ $item['id'] }}" data-barcodeid="{{ $item['barcodeid'] }}" class="btn btn-sm btn-soft-danger border-0 d-inline-flex align-items-center fs-12 fw-regular movecart">Remove</a>

                                <a href="javascript:void(0);" data-productid="{{ $item['productid'] }}" data-id="{{ $item['id'] }}" data-barcodeid="{{ $item['barcodeid'] }}" class="btn btn-sm btn-soft-danger border-0 d-inline-flex align-items-center fs-12 fw-regular movewishlist">
                                    <i class="fa-regular fa-heart"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- RIGHT SIDE — ORDER SUMMARY -->
        <div class="col-lg-4 col-md-5">
            <div class="cart-summary  shadow-sm bg-white rounded position-sticky" style="top: 100px;">
                <h4>Order Summary</h4>
                <div class="summary-details">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>{{ $currency ?? '' }} {{ number_format($lists['summary']['subtotal'], 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Discount:</span>
                        <span>- {{ $currency ?? '' }} {{ number_format($lists['summary']['discount'], 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>{{ $currency ?? '' }} {{ number_format($lists['summary']['shipping'], 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax:</span>
                        <span>{{ $currency ?? '' }} {{ number_format($lists['summary']['tax'], 2) }}</span>
                    </div>
                    <hr>
                    <div class="summary-row total">
                        <strong>Total:</strong>
                        <strong>{{ $currency ?? '' }} {{ number_format($lists['summary']['total'], 2) }}</strong>
                    </div>
                    <div class="text-end mt-3">
                       
                        <a class="checkout-btn btn btn-primary w-100" href="{{route('orders.create')}}">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
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
</div>

<!-- container  -->



@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Loop through each cart card
    document.querySelectorAll('.cart-card').forEach(function(cartCard) {
        const quantityInput = cartCard.querySelector('.qty-input');
        const minusBtn = cartCard.querySelector('.minus');
        const plusBtn = cartCard.querySelector('.plus');

        if (!quantityInput || !minusBtn || !plusBtn) return;

        // Plus button click
        plusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            const maxValue = parseInt(quantityInput.max) || 999;

            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
                triggerQuantityChange(cartCard, quantityInput.value);
            }
        });

        // Minus button click
        minusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            const minValue = parseInt(quantityInput.min) || 1;

            if (currentValue > minValue) {
                quantityInput.value = currentValue - 1;
                triggerQuantityChange(cartCard, quantityInput.value);
            }
        });

        // Direct input change
        quantityInput.addEventListener('change', function() {
            let currentValue = parseInt(this.value);
            const minValue = parseInt(this.min) || 1;
            const maxValue = parseInt(this.max) || 999;

            if (isNaN(currentValue) || currentValue < minValue) {
                this.value = minValue;
            } else if (currentValue > maxValue) {
                this.value = maxValue;
            }

            triggerQuantityChange(cartCard, this.value);
        });

        // Real-time input validation
        quantityInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            const minValue = parseInt(this.min) || 1;
            if (this.value && parseInt(this.value) < minValue) {
                this.value = minValue;
            }
        });

        // Keyboard arrow support
        quantityInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                plusBtn.click();
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                minusBtn.click();
            }
        });
    });

    // Called whenever quantity changes
    function triggerQuantityChange(cartCard, newQuantity) {
        const itemId = cartCard.querySelector('.qty-input').dataset.id || 'N/A';
        console.log(`Quantity for item ${itemId} changed to:`, newQuantity);

        //  Example: You can add your AJAX request here

        fetch('products/update-cart-quantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: newQuantity
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log('Cart updated:', data);
                showSuccess(data.data.message);

                setTimeout(() => {
                    window.location.reload();
                }, 200);
            })
            .catch(error => {
                console.error('Error updating cart:', error);
                showError('Failed to update cart. Please try again.');
            });

    }

    $('.cart-card').on('click', '.movewishlist', function() {
        console.log('test');
        $this = $(this);
        var item_id = $this.data('id');

        $.ajax({
            url: "{{ route('products.movewishlist') }}",
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

    /* remove from list */
    $('.cart-card').on('click', '.movecart', function() {
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