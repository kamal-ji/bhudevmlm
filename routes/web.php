<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\EstimateController;
use App\Http\Controllers\Backend\InvoiceController;
use App\Http\Controllers\Backend\MemberController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Backend\ServiceCategoryController;
use App\Http\Controllers\Backend\ServicePackageController;
use App\Http\Controllers\Backend\MemberServiceController;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'showForgotpassword'])->name('forgot-password');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/forgotpassword', [AuthController::class, 'Forgotpassword'])->name('forgotpassword.submit');
Route::get('/getstates/{countryId}', [LocationController::class, 'getStatesByCountry'])->name('getstates');
// Protected routes using external auth
// Routes accessible by any authenticated user
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Company settings
    Route::get('/profile/company-setting', [ProfileController::class, 'Companysetting'])->name('profile.company-setting');
    Route::post('/profile/company-setting', [ProfileController::class, 'SaveCompanysetting'])->name('save.companysettings');
    Route::get('/company-settings/delete-logo', [ProfileController::class, 'deleteCompanyLogo'])->name('delete.companylogo');
    Route::get('/company-settings/delete-favicon', [ProfileController::class, 'deleteCompanyFavicon'])->name('delete.companyfavicon');
    Route::get('/profile/email-setting', [ProfileController::class, 'Emailsetting'])->name('profile.email-setting');
    
    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/view', [CustomerController::class, 'view'])->name('customers.view');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Customer addresses
    Route::get('/customers/{customer}/address_list', [CustomerController::class, 'Address_list'])->name('customers.address_list');
    Route::get('/customers/{customer}/address/create', [CustomerController::class, 'CreateAddress'])->name('customers.address.create');
    Route::post('/customers/address/store', [CustomerController::class, 'StoreAddress'])->name('customers.address.store');
    Route::get('/customers/{customer}/address/{address}/edit', [CustomerController::class, 'EditAddress'])->name('customers.address.edit');
    Route::put('/customers/{customer}/address/{address}', [CustomerController::class, 'UpdateAddress'])->name('customers.address.update');

    
    // Members Routes
Route::prefix('members')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('members.index');
    Route::get('/active', [MemberController::class, 'active'])->name('members.active');
    Route::get('/inactive', [MemberController::class, 'inactive'])->name('members.inactive');
    Route::get('/pending', [MemberController::class, 'pending'])->name('members.pending'); // New Registrations
    Route::get('/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('/', [MemberController::class, 'store'])->name('members.store');
    Route::get('/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    Route::get('/sponsor-details', [MemberController::class, 'getSponsorDetails'])
    ->name('members.sponsor.details');
    // Bulk operations
    Route::post('/bulk-approve', [MemberController::class, 'bulkApprove'])->name('members.bulk.approve');
    Route::post('/bulk-delete', [MemberController::class, 'bulkDelete'])->name('members.bulk.delete');
    Route::put('/{member}/status', [MemberController::class, 'updateStatus'])->name('members.status.update');
    Route::post('/{member}/approve', [MemberController::class, 'approve'])->name('members.approve');
    Route::post('/{member}/reject', [MemberController::class, 'reject'])->name('members.reject');
});

// --------------------------
    // Service Management Routes
    // --------------------------
    Route::prefix('services')->group(function () {

       // Service Categories
Route::prefix('categories')->name('categories.')->group(function () {
    // Commission Rates
    Route::get('/commission-rates', [ServiceCategoryController::class, 'commissionRates'])
        ->name('commission-rates');

    Route::put('/update-commission-rates', [ServiceCategoryController::class, 'updateCommissionRates'])
        ->name('update-commission-rates');

    // CRUD
    Route::get('/', [ServiceCategoryController::class, 'index'])->name('index');
    Route::get('/create', [ServiceCategoryController::class, 'create'])->name('create');
    Route::post('/', [ServiceCategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ServiceCategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ServiceCategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [ServiceCategoryController::class, 'destroy'])->name('destroy');

    // Status
    Route::post('/{id}/status', [ServiceCategoryController::class, 'updateStatus'])
        ->name('update-status');

    // ----------------------------
    // Additional Category Routes
    // ----------------------------
    
    
   
    // Performance
    Route::get('/performance', [ServiceCategoryController::class, 'performance'])
        ->name('performance');

   Route::get('/{id}/detail-performance', [ServiceCategoryController::class, 'detailPerformance'])
    ->name('detail-performance');

});


      // Member Service Assignments
Route::prefix('member-services')->name('member-services.')->group(function () {

    // CRUD
    Route::get('/', [MemberServiceController::class, 'index'])->name('index');
    Route::get('/create', [MemberServiceController::class, 'create'])->name('create');
    Route::post('/', [MemberServiceController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [MemberServiceController::class, 'edit'])->name('edit');
    Route::put('/{id}', [MemberServiceController::class, 'update'])->name('update');

    // Codes
    Route::get('/generate-codes', [MemberServiceController::class, 'generateCodes'])
        ->name('generate-codes');

    Route::post('/bulk-generate', [MemberServiceController::class, 'bulkGenerate'])
        ->name('bulk-generate');

    // ----------------------------
    // Additional Member Services Routes
    // ----------------------------

    // Commission Overrides
    Route::get('/commission-override', [MemberServiceController::class, 'commissionOverride'])
        ->name('commission-override');

    Route::put('/{id}/update-commission', [MemberServiceController::class, 'updateCommission'])
        ->name('update-commission');

    Route::put('/{id}/reset-commission', [MemberServiceController::class, 'resetCommission'])
        ->name('reset-commission');

    Route::put('/bulk-update-commission', [MemberServiceController::class, 'bulkUpdateCommission'])
        ->name('bulk-update-commission');

    // Performance
    Route::get('/performance', [MemberServiceController::class, 'performance'])
        ->name('performance');

});


       // Service Packages
Route::prefix('packages')->name('packages.')->group(function () {
  
    Route::put('/update-features', [ServicePackageController::class, 'updateFeatures'])
        ->name('update-features');
    // CRUD
    Route::get('/', [ServicePackageController::class, 'index'])->name('index');
    Route::get('/create', [ServicePackageController::class, 'create'])->name('create');
    Route::post('/', [ServicePackageController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ServicePackageController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ServicePackageController::class, 'update'])->name('update');
    Route::delete('/{id}', [ServicePackageController::class, 'destroy'])->name('destroy');

    // Filter
    Route::get('/category/{categoryId}', [ServicePackageController::class, 'byCategory'])
        ->name('by-category');

    // ----------------------------
    // Additional Package Routes
    // ----------------------------

    // Pricing
    Route::get('/pricing', [ServicePackageController::class, 'pricing'])
        ->name('pricing');

    Route::put('/{id}/update-price', [ServicePackageController::class, 'updatePrice'])
        ->name('update-price');

    // Features
    Route::get('/features', [ServicePackageController::class, 'features'])
        ->name('features');

    Route::get('/{id}/features', [ServicePackageController::class, 'getFeatures'])
        ->name('get-features');


});


    });
});

// Member routes
Route::middleware(['auth', 'role:member'])->prefix('member')->group(function () {
    //Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');
    // You can add more member-only routes here
});


// OTP Verification (Protected)
Route::middleware(['otp.requested'])->group(function () {
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify-otp');
    Route::post('/verifyotp', [AuthController::class, 'verifyOtp'])->name('verifyotp.submit');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');
});

// Reset Password (Protected)
// Reset password
Route::middleware(['otp.verified'])->group(function () {
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset.password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password.submit');
});
