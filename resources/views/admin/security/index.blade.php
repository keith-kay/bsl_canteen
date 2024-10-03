@extends('layouts.admin')

@section('title')
Admin | Tickets
@stop

@section('report')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container my-3">
    <style>
        .ajs-success {
            background-color: #4CAF50;
            color: #ffffff;
        }

        .colored-toast.swal2-icon-success {
            background-color: #28a745 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .colored-toast.swal2-icon-warning {
            background-color: #f8bb86 !important;
        }

        .colored-toast.swal2-icon-info {
            background-color: #3fc3ee !important;
        }

        .colored-toast.swal2-icon-question {
            background-color: #87adbd !important;
        }

        .colored-toast .swal2-title {
            color: white;
        }

        .colored-toast .swal2-close {
            color: white;
        }

        .colored-toast .swal2-html-container {
            color: white;
        }
    </style>
    @if(session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        (async () => {
            await Toast.fire({
                icon: 'success',
                title: "{{session('success')}}",
            })
        })()
    </script>
    @elseif(session('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        (async () => {
            await Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}",
            })
        })();
    </script>
    @endif
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tickets</h5>
            
            

            <!-- Meal Type filtering options -->
            <div class="form-group row mt-3">
    
    <div class="col-sm-3">
        <label class="col-form-label fw-bold">Site:</label>
        <select class="form-select" id="site-select">
            <option value="">Select a site</option>
        </select>
    </div>
</div>
@if(auth()->user()->hasRole('security') || auth()->user()->hasRole('super-admin'))
<div class="form-group row mt-3 mb-2">
    <div class="col-sm-12 text-end"> <!-- Align the button to the right -->
        <a class="btn btn-success print-btn print-btn">Print</a>
    </div>
</div>
@endif


<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tickets</h5>

            <!-- Your existing filter options and other form elements remain unchanged -->

            <style>
                .hide-id {
                    display: none; /* Hides the column */
                }
            </style>
            
            <table id="reports-table" class="table table-border-less table-striped my-3">
                <input type="text" id="custom-search" placeholder="Search...">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Staff No</th>
                        <th>Company</th>
                        <th>Department</th>
                        <th>Meal Type</th>
                        <th>Timestamp</th>
                        <th class="hide-id">Id</th> <!-- Moved the Id column here -->
                       
                        <th>
                            <input type="checkbox" id="select-all" /> Select All
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->bsl_cmn_users_firstname }} {{ $user->bsl_cmn_users_lastname }}</td>
                        <td>{{ $user->bsl_cmn_users_employment_number }}</td>
                        <td>{{ $user->userType->bsl_cmn_user_types_name }}</td>
                        <td>{{ $user->bsl_cmn_users_department }}</td>
                        <td>Food</td>
                        <td>{{ date('Y-m-d H:i:s') }}</td>
                        <td class="hide-id">{{ $user->bsl_cmn_users_id }}</td> <!-- Hidden ID column -->
                        <td>
                            <input type="checkbox" class="user-checkbox" value="{{ $user->bsl_cmn_users_id }}" />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            
        </div>
    </div>
</div>

        </div>
    </div>
</div>
@stop

@section('scripts')
<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script>
    function displayTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        document.getElementById("currentTime").innerHTML = timeString;
    }

    // Display time when the page loads
    displayTime();
    
    // Update the time every second
    setInterval(displayTime, 1000);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>

<script>
    
    console.log("Request URL: ", "{{ route('get.sites') }}");
    
    $(document).ready(function() {
        var table = $('#reports-table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 10 // Display 10 rows per page
        });

        $('#custom-search').on('keyup', function() {
            table.search(this.value).draw();  // Perform a search and redraw the table
        });

        // Select all checkboxes when "Select All" is clicked
        $('#select-all').on('click', function() {
            var checked = $(this).prop('checked');
            $('.user-checkbox').prop('checked', checked);
        });

        // If any checkbox is unchecked, uncheck the "Select All" checkbox
        $(document).on('change', '.user-checkbox', function() {
            if (!$(this).prop('checked')) {
                $('#select-all').prop('checked', false);
            }
        });

        
        // Fetch and populate the site dropdown without triggering a filter
        $.ajax({
            url: "{{ route('get.sites') }}",
            method: 'GET',
            success: function(data) {
                var siteSelect = $('#site-select');
                
                siteSelect.empty();
                siteSelect.append('<option value="">Select a site</option>');
                
                $.each(data, function(index, site) {
                    // Use site.id as the value and site.bsl_cmn_sites_name as the text
                    siteSelect.append('<option value="' + site.bsl_cmn_sites_id + '">' + site.bsl_cmn_sites_name + '</option>');
                });
            }
        });

    

               
        $('.print-btn').on('click', function() {
            var selectedSiteId = $('#site-select').val(); // Get selected site ID
            var ticketsToPrint = [];

            // Collect data from checked rows in the DataTable
            table.rows({ search: 'applied' }).every(function() {
                var data = this.data();
                var checkbox = $(this.node()).find('.user-checkbox'); // Use 'user-checkbox' class

                if (checkbox.is(':checked')) {
                    ticketsToPrint.push({
                        name: data[0], // User's name
                        staffNo: data[1],
                        company: data[2],
                        site: selectedSiteId,
                        department: data[3], // Ensure the correct index
                        mealType: data[4], // Ensure the correct index
                        timestamp: data[5], // Ensure the correct index
                        userId: data[6]
                    });
                }
            });

            console.log("Tickets to Print: ", ticketsToPrint);
            console.log("Selected Site ID: ", selectedSiteId);

            // Send data to the controller for processing
            $.ajax({
                url: "{{ route('log.ticket') }}",
                method: 'POST',
                data: {
                    tickets: ticketsToPrint, // ticketsToPrint.length > 0 ? ticketsToPrint : [],
                    site_id: selectedSiteId, // selectedSiteId ? parseInt(selectedSiteId) : null,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
		    console.log(response);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Print Successful!',
                            text: response.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Print Failed!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    console.error("AJAX Error:", xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred',
                        text: xhr.responseJSON?.message || 'Please try again later.'
                    });
                }
            });
        });


        // Hide DataTable search input
        $('.dataTables_filter').hide();
    });
</script>


@stop