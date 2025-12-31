@extends('layouts.admin')

@section('content')
    <!-- Start Content -->
    <div class="content content-two">

        <!-- Page Header -->
        <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <div>
                <h6>Customers</h6>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <!--<div class="dropdown">
                    <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        <i class="isax isax-export-1 me-1"></i>Export
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#">Download as PDF</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Download as Excel</a>
                        </li>
                    </ul>
                </div>-->
                <div>
                    <a href="{{ route('customers.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="isax isax-add-circle5 me-1"></i>New Customer
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Table Search Start -->
        <div class="mb-3">
            <form id="filter-form" method="GET" action="{{ route('customers') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label for="search_text">Search</label>
                        <input type="text" name="search_text" id="search-input" class="form-control"
                            value="{{ old('search_text') }}" placeholder="Search by name">
                    </div>
                    <div class="col-md-3">
                        <label for="countryid">Country</label>
                        <select name="countryid" class="form-control" id="countryid">
                            <option value="">Select Country</option>
                            @foreach ($countries as $c)
                                <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="regionid">Region</label>
                        <select name="regionid" class="form-control" id="regionid">
                            <option value="">Select Region</option>
                            <!-- Populate region options -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="characters">Characters</label>
                        <input type="text" name="characters" class="form-control" value="{{ old('characters') }}"
                            id="characters" placeholder="Filter by characters">
                    </div>
                </div>
                <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>

        </div>
        <!-- Table Search End -->

        <!-- Table List -->
        <div class="table-responsive customer-table_wrapper">
            <table id="customer-table" class="table table-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" type="checkbox" id="select-all">
                            </div>
                        </th>
                        <th>Customer</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- The rows will be populated dynamically via AJAX -->
                </tbody>
            </table>
        </div>
        <!-- /Table List -->

    </div>
    <!-- End Content -->
@endsection
@push('scripts')
    <script>
     $(document).ready(function() {
    // Initialize DataTable with proper pagination
    var table = $('#customer-table').DataTable({
        processing: true,
        serverSide: true,
        bFilter: true,
        sDom: 'fBtlpi',
        ordering: true,
        paging: true,
        pageLength: 50,
        language: {
            search: ' ',
            searchPlaceholder: "Search",
            sLengthMenu: 'Row Per Page _MENU_ Entries',
            info: "_START_ - _END_ of _TOTAL_ items",
             paginate: {
                    next: '<i class="isax isax-arrow-right-1"></i>',
                    previous: '<i class="isax isax-arrow-left"></i>'
                }
        },
        scrollX: false,
        scrollCollapse: false,
        responsive: false,
        autoWidth: false,
        initComplete: (settings, json) => {
            $('.dataTables_filter').appendTo('#tableSearch');
            $('.dataTables_filter').appendTo('.search-input');
        },
        ajax: {
            url: "{{ route('customers') }}",
            type: 'GET',
            data: function(d) {
                // Add custom filters to DataTables request
                d.search_text = $('#search-input').val();
                d.countryid = $('#countryid').val();
                d.regionid = $('#regionid').val();
                d.characters = $('#characters').val();
                
                // Convert DataTables parameters to match your API
                d.start = d.start;
                d.length = d.length;
                d.draw = d.draw;
                
                // Remove DataTables parameters that might conflict
                delete d._;
            }
        },
        columns: [{
                data: 'checkbox',
                orderable: false
            },
            {
                data: 'customer'
            },
            {
                data: 'mobile'
            },
            {
                data: 'email'
            },
             {
                data: 'country'
            },
            {
                data: 'status',
                orderable: false
            },
            {
                data: 'actions'
            }
        ],
        createdRow: function(row, data, dataIndex) {
            $(row).find('td:eq(5)').addClass('action-item');
        },
    });

    // Remove the Load More button if it exists
    $('#loadMore').remove();

    // Filters trigger reload
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });
});
    </script>
@endpush
