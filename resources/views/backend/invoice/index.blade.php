@extends('layouts.admin')

@section('content')
<!-- Start Content -->
<div class="content content-two">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>🧾 Invoices List</h6>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
            <!-- Date Range Filter -->
            <div class="d-flex align-items-center gap-2">
                <input type="date" id="start_date" class="form-control form-control-sm" placeholder="Start Date">
                <span>to</span>
                <input type="date" id="end_date" class="form-control form-control-sm" placeholder="End Date">
                <button type="button" id="apply-date-filter" class="btn btn-primary btn-sm">Apply</button>
                <button type="button" id="clear-date-filter" class="btn btn-outline-secondary btn-sm">Clear</button>
            </div>
        </div>
    </div>

    <!-- Table List -->
    <div class="table-responsive">
        <table class="table table-nowrap datatable">
            <thead class="thead-light">
                <tr>
                    <th class="no-sort">
                        <div class="form-check form-check-md">
                            <input class="form-check-input" type="checkbox" id="select-all">
                        </div>
                    </th>
                    <th>Name</th>
                    <th class="no-sort">Invoice No</th>
                    <th>Date</th>
                    <th class="no-sort">Due Date</th>
                    <th class="no-sort">Amount</th>
                    <th class="no-sort">Status</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <!-- /Table List -->
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('.datatable').DataTable({
       "processing": true,
            "serverSide": true,
            "searching": false,
            "bFilter": true,
            "sDom": 'fBtlpi',
            "ordering": true,
            "paging": true,
            "pageLength": 50,
        "language": {
            search: ' ',
            sLengthMenu: '_MENU_',
            searchPlaceholder: "Search",
            sLengthMenu: 'Row Per Page _MENU_ Entries',
            info: "_START_ - _END_ of _TOTAL_ items",
            paginate: {
                next: '<i class="isax isax-arrow-right-1"></i>',
                previous: '<i class="isax isax-arrow-left"></i>'
            },
        },
        "scrollX": false,
        "scrollCollapse": false,
        "responsive": false,
        "autoWidth": false,
        "columns": [
            {"data": "checkbox", "orderable": false},
            {"data": "name", "orderable": false},
            {"data": "invoice_no", "orderable": false},
            {"data": "date"},
            {"data": "due_date","orderable": false},
            {"data": "amount", "orderable": false},
            {"data": "status", "orderable": false},
            {"data": "actions", "orderable": false}
        ],
        createdRow: function(row, data, dataIndex) {
            $(row).find('td:eq(7)').addClass('action-item');
        },
        initComplete: function(settings, json) {
            $('.dataTables_filter').appendTo('#tableSearch');
            $('.dataTables_filter').appendTo('.search-input');
        },
        "ajax": {
            "url": "{{ route('invoices') }}",
            "type": "GET",
            "data": function(d) {
                // Get date filter values
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
              
                // Prepare request data according to API structure
                return {
                    userid: 0, // Will be set in controller
                    page: d.start / d.length+1,
                    count: d.length,
                    start_date: startDate,
                    end_date: endDate,
                    search: d.search.value,
                    draw: d.draw,
                    start: d.start,
                    length: d.length 
                };
            },
            "dataSrc": function(json) {
                if (json.success) {
                    // Format the data for DataTables
                    var data = json.data.map(function(order) {
                        var status = '';
                        switch (order.status) {
                            case 'Paid':
                                status = '<span class="badge badge-soft-success d-inline-flex align-items-center">'+order.status+' <i class="isax isax-tick-circle ms-1"></i></span>';
                                break;
                            case 'Unpaid':
                                status = '<span class="badge badge-soft-danger d-inline-flex align-items-center">'+order.status+'  <i class="isax isax-close-circle ms-1"></i></span>';
                                break;
                             case 'Partial_paid':
                                status = '<span class="badge badge-soft-info d-inline-flex align-items-center">Partial paid  <i class="isax isax-close-circle ms-1"></i></span>';
                                break;    
                            default:
                                status = '<span class="badge badge-soft-secondary d-inline-flex align-items-center">Unknown</span>';
                                break;
                        }

                        return {
                            "checkbox": '<div class="form-check form-check-md"><input class="form-check-input row-checkbox" type="checkbox" value="' + order.invoiceid + '"></div>',
                            "name": '<a href="" target="_blank">' + order.name + '</a>',
                            "invoice_no": '<a href="" target="_blank">' + order.invoice_no + '</a>',
                            "date": order.date,
                            "due_date": order.due_date,
                            "amount": order.currency + '' + parseFloat(order.amount).toFixed(2),
                            "status": status,
                            "actions": ''
                        };
                    });

                    return data;
                } else {
                    console.error('Error loading data:', json.message);
                    return [];
                }
            }
        }
    });

    // Apply date filter
    $('#apply-date-filter').on('click', function() {
        table.ajax.reload();
    });

    // Clear date filter
    $('#clear-date-filter').on('click', function() {
        $('#start_date').val('');
        $('#end_date').val('');
        table.ajax.reload();
    });

    // Auto-apply filter when dates change (optional)
    $('#start_date, #end_date').on('change', function() {
        table.ajax.reload();
    });
});
</script>
@endpush