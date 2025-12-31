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
                                                                    <a href="javascript:void(0);" >
                                                                        <i class="isax isax-setting-2 fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">General Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{route('profile')}}" >Account Settings</a></li>
                                                                       
                                                                    </ul>
                                                                </li>
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);" class="active subdrop">
                                                                        <i class="isax isax-global fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">Website Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{route('profile.company-setting')}}" class="active">Company Settings</a></li>
                                                                       
                                                                    </ul>
                                                                </li>
                                                               
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);">
                                                                        <i class="isax isax-more-2 fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">Email Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{route('profile.email-setting')}}">Email Settings</a></li>
                                                                       
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
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
       <strong>Success - </strong> {{ session('success') }}
       
    </div>
@endif

                                <form action="{{ route('save.companysettings') }}" class="needs-validation" method="POST" id="companysettingform">
                                     @csrf <!-- CSRF Token for protection -->
                                    <div class="border-bottom mb-3">
                                        <div class="card-title-head">
                                            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
												<span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center"><i class="isax isax-info-circle"></i></span> 
												General Information
											</h6>
                                        </div>

										<!-- start row -->
                                        <div class="row">
                                          

                                          <!-- Example of dynamically generated input fields -->

@foreach ($details as $setting)
    <div class="col-xl-6 col-lg-6 col-md-4">
        <div class="mb-3">
            <label class="form-label" for="setting_{{ $setting->id }}">
                {{ ucfirst($setting->name) }} <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="setting_{{ $setting->id }}" 
                name="settings[{{ $setting->id }}][value]" 
                value="{{ old('settings.' . $setting->id . '.value', $setting->value) }}" 
                placeholder="Enter value for {{ ucfirst($setting->name) }}">
                 <!-- Show individual field error -->
        @error('settings.' . $setting->id . '.value')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>
    </div>
@endforeach

                                        </div>
										<!-- end row -->
                                    </div>
                                  
                                  
                                    <div class="d-flex align-items-center justify-content-between settings-bottom-btn mt-0">
                                        <button type="button" class="btn btn-outline-white me-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
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