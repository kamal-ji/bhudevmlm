<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | Kanakku - Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="author" content="Tiara">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/backend/img/favicon.png')}}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/backend/img/apple-touch-icon.png')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap.min.css')}}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/tabler-icons/tabler-icons.min.css')}}">

    <!-- Iconsax CSS -->
    <link rel="stylesheet" href="{{asset('assets/backend/css/iconsax.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('assets/backend/css/style.css')}}">

    <link rel="stylesheet" href="{{asset('assets/backend/plugins/toastr/toatr.css')}}">

</head>

<body class="bg-white">

    <!-- Begin Wrapper -->
    <div class="main-wrapper auth-bg">

        <!-- Start Content -->
        <div class="container-fuild">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">

                <!-- start row -->
                <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap ">
                    <div class="col-lg-4 mx-auto">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            OTP verified for: <strong>{{ $email }}</strong>
                        </div>
                        <form action="" class="d-flex justify-content-center align-items-center" id="resetPasswordForm">
                            @csrf
                            <div class="d-flex flex-column justify-content-lg-center p-4 p-lg-0 pb-0 flex-fill">
                                <div class=" mx-auto mb-5 text-center">
                                    <img src="{{asset('assets/backend/img/logo.svg')}}" class="img-fluid" alt="Logo">
                                </div>
                                <div class="card border-0 p-lg-3 shadow-lg">
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <h5 class="mb-2">Reset Password</h5>
                                            <p class="mb-0">Please reset your password</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="pass-group input-group">
                                                <span class="input-group-text border-end-0">
                                                    <i class="isax isax-lock"></i>
                                                </span>
                                                <span class="isax toggle-password isax-eye-slash"></span>
                                                <input type="password"
                                                    class="pass-inputs form-control border-start-0 ps-0" id="password"
                                                    name="password" placeholder="****************">
                                                <div class="invalid-feedback" id="passwordError"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirmation Password</label>
                                            <div class="pass-group input-group">
                                                <span class="input-group-text border-end-0">
                                                    <i class="isax isax-lock"></i>
                                                </span>
                                                <span class="isax toggle-password isax-eye-slash"></span>
                                                <input type="password"
                                                    class="pass-inputs form-control border-start-0 ps-0"
                                                    id="password_confirmation" name="password_confirmation"
                                                    placeholder="****************">
                                                <div class="invalid-feedback" id="password_confirmationError"></div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Otp Code</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0">
                                                    <i class="isax isax-sms-notification"></i>
                                                </span>
                                                <input type="text" value="" id="otp" name="otp"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Enter Otp code">
                                                <div class="invalid-feedback" id="otpError"></div>
                                            </div>
                                        </div>





                                        <div class="mb-1 position-relative">
                                            <button type="submit"
                                                class="btn bg-primary-gradient text-white w-100 d-flex align-items-center justify-content-center"
                                                id="resetBtn"><span id="resettext">Reset
                                                    Password </span> <!-- Spinner (Initially hidden) -->
                                                <div id="loginSpinner"
                                                    class="spinner-border spinner-border-sm text-light ms-2 d-none"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </button>
                                        </div>



                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                        </form>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

            </div>
        </div>
        <!-- End Content -->

    </div>
    <!-- End Wrapper -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="topright-Toast" class="toast align-items-center text-white bg-danger border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <!-- Error message will be injected here -->
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{asset('assets/backend/js/jquery-3.7.1.min.js')}}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{asset('assets/backend/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Custom JS -->
    <script src="{{asset('assets/backend/js/script.js')}}"></script>
    <!-- Toastr JS -->
    <script src="{{asset('assets/backend/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/toastr/toastr.min.js')}}"></script>
    <!-- Firebase SDKs -->
    <script>
    $(document).ready(function() {
        // Handle login form submission
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content')
            }
        });
        $('#resetPasswordForm').on('submit', async function(e) {
            e.preventDefault();

            // Disable the login button and show the spinner
            $('#resetBtn').prop('disabled', true);
            $('#loginSpinner').removeClass('d-none');
            const password = $('input[name="password"]').val();
            const password_confirmation = $('input[name="password_confirmation"]').val();
            const otp = $('input[name="otp"]').val();
            //const deviceToken = $('input[name="device_token"]').val() || 'web-' + Date.now();

            $.ajax({
                url: "{{ route('reset.password.submit') }}", // Laravel route helper used in Blade
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Add CSRF token for Laravel
                },
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify({
                    password: password,
                    password_confirmation: password_confirmation,
                    otp: otp,
                }),
                success: function(response) {
                    if (response.success) {
                        // You can display a toastr success message here too

                        showSuccess(response.message);
                        // Redirect to dashboard

                        setTimeout(() => {
                            window.location.href = response.redirect_url ||
                                '/login';
                        }, 1000);
                    } else {
                        showError(response.message || 'password reset failed');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'password reset failed';

                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            // Handle validation errors (422 Unprocessable Entity)
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                errorMsg = errors[field][0]; // Show the first error
                                break;
                            }
                        } else if (xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                    }

                    showError(errorMsg);
                    resetLoginButton();
                }
            });

        });

    });

    // Helper to re-enable login button and hide spinner
    function resetLoginButton() {
        $('#resetBtn').prop('disabled', false);
        $('#loginSpinner').addClass('d-none');
    }

    function showError(message) {
        // Display the message somewhere on the page — customize as needed
        const toastElement = document.getElementById('topright-Toast');
        const toastBody = toastElement.querySelector('.toast-body');

        if (toastBody) {
            toastBody.innerText = message;
        }

        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }

    function showSuccess(message) {
        const toastElement = document.getElementById('topright-Toast');
        const toastBody = toastElement.querySelector('.toast-body');

        if (toastBody) {
            toastBody.innerText = message;
        }

        // Optionally, change background or class to indicate "success"
        toastElement.classList.remove('bg-danger'); // remove error style if present
        toastElement.classList.add('bg-success'); // add success style

        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
    </script>
</body>

</html>