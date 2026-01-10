@extends('layouts.admin')

@section('content')

<!-- Start Content -->
<div class="content">

    <!-- Start Breadcrumb -->
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>MLM Dashboard</h6>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
            <div id="reportrange" class="reportrange-picker d-flex align-items-center">
                <i class="isax isax-calendar text-gray-5 fs-14 me-1"></i><span class="reportrange-picker-field">16 Apr 2024 - 16 Apr 2024</span>
            </div>
            <div class="dropdown">
                <a class="btn btn-primary d-flex align-items-center justify-content-center dropdown-toggle"
                    data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
                    Quick Actions
                </a>
                <ul class="dropdown-menu dropdown-menu-start">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                            <i class="isax isax-user-add me-2"></i>Add New Member
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                            <i class="isax isax-gift me-2"></i>Create Package
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                            <i class="isax isax-money-add me-2"></i>Commission Payout
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                            <i class="isax isax-money-send me-2"></i>Process Withdrawal
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                    data-bs-toggle="dropdown">
                    <i class="isax isax-export-1 me-1"></i>Reports
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">Members Report</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">Commission Report</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">Sales Report</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <div class="bg-primary rounded welcome-wrap position-relative mb-3">
        <!-- start row -->
        <div class="row">
            <div class="col-lg-8 col-md-9 col-sm-7">
                <div>
                    @php
                    $hour = date("H");
                    if ($hour >= 5 && $hour < 12) { $wish="Good morning!" ; } elseif ($hour>= 12 && $hour < 17) {
                            $wish="Good afternoon!" ; } elseif ($hour>= 17 && $hour < 21) { $wish="Good evening!" ; }
                                else { $wish="Good night!" ; } @endphp <h5 class="text-white mb-1">{{$wish}}, Admin</h5>
                                <p class="text-white mb-3">MLM Network Status: <span class="badge bg-success">Active</span></p>
                                <div class="d-flex align-items-center flex-wrap gap-3">
                                    <p class="d-flex align-items-center fs-13 text-white mb-0">
                                        <i class="isax isax-calendar5 me-1"></i>
                                        {{ now()->format('l, d M Y') }}
                                    </p>
                                    <p class="d-flex align-items-center fs-13 text-white mb-0">
                                        <i class="isax isax-user me-1"></i>
                                        Total Members: 1,245
                                    </p>
                                    <p class="d-flex align-items-center fs-13 text-white mb-0">
                                        <i class="isax isax-dollar-circle me-1"></i>
                                        Today's Commission: $1,250.50
                                    </p>
                                </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <div class="position-absolute end-0 top-50 translate-middle-y p-2 d-none d-sm-block">
            <img src="{{asset('assets/backend/img/icons/network.svg')}}" alt="img">
        </div>
    </div>

    <!-- start row -->
    <div class="row">
        <div class="col-md-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="d-flex align-items-center mb-1"><i
                                class="isax isax-people text-default me-2"></i>Network Overview</h6>
                    </div>
                    <div class="row g-4">
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                                    <i class="isax isax-profile-2user fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Total Members</p>
                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">1,245</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center me-2">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                                    <i class="isax isax-user-add fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">New Today</p>
                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">24</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                                    <i class="isax isax-crown-1 fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Active Packages</p>
                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">856</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center me-2">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                                    <i class="isax isax-level fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Network Levels</p>
                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">5</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="d-flex align-items-center mb-1"><i
                                class="isax isax-chart-215 text-default me-2"></i>Financial Overview</h6>
                    </div>
                    <div class="row g-4">
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                                    <i class="isax isax-dollar-circle fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Total Sales</p>
                                    <h6 class="fs-16 fw-semibold mb-0">$124,568</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center me-2">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                                    <i class="isax isax-money-add fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Paid Commission</p>
                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">$45,230</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                                    <i class="isax isax-money-tick fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 mb-0">Pending Payout</p>
                                    <h6 class="fs-16 fw-semibold text-truncate">$12,450</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center me-2">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                                    <i class="isax isax-wallet-3 fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Wallet Balance</p>
                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">$89,450</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="d-flex align-items-center mb-1"><i
                                class="isax isax-chart-success5 text-default me-2"></i>Package Statistics</h6>
                    </div>
                    <div class="row g-4">
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                                    <i class="isax isax-gift fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Basic Package</p>
                                    <h6 class="fs-16 fw-semibold mb-0">420</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center me-2">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                                    <i class="isax isax-crown fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Premium</p>
                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">256</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                                    <i class="isax isax-star fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Gold Package</p>
                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">124</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex align-items-center me-2">
                                <span
                                    class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                                    <i class="isax isax-crown-1 fs-20"></i>
                                </span>
                                <div>
                                    <p class="mb-1 text-truncate">Platinum</p>
                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">56</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- start row -->
    <div class="row">
        <div class="col-md-4 d-flex flex-column">
            <div class="card overflow-hidden z-1 flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between border-bottom mb-2 pb-2">
                        <div>
                            <p class="mb-1">Direct Referrals</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs-16 fw-semibold me-2">145</h6>
                                <span class="badge badge-sm badge-soft-success">+8<i
                                        class="isax isax-arrow-up-15 ms-1"></i></span>
                            </div>
                        </div>
                        <span class="avatar avatar-lg bg-light text-dark avatar-rounded">
                            <i class="isax isax-user-add fs-16"></i>
                        </span>
                    </div>
                    <a href="javascript:void(0);" class="fw-medium text-decoration-underline">View All Members</a>
                </div>
                <div class="position-absolute end-0 bottom-0 z-n1">
                    <img src="{{asset('assets/backend/img/bg/card-bg-01.svg')}}" alt="img">
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex flex-column">
            <div class="card overflow-hidden z-1 flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between border-bottom mb-2 pb-2">
                        <div>
                            <p class="mb-1">Team Size</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs-16 fw-semibold me-2">856</h6>
                                <span class="badge badge-sm badge-soft-success">+24<i
                                        class="isax isax-arrow-up-15 ms-1"></i></span>
                            </div>
                        </div>
                        <span class="avatar avatar-lg bg-light text-dark avatar-rounded">
                            <i class="isax isax-people fs-16"></i>
                        </span>
                    </div>
                    <a href="javascript:void(0);" class="fw-medium text-decoration-underline">View Network Tree</a>
                </div>
                <div class="position-absolute end-0 bottom-0 z-n1">
                    <img src="{{asset('assets/backend/img/bg/card-bg-02.svg')}}" alt="img">
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex flex-column">
            <div class="card overflow-hidden z-1 flex-fill">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between border-bottom mb-2 pb-2">
                        <div>
                            <p class="mb-1">Total Commission</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs-16 fw-semibold me-2">$45,230</h6>
                                <span class="badge badge-sm badge-soft-success">+$1,250<i
                                        class="isax isax-arrow-up-15 ms-1"></i></span>
                            </div>
                        </div>
                        <span class="avatar avatar-lg bg-light text-dark avatar-rounded">
                            <i class="isax isax-money-add fs-16"></i>
                        </span>
                    </div>
                    <a href="javascript:void(0);" class="fw-medium text-decoration-underline">View Commission Details</a>
                </div>
                <div class="position-absolute end-0 bottom-0 z-n1">
                    <img src="{{asset('assets/backend/img/bg/card-bg-03.svg')}}" alt="img">
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- start row -->
    <div class="row">
        <div class="col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body pb-0">
                    <div class="mb-3">
                        <h6 class="mb-1">Commission Analytics</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <p class="mb-1">Total Commission</p>
                            <div class="d-flex align-items-center">
                                <h6 class="fs-16 fw-semibold me-2">$45,230</h6>
                                <span class="badge badge-sm badge-soft-success">+15%<i
                                        class="isax isax-arrow-up-15 ms-1"></i></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <p class="fs-13 text-dark d-flex align-items-center mb-0"><i
                                    class="fa-solid fa-circle text-primary-transparent fs-12 me-1"></i>Direct Commission </p>
                            <p class="fs-13 text-dark d-flex align-items-center mb-0"><i
                                    class="fa-solid fa-circle text-primary fs-12 me-1"></i>Team Commission</p>
                        </div>
                    </div>
                    <div id="commission_chart"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="mb-1">Top Performers</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-borderless custom-table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-lg rounded-circle me-2 flex-shrink-0">
                                                <img src="{{asset('assets/backend/img/users/user-01.jpg')}}"
                                                    class="rounded-circle" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-1">
                                                    <a href="javascript:void(0);">John Smith</a>
                                                </h6>
                                                <p class="fs-13">Team Size: 45</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-1">Commission</p>
                                        <h6 class="fs-14 fw-semibold">$12,500</h6>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <span class="badge bg-warning">
                                                Gold
                                            </span>
                                            <a href="javascript:void(0);" 
                                               class="btn btn-icon btn-sm btn-light" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-title="View Details">
                                                <i class="isax isax-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-lg rounded-circle me-2 flex-shrink-0">
                                                <img src="{{asset('assets/backend/img/users/user-02.jpg')}}"
                                                    class="rounded-circle" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-1">
                                                    <a href="javascript:void(0);">Emily Clark</a>
                                                </h6>
                                                <p class="fs-13">Team Size: 32</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-1">Commission</p>
                                        <h6 class="fs-14 fw-semibold">$9,850</h6>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <span class="badge bg-success">
                                                Silver
                                            </span>
                                            <a href="javascript:void(0);" 
                                               class="btn btn-icon btn-sm btn-light" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-title="View Details">
                                                <i class="isax isax-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-lg rounded-circle me-2 flex-shrink-0">
                                                <img src="{{asset('assets/backend/img/users/user-03.jpg')}}"
                                                    class="rounded-circle" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-1">
                                                    <a href="javascript:void(0);">Michael Brown</a>
                                                </h6>
                                                <p class="fs-13">Team Size: 28</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-1">Commission</p>
                                        <h6 class="fs-14 fw-semibold">$8,250</h6>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <span class="badge bg-info">
                                                Bronze
                                            </span>
                                            <a href="javascript:void(0);" 
                                               class="btn btn-icon btn-sm btn-light" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-title="View Details">
                                                <i class="isax isax-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-lg rounded-circle me-2 flex-shrink-0">
                                                <img src="{{asset('assets/backend/img/users/user-04.jpg')}}"
                                                    class="rounded-circle" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-1">
                                                    <a href="javascript:void(0);">Sarah Johnson</a>
                                                </h6>
                                                <p class="fs-13">Team Size: 24</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-1">Commission</p>
                                        <h6 class="fs-14 fw-semibold">$7,150</h6>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <span class="badge bg-secondary">
                                                Member
                                            </span>
                                            <a href="javascript:void(0);" 
                                               class="btn btn-icon btn-sm btn-light" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-title="View Details">
                                                <i class="isax isax-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-light btn-lg w-100 text-decoration-underline mt-3">All Top Performers</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- start row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-3">
                        <h6 class="mb-1">Recent Package Purchases</h6>
                        <a href="javascript:void(0);" class="btn btn-primary mb-1">View All Packages</a>
                    </div>
                    <div class="table-responsive no-filter no-pagination">
                        <table class="table table-nowrap border mb-0">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Member</th>
                                    <th>Package</th>
                                    <th>Amount</th>
                                    <th>Commission</th>
                                    <th>Referrer</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="link-default">TXN001245</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                                                <img src="{{asset('assets/backend/img/users/user-06.jpg')}}" 
                                                     class="rounded-circle" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0">
                                                    <a href="javascript:void(0);">David Wilson</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            Platinum
                                        </span>
                                    </td>
                                    <td class="text-dark">$499.99</td>
                                    <td class="text-success">$49.99</td>
                                    <td>
                                        <a href="javascript:void(0);" class="link-default">
                                            John Smith
                                        </a>
                                    </td>
                                    <td>15 Apr 2024</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="link-default">TXN001244</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                                                <img src="{{asset('assets/backend/img/users/user-07.jpg')}}" 
                                                     class="rounded-circle" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0">
                                                    <a href="javascript:void(0);">Lisa Anderson</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">
                                            Gold
                                        </span>
                                    </td>
                                    <td class="text-dark">$299.99</td>
                                    <td class="text-success">$29.99</td>
                                    <td>
                                        <a href="javascript:void(0);" class="link-default">
                                            Emily Clark
                                        </a>
                                    </td>
                                    <td>14 Apr 2024</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="link-default">TXN001243</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                                                <img src="{{asset('assets/backend/img/users/user-08.jpg')}}" 
                                                     class="rounded-circle" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0">
                                                    <a href="javascript:void(0);">Robert Taylor</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            Premium
                                        </span>
                                    </td>
                                    <td class="text-dark">$199.99</td>
                                    <td class="text-success">$19.99</td>
                                    <td>
                                        <span class="text-muted">N/A</span>
                                    </td>
                                    <td>14 Apr 2024</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="link-default">TXN001242</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                                                <img src="{{asset('assets/backend/img/users/user-09.jpg')}}" 
                                                     class="rounded-circle" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0">
                                                    <a href="javascript:void(0);">Maria Garcia</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            Basic
                                        </span>
                                    </td>
                                    <td class="text-dark">$99.99</td>
                                    <td class="text-success">$9.99</td>
                                    <td>
                                        <a href="javascript:void(0);" class="link-default">
                                            Michael Brown
                                        </a>
                                    </td>
                                    <td>13 Apr 2024</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="link-default">TXN001241</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                                                <img src="{{asset('assets/backend/img/users/user-10.jpg')}}" 
                                                     class="rounded-circle" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0">
                                                    <a href="javascript:void(0);">James Miller</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            Platinum
                                        </span>
                                    </td>
                                    <td class="text-dark">$499.99</td>
                                    <td class="text-success">$49.99</td>
                                    <td>
                                        <a href="javascript:void(0);" class="link-default">
                                            Sarah Johnson
                                        </a>
                                    </td>
                                    <td>12 Apr 2024</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- start row -->
    <div class="row">
        <div class="col-lg-12 col-xl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body pb-1">
                    <div class="mb-3">
                        <h6 class="mb-1">Pending Withdrawals</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md flex-shrink-0 me-2">
                                <img src="{{asset('assets/backend/img/users/user-11.jpg')}}" 
                                     class="rounded-circle" alt="img">
                            </a>
                            <div>
                                <h6 class="fs-14 fw-semibold mb-1">
                                    <a href="javascript:void(0);">Thomas Lee</a>
                                </h6>
                                <p class="fs-13">15 Apr 2024</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-lg badge-soft-warning">$1,250.00</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md flex-shrink-0 me-2">
                                <img src="{{asset('assets/backend/img/users/user-12.jpg')}}" 
                                     class="rounded-circle" alt="img">
                            </a>
                            <div>
                                <h6 class="fs-14 fw-semibold mb-1">
                                    <a href="javascript:void(0);">Jennifer Hall</a>
                                </h6>
                                <p class="fs-13">14 Apr 2024</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-lg badge-soft-warning">$850.50</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md flex-shrink-0 me-2">
                                <img src="{{asset('assets/backend/img/users/user-13.jpg')}}" 
                                     class="rounded-circle" alt="img">
                            </a>
                            <div>
                                <h6 class="fs-14 fw-semibold mb-1">
                                    <a href="javascript:void(0);">Kevin Martin</a>
                                </h6>
                                <p class="fs-13">13 Apr 2024</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-lg badge-soft-warning">$620.25</span>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-light btn-sm w-100 mt-2">View All Withdrawals</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="mb-1">Package Distribution</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg flex-shrink-0 me-2 bg-primary-subtle text-primary">
                                <i class="isax isax-gift"></i>
                            </div>
                            <div>
                                <h6 class="fs-14 fw-semibold mb-1">Basic Package</h6>
                                <p class="fs-13">420 Members</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-sm bg-primary">50%</span>
                            <p class="fs-13">$41,580</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg flex-shrink-0 me-2 bg-success-subtle text-success">
                                <i class="isax isax-crown"></i>
                            </div>
                            <div>
                                <h6 class="fs-14 fw-semibold mb-1">Premium</h6>
                                <p class="fs-13">256 Members</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-sm bg-success">30%</span>
                            <p class="fs-13">$51,174</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg flex-shrink-0 me-2 bg-warning-subtle text-warning">
                                <i class="isax isax-star"></i>
                            </div>
                            <div>
                                <h6 class="fs-14 fw-semibold mb-1">Gold Package</h6>
                                <p class="fs-13">124 Members</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-sm bg-warning">15%</span>
                            <p class="fs-13">$37,198</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg flex-shrink-0 me-2 bg-info-subtle text-info">
                                <i class="isax isax-crown-1"></i>
                            </div>
                            <div>
                                <h6 class="fs-14 fw-semibold mb-1">Platinum</h6>
                                <p class="fs-13">56 Members</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-sm bg-info">5%</span>
                            <p class="fs-13">$27,999</p>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-light btn-sm w-100 mt-3">Detailed Analytics</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4 d-flex flex-column">
            <div class="card d-flex">
                <div class="card-body flex-fill">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1">Network Growth</p>
                            <h6 class="fs-16 fw-semibold">25%</h6>
                        </div>
                        <div>
                            <h6 class="fs-14 fw-semibold mb-1">245 <i
                                    class="isax isax-arrow-circle-up4 text-success"></i></h6>
                            <p class="fs-13">This Month</p>
                        </div>
                    </div>
                </div>
                <div id="network_growth"></div>
            </div>

            <div class="card d-flex mt-3">
                <div class="card-body flex-fill">
                    <h6 class="mb-3">Commission Distribution</h6>
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-3">
                        <p class="d-flex align-items-center fs-13 text-dark mb-0">
                            <i class="fa-solid fa-circle fs-8 me-1 text-primary"></i>Direct Commission
                        </p>
                        <p class="d-flex align-items-center fs-13 text-dark mb-0">
                            <i class="fa-solid fa-circle fs-8 me-1 text-success"></i>Level 1
                        </p>
                        <p class="d-flex align-items-center fs-13 text-dark mb-0">
                            <i class="fa-solid fa-circle fs-8 me-1 text-warning"></i>Level 2
                        </p>
                    </div>
                    <div id="commission_distribution"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

</div>
<!-- End Content -->

@endsection

@push('scripts')
<script>
    // Commission Chart
    var commissionOptions = {
        series: [{
            name: 'Direct Commission',
            data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
        }, {
            name: 'Team Commission',
            data: [23, 12, 54, 61, 32, 45, 41, 65, 89]
        }],
        chart: {
            height: 200,
            type: 'area',
            toolbar: {
                show: false
            }
        },
        colors: ['#0d6efd', '#198754'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
        },
        tooltip: {
            x: {
                format: 'MMM'
            }
        }
    };

    var commissionChart = new ApexCharts(document.querySelector("#commission_chart"), commissionOptions);
    commissionChart.render();

    // Network Growth Chart
    var networkOptions = {
        series: [{
            name: 'Members',
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
        }],
        chart: {
            height: 100,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        colors: ['#0d6efd'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        grid: {
            show: false
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            labels: {
                show: false
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            show: false
        }
    };

    var networkChart = new ApexCharts(document.querySelector("#network_growth"), networkOptions);
    networkChart.render();

    // Commission Distribution Chart
    var distributionOptions = {
        series: [50, 30, 20],
        chart: {
            height: 150,
            type: 'donut',
        },
        colors: ['#0d6efd', '#198754', '#ffc107'],
        labels: ['Direct', 'Level 1', 'Level 2'],
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%'
                }
            }
        }
    };

    var distributionChart = new ApexCharts(document.querySelector("#commission_distribution"), distributionOptions);
    distributionChart.render();
</script>
@endpush