 @extends('layouts.admin')

 @section('content')
     <div class="content">

         <!-- start row -->
         <div class="row justify-content-center">

             <div class="col-xl-12">

                 <!-- start row -->
                 <div class="row settings-wrapper d-flex">

                     <!-- Start settings sidebar -->

                     <div class="col-xl-3 col-lg-4">
                         <div class="card settings-card">
                             <div class="card-header">
                                 <h6 class="mb-0">Settings</h6>
                             </div>
                             <div class="card-body">
                                 <div class="sidebars settings-sidebar">
                                     <div class="sidebar-inner">
                                         <div class="sidebar-menu p-0">
                                             <ul>
                                                 <li class="submenu-open">
                                                     <ul>
                                                         <li class="submenu">
                                                             <a href="javascript:void(0);">
                                                                 <i class="isax isax-setting-2 fs-18"></i>
                                                                 <span class="fs-14 fw-medium ms-2">General Settings</span>
                                                                 <span
                                                                     class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                             </a>
                                                             <ul>
                                                                 <li><a href="{{ route('profile') }}">Account Settings</a>
                                                                 </li>

                                                             </ul>
                                                         </li>
                                                         <li class="submenu">
                                                             <a href="javascript:void(0);" class="active subdrop">
                                                                 <i class="isax isax-global fs-18"></i>
                                                                 <span class="fs-14 fw-medium ms-2">Website Settings</span>
                                                                 <span
                                                                     class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                             </a>
                                                             <ul>
                                                                 <li><a href="{{ route('profile.company-setting') }}"
                                                                         class="active">Company Settings</a></li>

                                                             </ul>
                                                         </li>

                                                         <li class="submenu">
                                                             <a href="javascript:void(0);">
                                                                 <i class="isax isax-more-2 fs-18"></i>
                                                                 <span class="fs-14 fw-medium ms-2">Email Settings</span>
                                                                 <span
                                                                     class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                             </a>
                                                             <ul>
                                                                 <li><a href="{{ route('profile.email-setting') }}">Email
                                                                         Settings</a></li>

                                                             </ul>
                                                         </li>

                                                     </ul>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div>
                                 </div>
                             </div><!-- end card body -->
                         </div><!-- end card -->
                     </div><!-- end col -->

                     <!-- End settings sidebar -->

                     <div class="col-xl-9 col-lg-8">
                         <div class="mb-3 pb-3 border-bottom">
                             <h6 class="fw-bold mb-0">Company Settings</h6>
                         </div>
                         @if (session('success'))
                             <div class="alert alert-success text-bg-success alert-dismissible" role="alert">
                                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                     aria-label="Close"></button>
                                 <strong>Success - </strong> {{ session('success') }}

                             </div>
                         @endif
<form action="{{ route('save.companysettings') }}" class="needs-validation" method="POST" id="companysettingform" enctype="multipart/form-data">
    @csrf
    
    <!-- Logo & Branding Section -->
    <div class="border-bottom mb-4">
        <div class="card-title-head">
            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
                <span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center">
                    <i class="isax isax-image"></i>
                </span>
                Company Logo & Branding
            </h6>
        </div>

        <div class="row">
            <!-- Logo Upload -->
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="company_logo">
                        Company Logo <span class="text-danger">*</span>
                    </label>
                    <input type="file" class="form-control" id="company_logo" name="company_logo" accept="image/*">
                    <div class="form-text">Recommended size: 200x60px, Max: 2MB (JPEG, PNG, GIF, SVG, WebP)</div>
                    @error('company_logo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Logo Preview -->
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">Current Logo</label>
                    <div class="border rounded p-3 text-center">
                        @if($companyLogo)
                            <img src="{{ asset('storage/' . $companyLogo) }}" alt="Company Logo" class="img-fluid" style="max-height: 60px;">
                            <div class="mt-2">
                                <a href="{{ route('delete.companylogo') }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete the logo?')">
                                    <i class="isax isax-trash"></i> Remove Logo
                                </a>
                            </div>
                        @else
                            <div class="text-muted py-4">
                                <i class="isax isax-gallery-remove fs-24 text-muted"></i><br>
                                No logo uploaded
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Favicon Upload -->
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="company_favicon">
                        Favicon
                    </label>
                    <input type="file" class="form-control" id="company_favicon" name="company_favicon" accept=".ico,image/png">
                    <div class="form-text">Recommended: 32x32px .ico or .png file, Max: 1MB</div>
                    @error('company_favicon')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">Current Favicon</label>
                    <div class="border rounded p-3 text-center">
                        @if($companyFavicon)
                            <img src="{{ asset('storage/' . $companyFavicon) }}" alt="Favicon" class="img-fluid" style="max-height: 32px;">
                            <div class="mt-2">
                                <a href="{{ route('delete.companyfavicon') }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete the favicon?')">
                                    <i class="isax isax-trash"></i> Remove Favicon
                                </a>
                            </div>
                        @else
                            <div class="text-muted py-4">
                                <i class="isax isax-image-2 fs-24 text-muted"></i><br>
                                No favicon uploaded
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Information Section -->
    <div class="border-bottom mb-4">
        <div class="card-title-head">
            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
                <span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center">
                    <i class="isax isax-building"></i>
                </span>
                Company Information
            </h6>
        </div>

        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="company_name">
                        Company Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="company_name" name="company_name" 
                           value="{{ old('company_name', $companyName ?? '') }}" required>
                    @error('company_name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="company_email">
                        Company Email <span class="text-danger">*</span>
                    </label>
                    <input type="email" class="form-control" id="company_email" name="company_email" 
                           value="{{ old('company_email', $companyEmail ?? '') }}" required>
                    @error('company_email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="company_phone">
                        Phone Number
                    </label>
                    <input type="text" class="form-control" id="company_phone" name="company_phone" 
                           value="{{ old('company_phone', $companyPhone ?? '') }}">
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="company_website">
                        Website
                    </label>
                    <input type="url" class="form-control" id="company_website" name="company_website" 
                           value="{{ old('company_website', $companyWebsite ?? '') }}" placeholder="https://">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="company_tax_id">
                        Tax ID / VAT Number
                    </label>
                    <input type="text" class="form-control" id="company_tax_id" name="company_tax_id" 
                           value="{{ old('company_tax_id', $companyTaxId ?? '') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Address Section -->
    <div class="border-bottom mb-4">
        <div class="card-title-head">
            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
                <span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center">
                    <i class="isax isax-location"></i>
                </span>
                Company Address
            </h6>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label" for="company_address">
                        Street Address
                    </label>
                    <textarea class="form-control" id="company_address" name="company_address" 
                              rows="2">{{ old('company_address', $companyAddress ?? '') }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="company_city">
                        City
                    </label>
                    <input type="text" class="form-control" id="company_city" name="company_city" 
                           value="{{ old('company_city', $companyCity ?? '') }}">
                </div>
            </div>
            
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="company_state">
                        State/Province
                    </label>
                    <input type="text" class="form-control" id="company_state" name="company_state" 
                           value="{{ old('company_state', $companyState ?? '') }}">
                </div>
            </div>
            
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="company_zip">
                        ZIP/Postal Code
                    </label>
                    <input type="text" class="form-control" id="company_zip" name="company_zip" 
                           value="{{ old('company_zip', $companyZip ?? '') }}">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label" for="company_country">
                        Country
                    </label>
                    <input type="text" class="form-control" id="company_country" name="company_country" 
                           value="{{ old('company_country', $companyCountry ?? '') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Settings Section -->
    @if($details->count() > 0)
    <div class="border-bottom mb-4">
        <div class="card-title-head">
            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
                <span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center">
                    <i class="isax isax-setting-2"></i>
                </span>
                Additional Settings
            </h6>
        </div>

        <div class="row">
            @foreach ($details as $setting)
                @if(!in_array($setting->name, [
                    'company_logo', 'company_favicon', 'company_name', 'company_email', 
                    'company_phone', 'company_website', 'company_address', 'company_city',
                    'company_state', 'company_country', 'company_zip', 'company_tax_id'
                ]))
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="setting_{{ $setting->id }}">
                            {{ ucwords(str_replace('_', ' ', $setting->name)) }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="setting_{{ $setting->id }}"
                               name="settings[{{ $setting->id }}][value]"
                               value="{{ old('settings.' . $setting->id . '.value', $setting->value) }}"
                               placeholder="Enter {{ ucwords(str_replace('_', ' ', $setting->name)) }}">
                        @error('settings.' . $setting->id . '.value')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <!-- Form Buttons -->
    <div class="d-flex align-items-center justify-content-between settings-bottom-btn mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">
            <i class="isax isax-arrow-left"></i> Cancel
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="isax isax-save-2"></i> Save Changes
        </button>
    </div>
</form>
                     </div><!-- end col -->
                     <!-- end col -->
                 </div>
                 <!-- end row -->

             </div><!-- end col -->
         </div>
         <!-- end row -->

     </div>
 @endsection
 @push('scripts')
 <script>
 // Add this to your script file or in a script tag
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('companysettingform');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }
    
    // Image preview for logo
    const logoInput = document.getElementById('company_logo');
    if (logoInput) {
        logoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }
            }
        });
    }
    
    // Image preview for favicon
    const faviconInput = document.getElementById('company_favicon');
    if (faviconInput) {
        faviconInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size
                if (file.size > 1024 * 1024) {
                    alert('File size must be less than 1MB');
                    this.value = '';
                    return;
                }
                
                // Validate file extension
                const validExtensions = ['.ico', '.png'];
                const fileName = file.name.toLowerCase();
                const isValid = validExtensions.some(ext => fileName.endsWith(ext));
                
                if (!isValid) {
                    alert('Only .ico and .png files are allowed for favicon');
                    this.value = '';
                }
            }
        });
    }
});
</script>
 @endpush
