@extends('layouts.admin')

@section('content')
    <!-- Start Content -->
    <div class="content content-two">

        <!-- Page Header -->
        <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <div>
                <h6>Members</h6>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('members.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="isax isax-add-circle5 me-1"></i>New Member
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Table Search Start -->
        <div class="mb-3">
            <form id="filter-form" method="GET" action="{{ route('members.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label for="search_text">Search</label>
                        <input type="text" name="search_text" id="search-input" class="form-control"
                            value="{{ old('search_text') }}" placeholder="Search by name, email, mobile">
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
                        </select>
                    </div>
                </div>
                <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <button type="button" id="reset-filters" class="btn btn-secondary">Reset</button>
                </div>
            </form>

        </div>
        <!-- Table Search End -->

        <!-- Table List -->
        <div class="table-responsive customer-table_wrapper">
            <table id="member-table" class="table table-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" type="checkbox" id="select-all">
                            </div>
                        </th>
                        <th>Member</th>
                         <th>Member ID</th> <!-- Add this column -->
        <th>Sponsor</th>   <!-- Add this column -->
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
            // Initialize DataTable
            var table = $('#member-table').DataTable({
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
                ajax: {
                    url: "{{ route('members.index') }}",
                    type: 'GET',
                    data: function(d) {
                        d.search_text = $('#search-input').val();
                        d.type = '{{ $type }}';
                        d.countryid = $('#countryid').val();
                        d.regionid = $('#regionid').val();
                    }
                },
                columns: [{
                        data: 'checkbox',
                        orderable: false
                    },
                    {
                        data: 'member'
                    },
                    { data: 'member_id' }, // Add this
    { data: 'sponsor' },   // Add this
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
                        data: 'actions',
                        orderable: false
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(6)').addClass('action-item');
                },
            });
            // Select all checkbox
            $('#select-all').on('change', function() {
                $('input[type="checkbox"]').prop('checked', this.checked);
            });
                // Bulk approve for pending members
            $('#bulk-approve').on('click', function() {
                var selectedIds = [];
                $('input[type="checkbox"]:checked').each(function() {
                    if ($(this).val()) {
                        selectedIds.push($(this).val());
                    }
                });

                if (selectedIds.length === 0) {
                    alert('Please select at least one member to approve.');
                    return;
                }

                if (confirm('Are you sure you want to approve ' + selectedIds.length + ' member(s)?')) {
                    $.ajax({
                        url: "{{ route('members.bulk.approve') }}",
                        type: 'POST',
                        data: {
                            ids: selectedIds
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                showSuccess(response.message);
                                table.ajax.reload();
                                $('#select-all').prop('checked', false);
                            } else {
                                showError(response.message);
                            }
                        },
                        error: function() {
                            showError('Failed to approve members');
                        }
                    });
                }
            });


            // Filters trigger reload
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            // Reset filters
            $('#reset-filters').on('click', function() {
                $('#search-input').val('');
                $('#countryid').val('');
                $('#regionid').val('');
                table.ajax.reload();
            });

            // Load regions based on country
             $('#country_list').change(function() {
             var countryId = $(this).val();

             $.ajax({
                 url: '{{ route('getstates', ['countryId' => '%country%']) }}'.replace('%country%',
                     countryId),
                 type: 'GET',
                 success: function(response) {
                     $('#state_list').html('<option value="">Select</option>');

                     for (var i = 0; i < response.states.length; i++) {
                         $('#state_list').append('<option value="' + response.states[i].id + '">' +
                             response.states[i].name + '</option>');
                     }

                     $('#regionid').trigger('change');
                 }
             });
         });
        });

        // Delete member function
       // Toggle member status (activate/deactivate)
        function toggleStatus(id, status) {
            var action = status === 'active' ? 'activate' : 'deactivate';
            if (confirm('Are you sure you want to ' + action + ' this member?')) {
                $.ajax({
                    url: "{{ url('admin/members') }}/" + id + "/status",
                    type: 'PUT',
                    data: {
                        status: status
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            $('#member-table').DataTable().ajax.reload();
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function() {
                        showError('Failed to update status');
                    }
                });
            }
        }

        // Approve single pending member
        $(document).on('click', '.btn-approve', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to approve this member?')) {
                $.ajax({
                    url: "{{ url('admin/members') }}/" + id + "/approve",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            $('#member-table').DataTable().ajax.reload();
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function() {
                        showError('Failed to approve member');
                    }
                });
            }
        });

        // Reject pending member
        $(document).on('click', '.btn-reject', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to reject this member?')) {
                $.ajax({
                    url: "{{ url('admin/members') }}/" + id + "/reject",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            $('#member-table').DataTable().ajax.reload();
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function() {
                        showError('Failed to reject member');
                    }
                });
            }
        });

        // Delete member function
        function deleteMember(id) {
            if (confirm('Are you sure you want to delete this member?')) {
                $.ajax({
                    url: "{{ url('admin/members') }}/" + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            $('#member-table').DataTable().ajax.reload();
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function() {
                        showError('Failed to delete member');
                    }
                });
            }
        }
        function copyReferralLink(link) {
    navigator.clipboard.writeText(link).then(() => {
        toastr.success('Referral link copied!');
    });
}

function shareReferralLink(link) {
    if (navigator.share) {
        navigator.share({
            title: 'Join using my referral',
            url: link
        });
    } else {
        copyReferralLink(link);
    }
}

    </script>
@endpush