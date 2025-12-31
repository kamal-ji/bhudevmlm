@extends('layouts.admin')

@section('content')
<div class="content content-two">

    <!-- Page Header -->
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6><a href="{{ route('customers') }}"><i class="isax isax-arrow-left fs-16 me-2"></i>Customers</a></h6>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
            <div class="dropdown">
                <a href="javascript:void(0);"
                    class="dropdown-toggle btn btn-primary d-flex align-items-center fs-14 fw-semibold"
                    data-bs-toggle="dropdown">
                    Add New
                </a>
                <ul class="dropdown-menu  dropdown-menu-end">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item"> <i
                                class="isax isax-document-text fs-14 me-2"></i>Invoice </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item"> <i
                                class="isax isax-money-send fs-14 me-2"></i> Expense</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item"> <i
                                class="isax isax-money-add fs-14 me-2"></i> Credit Notes</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item"> <i
                                class="isax isax-money-recive fs-14 me-2"></i> Debit Notes</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item"> <i
                                class="isax isax-document fs-14 me-2"></i> Purchase Order</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item"> <i
                                class="isax isax-document-download fs-14 me-2"></i> Quotation</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item"> <i
                                class="isax isax-document-forward fs-14 me-2"></i> Delivery Challan</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- start row -->
    <div class="row">
        <div class="col-xl-8">


            <!-- Start User -->
            <div class="card bg-light customer-details-info position-relative overflow-hidden">
                <div class="card-body position-relative z-1">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="avatar avatar-xxl rounded-circle flex-shrink-0">
                                <img src="{{ ($analytics['profile']['image'] ? get('image_url') . $analytics['profile']['image'] : asset('assets/backend/img/users/user-08.jpg')) }}"
                                    alt="user-01" class="img-fluid rounded-circle border border-white border-2">
                            </div>
                            <div class="">
                                <p class="text-primary fs-14 fw-medium mb-1">Cl-{{ $analytics['profile']['code'] }}</p>
                                <h6 class="mb-2"> {{ $analytics['profile']['first_name'] }}
                                    {{ $analytics['profile']['last_name'] }}
                                    <img src="{{ asset('assets/backend/img/icons/confirme.svg') }}" alt="confirme"
                                        class="ms-1">
                                </h6>
                                <p class="text-primary fs-14 fw-medium mb-1">Group-{{ $analytics['profile']['group'] }}
                                </p>
                                <p class="fs-14 fw-regular"><i class="isax isax-location fs-14 me-1 text-gray-9"></i>
                                    {{ $analytics['profile']['buildingno'] }}, {{ $analytics['profile']['address1'] }},
                                    {{ $analytics['profile']['address2'] }} {{ $analytics['profile']['zip'] }},
                                    {{ $analytics['profile']['city'] }}, {{ $analytics['profile']['region'] }},
                                    {{ $analytics['profile']['country'] }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('customers.edit', $analytics['profile']['customerid']) }}"
                            class="btn btn-outline-white border border-1 border-grey border-sm bg-white">
                            <i class="isax isax-edit-2 fs-13 fw-semibold text-dark me-1"></i> Edit Profile
                        </a>
                    </div>

                    <div class="card border-0 shadow shadow-none mb-0 bg-white">
                        <div class="card-body border-0 shadow shadow-none">
                            <ul
                                class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-0 m-0 list-unstyled">
                                <li>
                                    <h6 class="mb-1 fs-14 fw-semibold"> <i class="isax isax-sms fs-14 me-2"></i>Email
                                        Address</h6>
                                    <p> {{ $analytics['profile']['email'] }} </p>
                                </li>
                                <li>
                                    <h6 class="mb-1 fs-14 fw-semibold"> <i class="isax isax-call fs-14 me-2"></i>Phone
                                    </h6>
                                    <p> {{ $analytics['profile']['mobile'] }} </p>
                                </li>
                                <li>
                                    <h6 class="mb-1 fs-14 fw-semibold"> <i
                                            class="isax isax-building fs-14 me-2"></i>Building no </h6>
                                    <p> {{ $analytics['profile']['buildingno'] ?? 'No company info available' }}</p>
                                </li>
                                <li>
                                    <h6 class="mb-1 fs-14 fw-semibold"> <i
                                            class="isax isax-global fs-14 me-2"></i>Website</h6>
                                    <p class="d-flex align-items-center">
                                        <a href="#" target="_blank">{{ $analytics['profile']['website'] ?? 'No company info available' }}</a>
                                        <i class="isax isax-link fs-14 ms-1 text-primary"></i>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- end card body -->
                <img src="assets/img/icons/elements-01.svg" alt="elements-01" class="img-fluid customer-details-bg">
            </div><!-- end card -->
            <!-- end card -->
            <!-- End User -->

            <!-- Start Statistics -->
            <div class="card">
                <div class="card-body">
                    <h6 class="pb-3 mb-3 border-1 border-bottom border-gray"> Invoice Statistics </h6>
                    <ul class="d-flex align-items-center justify-content-between flex-wrap gap-2 p-0 m-0 list-unstyled">
                        @foreach($analytics['sale_info'] as $key => $sale_info)
                        <li>
                            <p class="mb-2">
                                <i class="fa-solid fa-circle fs-10 text-primary me-2"></i>
                                {{ $sale_info['field_text'] }}
                                @if(!empty($sale_info['field_text2']))
                                
                                @endif
                            </p>
                            <h6 class="fs-16 fw-600">
                                {{ $analytics['profile']['currency'] }} {{ number_format($sale_info['amount'], 2) }}
                            </h6>
                            <small class="text-muted">
                                {{ $sale_info['field_text2'] }}: {{ $sale_info['growth'] }} %
                            </small>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- End Statistics -->


            <!-- Start Tablelist -->
            <div class="card table-info">
                <div class="card-body">
                    <h6 class="pb-3 mb-3 border-1 border-bottom border-gray"> Invoice </h6>
                    <div class="table-responsive table-nowrap">
                        <table class="table border  m-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="no-sort">ID</th>
                                    <th>Created On</th>
                                    <th>Amount</th>
                                    <th class="no-sort">Status</th>
                                    <th>Due Date</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
        @if(!empty($analytics['invoices']) && count($analytics['invoices']) > 0)
            @foreach($analytics['invoices'] as $invoice)
                <tr data-id="{{ $invoice['invoiceid'] ?? '' }}">
                    <td>
                        <a href="#" class="link-default">{{ $invoice['invoice_no'] ?? 'N/A' }}</a>
                    </td>
                    <td>{{ $invoice['date'] ?? 'N/A' }}</td>
                    <td class="text-dark">{{ $invoice['currency'] ?? '' }}{{ $invoice['amount'] ?? '0.00' }}</td>
                    <td>
                        <span class="badge 
                            @if (($invoice['status'] ?? '') == 'Paid') badge-soft-success 
                            @elseif (($invoice['status'] ?? '') == 'Cancelled') badge-soft-danger 
                            @elseif (($invoice['status'] ?? '') == 'Partial_paid') badge-soft-primary 
                            @elseif (($invoice['status'] ?? '') == 'Unpaid') badge-soft-warning 
                            @else badge-soft-info 
                            @endif badge-sm d-inline-flex align-items-center">
                            {{ $invoice['status'] ?? 'Unknown' }}
                            <i class="isax isax-tick-circle ms-1"></i>
                        </span>
                    </td>
                    <td>{{ $invoice['due_date'] ?? 'N/A' }}</td>
                    <td class="action-item">
                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ $invoice['invoiceid'] ?? '#' }}" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-eye me-2"></i>View
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-archive-2 me-2"></i>Archive
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item d-flex align-items-center"
                                   data-bs-toggle="modal" data-bs-target="#delete_modal">
                                   <i class="isax isax-trash me-2"></i>Delete
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">No invoices found</td>
            </tr>
        @endif
    </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Tablelist -->

            <!-- Start Tablelist -->
            <div class="card table-info">
                <div class="card-body">
                    <h6 class="pb-3 mb-3 border-1 border-bottom border-gray"> Order </h6>
                    <div class="table-responsive table-nowrap">
                        <table class="table border  m-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="no-sort">Order No</th>
                                    <th>Date</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th class="no-sort">Status</th>

                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($analytics['orders'] as $order)
                                <tr data-id="{{ $order['orderid'] }}">
                                    <td>
                                        <a href="#" class="link-default">{{ $order['order_no'] }}</a>
                                    </td>
                                    <td>{{ $order['date'] }}</td>
                                    <td><img src="{{ ($order['image'] ? get('image_url') . $order['image'] : asset('assets/backend/img/users/user-08.jpg')) }}"
                                            alt="img" class="img-fluid" width="40"></td>
                                    <td>
                                        {{ $order['name'] }}
                                        <span class="text-muted">, </span>
                                        <strong>Pcs:</strong> {{ $order['pcs'] }}
                                        <span class="text-muted">, </span>
                                        <strong>Weight:</strong> {{ $order['weight'] }} kg
                                    </td>

                                    <td class="text-dark">{{ $order['currency'] }}{{ $order['amount'] }}</td>
                                    <td>
                                        <span
                                            class="badge badge-soft-success badge-sm d-inline-flex align-items-center">{{ $order['delivery_status'] }}<i
                                                class="isax isax-tick-circle ms-1"></i></span>
                                    </td>

                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ $invoice['invoiceid'] }}"
                                                    class="dropdown-item d-flex align-items-center"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item d-flex align-items-center"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item d-flex align-items-center"><i
                                                        class="isax isax-archive-2 me-2"></i>Archive</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item d-flex align-items-center"
                                                    data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                                @if(count($analytics['orders']) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">No Orders found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Tablelist -->


        </div><!-- end col -->
        <div class="col-xl-4">
            <!-- Start Notes -->
            <div class="card">
                <div class="card-body">
                    <h6 class="pb-3 mb-3 border-1 border-bottom border-gray"> Notes </h6>
                    <p class="text-truncate line-clamb-3"> {{ $analytics['profile']['note'] }} </p>
                </div><!-- end card body -->
            </div><!-- end card -->
            <!-- End Notes -->

            <!-- Start Payment -->
            <div class="card">
                <div class="card-body">
                    <h6 class="pb-3 mb-3 border-1 border-bottom border-gray"> Payments History </h6>
                    @foreach($analytics['payment_history'] as $history)
                    <div class="d-flex align-items-center justify-content-between mb-3"
                        data-id="{{ $order['orderid'] }}">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md flex-shrink-0 me-2">
                                <img src="{{ asset('assets/backend/img/icons/transaction-01.svg') }}"
                                    class="rounded-circle" alt="img">
                            </a>
                            <div>
                                <h6 class="fs-14 fw-semibold mb-1"><a
                                        href="javascript:void(0);">{{ $history['name'] }}</a></h6>
                                <p class="fs-13"><a href="#" class="link-default">#{{ $history['invoice_no'] }}</a>
                                </p>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 fs-13"> Amount </p>
                            <p class="mb-0 fs-14 fw-semibold text-gray-9">
                                {{ $history['currency'] }}{{ $history['amount'] }} </p>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-sm badge-soft-success"> {{ $history['status'] }} <i
                                    class="isax isax-tick-circle fs-10 fw-semibold ms-1"></i></span>
                        </div>
                    </div>
                    @endforeach
                    @if(count($analytics['payment_history']) == 0)
                    <p class="text-center">No history found</p>
                    @endif
                </div><!-- end card body -->
            </div><!-- end card -->
            <!-- End Payment -->

            <!-- Start Recent Activities -->
            <div class="card flex-fill overflow-hidden">
                <div class="card-body pb-0">
                    <div class="mb-0">
                        <h6 class="mb-1 pb-3 mb-3 border-bottom">Recent Activities</h6>
                        <div class="recent-activities recent-activities-two">
                            @foreach($analytics['receent_activity'] as $activity)
                            <div class="d-flex align-items-center pb-3">
                                <span
                                    class="border z-1 border-primary rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center bg-white p-1"><i
                                        class="fa fa-circle fs-8 text-primary"></i></span>
                                <div class="recent-activities-flow">
                                    <p class="mb-1">{{ $activity['title'] }}

                                        <span class="text-gray-9 fw-semibold">{{ $activity['status'] }}</span>

                                    </p>
                                    <p class="mb-0 d-inline-flex align-items-center fs-13"><i
                                            class="isax isax-calendar-25 me-1"></i>{{ $activity['date'] }}</p>
                                </div>
                            </div>
                            @endforeach
                            @if(count($analytics['receent_activity']) == 0)
                            <p class="text-center">No history found</p>
                            @endif
                        </div>
                    </div>
                </div><!-- end card body -->
                <a href="javascript:void(0);" class="btn w-100 fs-14 py-2 shadow-lg fw-medium">View All</a>
            </div><!-- end card -->
            <!-- End Recent Activities -->
        </div>
    </div>
    <!-- end row -->


</div>
@endsection
@push('scripts')
@endpush