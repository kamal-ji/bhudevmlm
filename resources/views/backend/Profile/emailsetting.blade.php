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
                                                                    <a href="javascript:void(0);" >
                                                                        <i class="isax isax-global fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">Website Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{route('profile.company-setting')}}">Company Settings</a></li>
                                                                       
                                                                    </ul>
                                                                </li>
                                                               
                                                                <li class="submenu">
                                                                    <a href="javascript:void(0);" class="active subdrop">
                                                                        <i class="isax isax-more-2 fs-18"></i>
                                                                        <span class="fs-14 fw-medium ms-2">Email Settings</span>
                                                                        <span class="isax isax-arrow-down-1 arrow-menu ms-auto"></span>
                                                                    </a>
                                                                    <ul>
                                                                        <li><a href="{{route('profile.email-setting')}}" class="active">Email Settings</a></li>
                                                                       
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
                                <div>
                                    <div class="pb-3 d-flex align-items-center justify-content-between border-bottom mb-3">
                                        <h6 class="mb-0">Email Settings</h6>
                                        <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendgrid"><i class="isax isax-send-25 me-1"></i>Send Test Email</a>
                                    </div>
                                    <div class="mb-0">

										<!-- start row -->
                                        <div class="row">
                                           
                                            <div class="col-md-6 d-flex">
                                                <div class="card flex-fill">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                                            <div class="d-flex align-items-center">
                                                                <span class="avatar avatar-lg bg-light me-2 p-2 flex-shrink-0">
                                                                    <img src="assets/img/settings/smtp.svg" class="img-fluid" alt="img">
                                                                </span>
                                                                <p class="text-gray-9 fw-medium">SMTP</p>
                                                            </div>
                                                            <span class="badge badge-soft-success d-flex align-items-center">
                                                                <span class="badge-dot bg-success me-1"></span> Connected
                                                            </span>
                                                        </div>
                                                        <p class="fs-13">SMTP is used to send, relay or forward messages from a mail client.</p>
                                                    </div><!-- end card body -->
                                                    <div class="card-footer bg-light">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-dark rounded-2 d-inline-flex align-items-center justify-content-center p-1 me-2" data-bs-toggle="modal" data-bs-target="#delete_modal">
                                                                    <i class="isax isax-trash fs-14"></i>
                                                                </a>
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-dark rounded-2 d-inline-flex align-items-center justify-content-center p-1 me-2" data-bs-toggle="modal" data-bs-target="#smtpsettings">
                                                                    <i class="isax isax-setting-2 fs-14"></i>
                                                                </a>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </div>
                                                    </div><!-- end card footer -->
                                                </div><!-- end card -->
                                            </div><!-- end col -->
                                           
                                        </div>
										<!-- end row -->

                                    </div>
                                </div>
                            </div><!-- end col -->
                        <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div><!-- end col -->
                </div>
                <!-- end row -->

            </div>

             <!-- Start Add Modal  -->
        <div id="smtpsettings" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">SMTP</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div>
                    <form action="email-settings.html">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">From Email Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email Host <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div>
                                        <label class="form-label">Port <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Modal -->

          <!-- Start Add Modal  -->
        <div id="sendgrid" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Test Mail</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div>
                    <form action="email-settings.html">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Modal -->
            @endsection