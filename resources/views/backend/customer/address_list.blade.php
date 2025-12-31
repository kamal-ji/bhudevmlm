@extends('layouts.admin')

@section('content')
<!-- Start Content -->
<div class="content content-two">
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>📦 Your Address List</h6>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
						
                        <div>
							<a href="{{route('customers.address.create',['customer' => $id])}}" class="btn btn-primary d-flex align-items-center">
								<i class="isax isax-add-circle5 me-1"></i>Add Address
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
                                
								<th class="no-sort"	>Address</th>
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
                    "data": "address",
                    "orderable": false
                },
                
                {
                    "data": "actions",
                    "orderable": false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).find('td:eq(2)').addClass('action-item');
            },
            initComplete: function(settings, json) {
                $('.dataTables_filter').appendTo('#tableSearch');
                $('.dataTables_filter').appendTo('.search-input');
            },
            "ajax": {
                "url": "{{ route('customers.address_list', ['customer' => $id]) }}",
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
                        var data = json.data.map(function(addressdata) {
                            var imageUrl = "{{ get('image_url') }}";
                            var customerid="{{$id}}";
                             var viewurl =
                                "{{ route('customers.address.edit', ['customer' => '__CUSID__', 'address' => '__ID__']) }}";
                            var orderViewUrl = viewurl.replace('__CUSID__', customerid).replace('__ID__', addressdata.id); // Replace the placeholder with the actual order ID
                              
               

                             
                            return {
                                "checkbox": '<div class="form-check form-check-md"><input class="form-check-input row-checkbox" type="checkbox" value="' +
                                    addressdata.id + '"></div>',
                                "address": addressdata.address,
                                "actions": '<a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="isax isax-more"></i></a><ul class="dropdown-menu"><li><a href="' +
                                    orderViewUrl +
                                    '" class="dropdown-item d-flex align-items-center"><i class="isax isax-edit me-2"></i>Edit</a></li></ul>'

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