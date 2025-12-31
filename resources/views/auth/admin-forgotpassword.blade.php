<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | Forgot Password</title>
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
                        <form action="" class="d-flex justify-content-center align-items-center" id="apiforgotForm">
                            @csrf
                            <div class="d-flex flex-column justify-content-lg-center p-4 p-lg-0 pb-0 flex-fill">
                                <div class=" mx-auto mb-5 text-center">
                                    <img src="{{asset('assets/backend/img/logo.svg')}}" class="img-fluid" alt="Logo">
                                </div>
                                <div class="card border-0 p-lg-3 shadow-lg rounded-2">
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <h5 class="mb-2">Forgot Paassword</h5>
                                            <p class="mb-0">No worries, we’ll send you reset instructions</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0">
                                                    <i class="isax isax-sms-notification"></i>
                                                </span>
                                                <input type="text" value="" id="email" name="email"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Enter Email Address">
                                                <div class="invalid-feedback" id="emailError"></div>
                                            </div>
                                        </div>
                                        <div class="mb-1 position-relative">
                                            <button type="submit" class="btn bg-primary-gradient text-white w-100 d-flex align-items-center justify-content-center" id="forgotpassword"><span id="resettext">Reset
                                                Password </span> <!-- Spinner (Initially hidden) -->
                                                <div id="loginSpinner"
                                                    class="spinner-border spinner-border-sm text-light ms-2 d-none"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
</button>
                                                                                    </div>
                                        <div class="text-center">
                                            <h6 class="fw-normal fs-14 text-dark mb-0">Return to
                                                <a href="{{route('login')}}" class="hover-a"> Sign In</a>
                                            </h6>
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
    <script>
    $(document).ready(function() {
        // Handle login form submission
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content')
            }
        });
        $('#apiforgotForm').on('submit', function(e) {
            e.preventDefault();
           
             // Disable the login button and show the spinner
    $('#forgotpassword').prop('disabled', true);
    $('#loginSpinner').removeClass('d-none');
            const email = $('input[name="email"]').val();
            

            $.ajax({
                url: "{{ route('forgotpassword.submit') }}", // Use the route name instead of the URL route('admin.login.submit'),
                method: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify({
                    email: email
                }),
                success: function(response) {
                    if (response.success) {
                        showSuccess(response.message);
                          setTimeout(() => {
                    window.location.href = response.redirect_url;
                }, 1000);
                    } else {
                        showError(response.message);
                        resetLoginButton();
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Otp sent failed';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showError(errorMsg);
                    resetLoginButton();
                }
            });
        });

    });

    function resetLoginButton() {
    $('#forgotpassword').prop('disabled', false);
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
    toastElement.classList.add('bg-success');   // add success style

    const toast = new bootstrap.Toast(toastElement);
    toast.show();
}
    </script>
</body>

</html>