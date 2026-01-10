<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Bhudevmlm') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Bhudevmlm">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/backend/img/favicon.png') }} ">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/backend/img/apple-touch-icon.png') }}">

    <!-- Theme Script js -->
    <script src="{{ asset('assets/backend/js/theme-script.js') }}"></script>
   
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
     
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/tabler-icons/tabler-icons.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome/css/all.min.css') }}">
  


    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/simplebar/simplebar.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/select2/css/select2.min.css') }}">

    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/bootstrap-datetimepicker.min.css') }}">

    <!-- Rangeslider CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/dataTables.bootstrap5.min.css') }}">
          
    <!-- Iconsax CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/iconsax.css') }}">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/toastr/toatr.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/style.css') }}">
    

    
     <style>
        .btn-menubar {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border: none;
  background: transparent;
  cursor: pointer;
}

.btn-menubar svg {
  transition: stroke 0.3s ease;
}

.btn-menubar:hover svg {
  stroke: #dc3545; /* Red on hover */
}

.wishlist-counter, .cart-counter {
  top: 6px;
  right: 6px;
  background-color: #dc3545;
  color: white;
  font-size: 0.65rem;
  padding: 3px 6px;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  line-height: 12px;
  text-align: center;
  font-weight: 600;
}

        </style>
    @stack('styles')
</head>


<body>
    <!-- Your admin layout content -->
    <!-- Begin Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar Start -->
        @include('backend.partials.header')
        <!-- Topbar End -->

        <!-- Sidenav Menu Start -->
        @include('backend.partials.sidebar')
        <!-- Sidenav Menu End -->

        <!-- ========================
   Start Page Content
  ========================= -->

        <div class="page-wrapper">
            @yield('content')

            <!-- Footer Menu Start -->
            @include('backend.partials.footer')
            <!-- Footer  Menu End -->
        </div>
        <!-- ========================
   End Page Content
  ========================= -->


        <!-- Start Add Ledger  -->
        <div id="add_ledger" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Ledger</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close"
                            data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div>
                    <form action="index.html">
                        <div class="modal-body pb-1">
                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <div class="input-group position-relative">
                                    <input type="text" class="form-control datetimepicker rounded-end"
                                        placeholder="dd/mm/yyyy">
                                    <span class="input-icon-addon fs-16 text-gray-9">
                                        <i class="isax isax-calendar-2"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mode</label>
                                <div class="d-flex align-items-center">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="Radio" id="Radio-sm-1">
                                        <label class="form-check-label" for="Radio-sm-1">
                                            Credit
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Radio" id="Radio-sm-2"
                                            checked="">
                                        <label class="form-check-label" for="Radio-sm-2">
                                            Debit
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Ledger -->

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    
    <!-- Simplebar JS -->
    <script src="{{ asset('assets/backend/plugins/simplebar/simplebar.min.js') }}"></script>


    <!-- Bootstrap Core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   
    <!-- Select2 JS -->
    <script src="{{ asset('assets/backend/plugins/select2/js/select2.min.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Rangeslider JS -->
    <script src="{{ asset('assets/backend/plugins/ion-rangeslider/js/ion.rangeSlider.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/ion-rangeslider/js/custom-rangeslider.js') }}"></script>

    <!-- Daterangepicker JS -->
    <script src="{{ asset('assets/backend/js/moment.js') }}"></script>
  
    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/backend/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Apexchart JS -->
    <script src="{{ asset('assets/backend/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/apexchart/chart-data.js') }}"></script>

    <!-- Datatable JS -->
    <script src="{{ asset('assets/backend/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/backend/plugins/toastr/toastr.min.js') }}"></script>

    <!-- Custom JS -->
    
    <script src="{{ asset('assets/backend/js/form-validation.js') }}"></script>
    <script src="{{ asset('assets/backend/js/script.js') }}"></script>
   <script src="{{ asset('assets/backend/js/app.js') }}"></script>
   
       <!-- Firebase SDKs -->
    <!-- Firebase App (the core Firebase SDK) -->
    <script src="https://www.gstatic.com/firebasejs/10.5.0/firebase-app-compat.js"></script>

    <!-- Firebase Cloud Messaging -->
    <script src="https://www.gstatic.com/firebasejs/10.5.0/firebase-messaging-compat.js"></script>
    <script>
    // Your Firebase project config
    const firebaseConfig = {
        apiKey: "{{ get('firbase_apiKey') }}",
        authDomain: "{{ get('firebase_auth_domain') }}",
        projectId: "{{ get('firebase_project_id') }}",
        storageBucket: "{{ get('firebase_storage_bucket') }}",
        messagingSenderId: "{{ get('firebase_messaging_sender_id') }}",
        appId: "{{ get('firebase_app_id') }}",
        measurementId: "{{ get('firebase_measurement_id') }}",
    };

    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();


</script>
    <script>
        // Helper to re-enable login button and hide spinner
        $(document).ready(function() {
            $('#countryid').on('change', function() {
                var countryId = $(this).val();
                $.ajax({
                    url: '/getstates/' + countryId,
                    method: 'GET',
                    success: function(response) {
                        $('#regionid').empty();
                        $('#regionid').append('<option value="">Select State</option>');
                        $.each(response.states, function(index, state) {
                            $('#regionid').append('<option value="' + state.id + '">' +
                                state.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        showError('An error occurred while fetching states');
                    }
                });
            });
        });

  
        function resetLoginButton() {
            $('.submitbtn').prop('disabled', false);
            $('.loading-spinner').addClass('d-none');
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
        
       messaging.onMessage(function(payload) {
    console.log('Received foreground message: ', payload);
    
    // Show notification using browser's Notification API
    if (Notification.permission === 'granted') {
        const notificationTitle = payload.notification.title;
        const notificationOptions = {
            body: payload.notification.body,
            icon: '/firebase-logo.png', // Make sure this path is correct
            data: payload.data || {} // Optional data
        };
        
        // This will show the notification when app is in foreground
        new Notification(notificationTitle, notificationOptions);
    }
});
    </script>
    @stack('scripts')
</body>

</html>
