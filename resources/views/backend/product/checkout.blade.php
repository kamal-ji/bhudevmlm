@extends('layouts.admin')

@section('content')  
    <style>
           :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --light-bg: #f8f9fc;
            --border-color: #e3e6f0;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .checkout-header {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 25px;
        }
        
        .checkout-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 25px;
        }
        
        .checkout-card h5 {
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .cart-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-item-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .cart-item-price {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .cart-item-quantity {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .summary-total {
            font-weight: 700;
            font-size: 1.2rem;
            border-top: 1px solid var(--border-color);
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .shipping-option, .customer-option {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .shipping-option:hover, .customer-option:hover {
            border-color: var(--primary-color);
            background-color: rgba(78, 115, 223, 0.05);
        }
        
        .shipping-option.selected, .customer-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(78, 115, 223, 0.1);
        }
        
        .shipping-option input, .customer-option input {
            margin-right: 10px;
        }
        
        .shipping-details, .customer-details {
            margin-top: 10px;
            font-size: 0.9rem;
            color: var(--secondary-color);
        }
        
        .btn-checkout {
            background-color: var(--primary-color);
            border: none;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
        }
        
        .btn-checkout:hover {
            background-color: #3a5ccc;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #5a5c69;
        }
        
        .add-new-btn {
            color: var(--primary-color);
            font-size: 0.9rem;
            cursor: pointer;
            margin-top: 10px;
            display: inline-block;
        }
        
        .new-address-form, .new-customer-form {
            display: none;
            margin-top: 15px;
            padding: 15px;
            border: 1px dashed var(--border-color);
            border-radius: 8px;
        }
        
        @media (max-width: 768px) {
            .checkout-card {
                padding: 15px;
            }
            
            .cart-item {
                flex-direction: column;
            }
            
            .cart-item-image {
                margin-bottom: 10px;
            }
        }
    </style>
  <div class="container checkout-container my-4">
        <!-- Checkout Header -->
        <div class="checkout-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">🛒 Checkout</h4>
                <div>
                    <span class="text-muted">Cart</span> > 
                    <span class="fw-bold text-primary">Information</span> > 
                    <span class="text-muted">Shipping</span> > 
                    <span class="text-muted">Payment</span>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- LEFT COLUMN - Cart Items and Customer/Shipping Selection -->
            <div class="col-lg-8">
                <!-- Cart Items -->
                <div class="checkout-card">
                    <h5>Your Cart</h5>
                    <div id="cart-items-container">
                        <!-- Cart items will be dynamically populated here -->
                    </div>
                </div>

                <!-- Customer Selection -->
                <div class="checkout-card">
                    <h5>Select Customer</h5>
                    <div id="customer-list">
                        <!-- Customer options will be dynamically populated here -->
                    </div>
                    <div class="add-new-btn" id="add-customer-btn">
                        <i class="fas fa-plus"></i> Add New Customer
                    </div>
                    
                    <div class="new-customer-form" id="new-customer-form">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="customer-first-name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="customer-last-name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="customer-email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="customer-phone">
                        </div>
                        <button class="btn btn-sm btn-primary" id="save-customer-btn">Save Customer</button>
                    </div>
                </div>

                <!-- Shipping Selection -->
                <div class="checkout-card">
                    <h5>Shipping Method</h5>
                    <div id="shipping-list">
                        <!-- Shipping options will be dynamically populated here -->
                    </div>
                    <div class="add-new-btn" id="add-address-btn">
                        <i class="fas fa-plus"></i> Add New Shipping Address
                    </div>
                    
                    <div class="new-address-form" id="new-address-form">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="address-name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" id="address-line1" placeholder="Street address">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="address-line2" placeholder="Apt, suite, unit (optional)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="address-city" placeholder="City">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="address-state" placeholder="State/Province">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="address-zip" placeholder="ZIP/Postal code">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="address-country" placeholder="Country">
                        </div>
                        <button class="btn btn-sm btn-primary" id="save-address-btn">Save Address</button>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN - Order Summary -->
            <div class="col-lg-4">
                <div class="checkout-card position-sticky" style="top: 20px;">
                    <h5>Order Summary</h5>
                    <div id="order-summary">
                        <!-- Order summary will be dynamically populated here -->
                    </div>
                    <button class="btn btn-checkout" id="place-order-btn">Place Order</button>
                </div>
            </div>
        </div>
    </div>

    @endsection
@push('scripts')
 <script>
        // Sample data - in a real application, this would come from your backend
        const cartData = {
            items: [
                {
                    id: 1,
                    productid: 101,
                    barcodeid: "BC001",
                    name: "Wireless Bluetooth Headphones",
                    description: "Noise cancelling over-ear headphones",
                    price: 89.99,
                    tagprice: 119.99,
                    currency: "$",
                    pcs: 1,
                    image: "/images/headphones.jpg"
                },
                {
                    id: 2,
                    productid: 102,
                    barcodeid: "BC002",
                    name: "Smart Fitness Watch",
                    description: "Waterproof fitness tracker with heart rate monitor",
                    price: 149.99,
                    tagprice: 199.99,
                    currency: "$",
                    pcs: 1,
                    image: "/images/smartwatch.jpg"
                }
            ],
            summary: {
                currency: "$",
                subtotal: 239.98,
                discount: 80.00,
                shipping: 9.99,
                tax: 19.20,
                total: 189.17
            }
        };

        const shippingOptions = [
            {
                id: 1,
                name: "Standard Shipping",
                description: "5-7 business days",
                price: 9.99,
                estimatedDays: "5-7"
            },
            {
                id: 2,
                name: "Express Shipping",
                description: "2-3 business days",
                price: 19.99,
                estimatedDays: "2-3"
            },
            {
                id: 3,
                name: "Overnight Shipping",
                description: "Next business day",
                price: 29.99,
                estimatedDays: "1"
            }
        ];

        const customerOptions = [
            {
                id: 1,
                name: "John Smith",
                email: "john.smith@example.com",
                phone: "+1 (555) 123-4567",
                address: "123 Main St, Apt 4B, New York, NY 10001"
            },
            {
                id: 2,
                name: "Sarah Johnson",
                email: "sarah.j@example.com",
                phone: "+1 (555) 987-6543",
                address: "456 Oak Avenue, Los Angeles, CA 90001"
            }
        ];

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderCartItems();
            renderOrderSummary();
            renderShippingOptions();
            renderCustomerOptions();
            setupEventListeners();
        });

        // Render cart items
        function renderCartItems() {
            const container = document.getElementById('cart-items-container');
            container.innerHTML = '';
            
            cartData.items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'cart-item';
                itemElement.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                    <div class="cart-item-details">
                        <div class="cart-item-title">${item.name}</div>
                        <div class="cart-item-desc text-muted small">${item.description}</div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="cart-item-price">${item.currency} ${item.price.toFixed(2)}</div>
                            <div class="cart-item-quantity">Qty: ${item.pcs}</div>
                        </div>
                    </div>
                `;
                container.appendChild(itemElement);
            });
        }

        // Render order summary
        function renderOrderSummary() {
            const container = document.getElementById('order-summary');
            const summary = cartData.summary;
            
            container.innerHTML = `
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>${summary.currency} ${summary.subtotal.toFixed(2)}</span>
                </div>
                <div class="summary-row">
                    <span>Discount:</span>
                    <span>- ${summary.currency} ${summary.discount.toFixed(2)}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span>${summary.currency} ${summary.shipping.toFixed(2)}</span>
                </div>
                <div class="summary-row">
                    <span>Tax:</span>
                    <span>${summary.currency} ${summary.tax.toFixed(2)}</span>
                </div>
                <hr>
                <div class="summary-row summary-total">
                    <span>Total:</span>
                    <span>${summary.currency} ${summary.total.toFixed(2)}</span>
                </div>
            `;
        }

        // Render shipping options
        function renderShippingOptions() {
            const container = document.getElementById('shipping-list');
            container.innerHTML = '';
            
            shippingOptions.forEach((option, index) => {
                const optionElement = document.createElement('div');
                optionElement.className = 'shipping-option';
                if (index === 0) optionElement.classList.add('selected');
                
                optionElement.innerHTML = `
                    <div class="d-flex align-items-start">
                        <input type="radio" name="shipping" ${index === 0 ? 'checked' : ''} 
                               data-id="${option.id}" data-price="${option.price}">
                        <div>
                            <div class="fw-bold">${option.name}</div>
                            <div class="shipping-details">
                                ${option.description} • ${option.currency || '$'} ${option.price.toFixed(2)}
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(optionElement);
            });
        }

        // Render customer options
        function renderCustomerOptions() {
            const container = document.getElementById('customer-list');
            container.innerHTML = '';
            
            customerOptions.forEach((customer, index) => {
                const optionElement = document.createElement('div');
                optionElement.className = 'customer-option';
                if (index === 0) optionElement.classList.add('selected');
                
                optionElement.innerHTML = `
                    <div class="d-flex align-items-start">
                        <input type="radio" name="customer" ${index === 0 ? 'checked' : ''} 
                               data-id="${customer.id}">
                        <div>
                            <div class="fw-bold">${customer.name}</div>
                            <div class="customer-details">
                                ${customer.email} • ${customer.phone}<br>
                                ${customer.address}
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(optionElement);
            });
        }

        // Setup event listeners
        function setupEventListeners() {
            // Shipping option selection
            document.querySelectorAll('.shipping-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.shipping-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    this.classList.add('selected');
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                    
                    // Update shipping cost in summary
                    const shippingPrice = parseFloat(radio.getAttribute('data-price'));
                    updateShippingCost(shippingPrice);
                });
            });

            // Customer option selection
            document.querySelectorAll('.customer-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.customer-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    this.classList.add('selected');
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                });
            });

            // Add new address button
            document.getElementById('add-address-btn').addEventListener('click', function() {
                const form = document.getElementById('new-address-form');
                form.style.display = form.style.display === 'block' ? 'none' : 'block';
            });

            // Add new customer button
            document.getElementById('add-customer-btn').addEventListener('click', function() {
                const form = document.getElementById('new-customer-form');
                form.style.display = form.style.display === 'block' ? 'none' : 'block';
            });

            // Save address button
            document.getElementById('save-address-btn').addEventListener('click', function() {
                // In a real app, you would save the address to your backend
                alert('New address saved!');
                document.getElementById('new-address-form').style.display = 'none';
            });

            // Save customer button
            document.getElementById('save-customer-btn').addEventListener('click', function() {
                // In a real app, you would save the customer to your backend
                alert('New customer saved!');
                document.getElementById('new-customer-form').style.display = 'none';
            });

            // Place order button
            document.getElementById('place-order-btn').addEventListener('click', function() {
                const selectedShipping = document.querySelector('input[name="shipping"]:checked');
                const selectedCustomer = document.querySelector('input[name="customer"]:checked');
                
                if (!selectedShipping || !selectedCustomer) {
                    alert('Please select both shipping method and customer before placing order.');
                    return;
                }
                
                // In a real app, you would submit the order to your backend
                alert('Order placed successfully!');
            });
        }

        // Update shipping cost in the order summary
        function updateShippingCost(newShippingCost) {
            // In a real app, you would recalculate the order total with the new shipping cost
            // For this example, we'll just update the display
            const summary = cartData.summary;
            const shippingElement = document.querySelector('.summary-row:nth-child(3) span:last-child');
            shippingElement.textContent = `${summary.currency} ${newShippingCost.toFixed(2)}`;
            
            // Update total (this is simplified - in reality you'd recalculate tax too)
            const newTotal = summary.subtotal - summary.discount + newShippingCost + summary.tax;
            const totalElement = document.querySelector('.summary-total span:last-child');
            totalElement.textContent = `${summary.currency} ${newTotal.toFixed(2)}`;
        }
    </script>
    @endpush