@extends('layouts.admin')

@section('content')
<!-- Start Content -->
<div class="content content-two">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>📦 Your Estimate List</h6>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
						
                        <div>
							<a href="{{route('orders.create')}}" class="btn btn-primary d-flex align-items-center">
								<i class="isax isax-add-circle5 me-1"></i>Create Estimate
							</a>
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
                                <th class="no-sort">Image</th>
								<th class="no-sort">Order No</th>
								<th>Date</th>
								<th>Name</th>
                                <th class="no-sort"	>Pcs</th>
                                <th class="no-sort"	>Weight</th>
                                 <th class="no-sort">Amount</th>
								<th class="no-sort"	>Status</th>
								<th class="no-sort"></th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
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
            "columns": [{
                    "data": "checkbox",
                    "orderable": false
                },
                 {
                    "data": "image",
                    "orderable": false
                },
                {
                    "data": "order_no",
                    "orderable": false
                },
                {
                    "data": "date"
                },
                {
                    "data": "name"
                },
               {
                    "data": "pcs",
                    "orderable": false
                },
                 {
                    "data": "weight",
                    "orderable": false
                },
                {
                    "data": "amount",
                    "orderable": false
                },
               
                {
                    "data": "delivery_status",
                    "orderable": false
                },
                
                {
                    "data": "actions",
                    "orderable": false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).find('td:eq(9)').addClass('action-item');
            },
            initComplete: function(settings, json) {
                $('.dataTables_filter').appendTo('#tableSearch');
                $('.dataTables_filter').appendTo('.search-input');
            },
            "ajax": {
                "url": "{{ route('estimate.list') }}",
                "type": "GET",
                "data": function(d) {
                  
                    // Prepare request data according to API structure
                    return {
                       
                        userid: 0, // Will be set in controller
                        page: d.start / d.length,
                        count: d.length,
                        
                    };
                },
                "dataSrc": function(json) {
                    if (json.success) {
                        // Format the data for DataTables
                        var data = json.data.map(function(order) {
                            var imageUrl = "{{ get('image_url') }}";
                             var viewurl =
                                "{{ route('estimate.view', ['order' => '__ID__']) }}";
                            var orderViewUrl = viewurl.replace('__ID__', order
                                .orderid); // Replace the placeholder with the actual order ID
                              
                                var status = '';
switch(order.delivery_status) {
    case 'Estimate':
        status = '<span class="badge badge-soft-info  d-inline-flex align-items-center">Estimate <i class="isax isax-loader ms-1"></i></span>';
        break;
    case 'Order':
        status = '<span class="badge badge-soft-success d-inline-flex align-items-center">Ordered <i class="isax isax-tick-circle ms-1"></i></span>';
        break;
    case 'Shipped':
        status = '<span class="badge badge-soft-info d-inline-flex align-items-center">Shipped <i class="isax isax-truck ms-1"></i></span>';
        break;
    case 'Cancelled':
        status = '<span class="badge badge-soft-danger d-inline-flex align-items-center">Cancelled <i class="isax isax-close-circle ms-1"></i></span>';
        break;
    case 'Processing':
        status = '<span class="badge badge-soft-primary d-inline-flex align-items-center">Processing <i class="isax isax-loader ms-1"></i></span>';
        break;
    default:
        status = '<span class="badge badge-soft-secondary d-inline-flex align-items-center">Unknown</span>';
        break;
}

                             
                            return {
                                "checkbox": '<div class="form-check form-check-md"><input class="form-check-input row-checkbox" type="checkbox" value="' +
                                    order.orderid + '"></div>',
                                    "image": order.image ? '<img src="' + imageUrl + '/' +
                                    order.image + '" width="50" height="50" alt="' +
                                    order.name + '">' : 'No Image',
                                "order_no":'<a href="' + orderViewUrl +
                                    '" target="_blank">' + order.order_no + '</a>',
                                "date": order.date,
                                "name": '<a href="' + orderViewUrl +
                                    '" target="_blank">' + order.name + '</a>',
                                "pcs": order.pcs,
                                 "weight": order.weight,
                                "amount": order.currency + '' + parseFloat(order
                                    .amount).toFixed(2),
                                "delivery_status":status,
                                "actions": '<a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="isax isax-more"></i></a><ul class="dropdown-menu"><li><a href="' +
                                    orderViewUrl +
                                    '" class="dropdown-item d-flex align-items-center"><i class="isax isax-eye me-2 me-2"></i>Estimate detail</a></li></ul>'

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
    });
    </script>

 @endpush           