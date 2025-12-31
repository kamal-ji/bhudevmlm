@extends('layouts.admin')

@section('content')

   <!-- Start Content -->
    <div class="content content-two">
        <div class=" d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <div>
               <h6>💖 Your Wishlist</h6>

            </div>
             <div class="table-responsive">
                            <table id="wishlist-table" class="table table-nowrap datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="no-sort">#</th>
                                        <th class="no-sort">Product</th>
                                        <th class="no-sort">Price</th>
                                        <th class="no-sort">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
        </div>
    </div>



@endsection
@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#wishlist-table').DataTable({
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
        ajax: {
            url: "{{ route('products.wishlist') }}",
            type: "GET",
            data: function(d) {
                // You can add additional parameters here if needed
            }
        },
        columns: [
            { 
                data: 'serial',
                name: 'serial',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            { 
                data: 'product',
                name: 'product',
                orderable: false,
                searchable: true
            },
            { 
                data: 'price',
                name: 'price',
                orderable: true,
                searchable: false,
                className: 'text-end'
            },
            { 
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],
        order: [[0, 'asc']],
        language: {
            emptyTable: "No items in your wishlist",
            zeroRecords: "No matching wishlist items found",
            info: "Showing _START_ to _END_ of _TOTAL_ items",
            infoEmpty: "Showing 0 to 0 of 0 items",
            infoFiltered: "(filtered from _MAX_ total items)",
            search: "Search:",
             paginate: {
                    next: '<i class="isax isax-arrow-right-1"></i>',
                    previous: '<i class="isax isax-arrow-left"></i>'
                },
        },
        drawCallback: function(settings) {
            // Re-initialize tooltips if any
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

      $('.table').on('click', '.movecart', function ()  {
        console.log('test');
        $this = $(this);
        var item_id = $this.data('id');
        
        $.ajax({
            url: "{{ route('products.movecart') }}",
            method: "POST",
            data: {
                item_id: item_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    showSuccess(response.data.message);
                    setTimeout(() => {
                        
                        $('.wishlist-counter').text(response.data.wishlist || '0');
                        $('.cart-counter').text(response.data.cart || '0');
                        window.location.reload();
                    }, 200);
                } else {
                    showError(response.message);
                }            
            },
            error: function (xhr, status, error) {
                showError(error);
            }
        });
    });
});
</script>
@endpush