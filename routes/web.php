<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\EstimateController;
use App\Http\Controllers\Backend\InvoiceController;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'showForgotpassword'])->name('forgot-password');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/forgotpassword', [AuthController::class, 'Forgotpassword'])->name('forgotpassword.submit');

// Protected routes using external auth
Route::middleware(['external.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/company-setting', [ProfileController::class, 'Companysetting'])->name('profile.company-setting');
    Route::post('/profile/company-setting', [ProfileController::class, 'SaveCompanysetting'])->name('save.companysettings');
    Route::get('/profile/email-setting', [ProfileController::class, 'Emailsetting'])->name('profile.email-setting');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/view', [CustomerController::class, 'view'])->name('customers.view');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
     Route::get('/customers/{customer}/address_list', [CustomerController::class, 'Address_list'])->name('customers.address_list');
     Route::get('/customers/{customer}/address/create', [CustomerController::class, 'CreateAddress'])->name('customers.address.create');
     Route::post('/customers/address/store', [CustomerController::class, 'StoreAddress'])->name('customers.address.store');
      Route::get('/customers/{customer}/address/{address}/edit', [CustomerController::class, 'EditAddress'])->name('customers.address.edit');
      Route::put('/customers/{customer}/address/{address}', [CustomerController::class, 'UpdateAddress'])->name('customers.address.update');
     Route::get('/products', [ProductController::class, 'index'])->name('products');
    
    Route::get('/products/{product}/view', [ProductController::class, 'view'])->name('products.view');
   


    Route::post('/products/addtocart', [ProductController::class, 'addtocart'])->name('products.addtocart');
      Route::post('/products/update-cart-quantity', [ProductController::class, 'updatecart'])->name('products.update-cart-quantity');
      Route::post('/products/removecart', [ProductController::class, 'removecart'])->name('products.removecart');
    Route::post('/products/addtowishlist', [ProductController::class, 'addtowishlist'])->name('products.addtowishlist');
    Route::post('/products/movewishlist', [ProductController::class, 'movewishlist'])->name('products.movewishlist');
    Route::get('/getstates/{countryId}', [CustomerController::class, 'getStatesByCountry'])->name('getstates');

     Route::get('/cartlist', [ProductController::class, 'cartlist'])->name('cartlist');
     Route::get('/wishlist', [ProductController::class, 'wishlist'])->name('products.wishlist');
    Route::post('/products/movecart', [ProductController::class, 'movecart'])->name('products.movecart');
   
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/shippinglist', [OrderController::class, 'getShippingList'])->name('shipping.list');
    Route::get('/orders/customerlist', [OrderController::class, 'getCustomerList'])->name('customer.list');
    
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/view', [OrderController::class, 'view'])->name('orders.view');
    Route::post('/orders/cancel', [OrderController::class, 'CancelOrder'])->name('orders.cancel');
    Route::get('/estimate', [EstimateController::class, 'index'])->name('estimate.list');
    Route::get('/estimate/{order}/view', [EstimateController::class, 'view'])->name('estimate.view');
    Route::post('/estimate/convert', [EstimateController::class, 'ConvertOrder'])->name('estimate.convert');
    Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
    // ... other admin routes
});

// OTP Verification (Protected)
Route::middleware(['otp.requested'])->group(function () {
    Route::get('/verify-otp', [AuthController::class, 'showVerfiyotp'])->name('verify-otp');
    Route::post('/verifyotp', [AuthController::class, 'verifyOtp'])->name('verifyotp.submit');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');
});

// Reset Password (Protected)
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset.password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password.submit');
