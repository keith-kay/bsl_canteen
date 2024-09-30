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
            <!-- Filter and Reset buttons -->
            <div class="form-group row">
                <div class="col-md-6">
                    <button id="export-btn" class="btn btn-nav fw-bold">Export to Excel</button>
                </div>
            </div>
            <!-- Filter and Reset buttons -->
            <div class="form-group row mt-3">
                <div class="col-sm-6">
                    <button id="filter-btn" class="btn btn-nav fw-bold">Filter</button>
                    <button id="reset-btn" class="btn btn-danger">Reset</button>
                </div>
            </div>

            <!-- Date filtering options -->
            <div class="form-group row mt-3">
                <label for="from_date" class="col-sm-2 col-form-label fw-bold">From:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="from_date">
                </div>
                <label for="to_date" class="col-sm-2 col-form-label fw-bold">To:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="to_date">
                </div>
            </div>

            <!-- Meal Type filtering options -->
            <div class="form-group row mt-3">
    <div class="col-sm-3">
        <label class="col-form-label fw-bold">Meal Type:</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input meal-type-checkbox" type="checkbox" id="tea" value="Tea">
                <label class="form-check-label" for="tea">Tea</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input meal-type-checkbox" type="checkbox" id="lunch" value="Food">
                <label class="form-check-label" for="lunch">Food</label>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <label class="col-form-label fw-bold">Company:</label>
        <select class="form-select" id="company-select">
            <option value="">Select a company</option>
        </select>
    </div>
    <div class="col-sm-3">
        <label class="col-form-label fw-bold">Department:</label>
        <select class="form-select" id="department-select">
            <option value="">Select a department</option>
        </select>
    </div>
    <div class="col-sm-3">
        <label class="col-form-label fw-bold">Site:</label>
        <select class="form-select" id="site-select">
            <option value="">Select a site</option>
        </select>
    </div>
</div>
@if(auth()->user()->hasRole('security') || auth()->user()->hasRole('super-admin'))
<div class="form-group row mt-3">
    <div class="col-sm-12 text-end"> <!-- Align the button to the right -->
        <a class="btn btn-success print-btn print-btn">Print</a>
    </div>
</div>
@endif


            <table id="reports-table" class="table table-border-less table-striped my-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Staff No</th>
                        <th>Company</th>
                        <th>Site</th>
                        <th>Department</th>
                        <th>Meal Type</th>
                        <th>Timestamp</th>
                        @if(auth()->user()->hasRole('super-admin'))
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr data-user-id="{{ $log->user->bsl_cmn_users_id }}">
                        <td>{{ $log->user->bsl_cmn_users_firstname }} {{ $log->user->bsl_cmn_users_lastname }}</td>
                        <td>{{ $log->user->bsl_cmn_users_employment_number }}</td>
                        <td>{{ $log->user->userType->bsl_cmn_user_types_name }}</td>
                        <td>{{ $log->site ? $log->site->bsl_cmn_sites_name : 'No site available' }}</td>
                        <td>{{$log->user->bsl_cmn_users_department}}</td>
                        <td>{{ $log->mealType->bsl_cmn_mealtypes_mealname }}</td>
                        <td>{{ $log->bsl_cmn_logs_time }}</td>
                        @if(auth()->user()->hasRole('super-admin'))
                        <td style="white-space: nowrap;">
                            <div class="row">
                                <div class="col mb-1">
                                    <a class="btn btn-success print-btn">Print</a>
                                </div>
                                <div class="col">
                                    <a href="{{ url('logs/'.$log->bsl_cmn_logs_id.'/delete') }}"
                                        class="btn btn-danger btn-block">Delete</a>
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
<!-- <script>
    console.log("AJAX request fired");
    $.ajax({
        url: "{{ route('get.companies') }}",
        method: 'GET',
        success: function(data) {
            console.log(data);
            var companySelect = $('#company-select');
            companySelect.empty();
            companySelect.append('<option value="">Select a company</option>');
            $.each(data, function(index, value) {
                companySelect.append('<option value="' + value + '">' + value + '</option>');
            });
        }
});

</script> -->
<script>
    var requestUrl = "{{ route('get.companies') }}";
    console.log("Request URL: ", requestUrl);
    
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

        // Fetch and populate the company dropdown
        $.ajax({
            url: "{{ route('get.companies') }}",
            method: 'GET',
            success: function(data) {
                console.log(data);
                var companySelect = $('#company-select');
                companySelect.empty();
                companySelect.append('<option value="">Select a company</option>');
                $.each(data, function(index, value) {
                    companySelect.append('<option value="' + value + '">' + value + '</option>');
                });
            }
        });

        // Fetch and populate the sites dropdown
        $.ajax({
            url: "{{ route('get.sites') }}",
            method: 'GET',
            success: function(data) {
                var siteSelect = $('#site-select');
                siteSelect.empty();
                siteSelect.append('<option value="">Select a site</option>');
                $.each(data, function(index, value) {
                    siteSelect.append('<option value="' + value + '">' + value + '</option>');
                });
            }
        });

        // Fetch and populate the department dropdown
        $.ajax({
            url: "{{ route('get.department') }}",
            method: 'GET',
            success: function(data) {
                var departmentSelect = $('#department-select');
                departmentSelect.empty();
                departmentSelect.append('<option value="">Select a department</option>');
                $.each(data, function(index, value) {
                    departmentSelect.append('<option value="' + value + '">' + value + '</option>');
                });
            }
        });

        // Function to filter table based on date range, meal types, and selected company
        function applyFilters() {
            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var selectedMealTypes = $('.meal-type-checkbox:checked').map(function() {
                return this.value;
            }).get();
            var selectedCompany = $('#company-select').val(); 
            var selectedSite = $('#site-select').val();
            var selectedDepartment = $('#department-select').val();

            table.draw(); // Redraw the table with new filters
        }

        // Filter button click event handler
        $('#filter-btn').on('click', function() {
            applyFilters();
        });

        // Reset button click event handler
        $('#reset-btn').on('click', function() {
            $('#from_date').val('');
            $('#to_date').val('');
            $('.meal-type-checkbox').prop('checked', false);
            $('#company-select').val('');
            $('#site-select').val('');
            $('#department-select').val('');
            table.draw(); // Redraw the table to reset filters
        });

        // Company, site, and department dropdown change event handlers
        $('#company-select, #site-select, #department-select').on('change', function() {
            applyFilters();
        });

        // Export button click event handler
        $('#export-btn').on('click', function(event) {
            event.preventDefault();
            exportDataToExcel();
        });

        // Print button click event handler
        $('.print-btn').on('click', function() {
            var ticketsToPrint = [];
            
            // Collect data from visible rows in the DataTable
            table.rows({ search: 'applied' }).every(function() {
                var data = this.data();
                ticketsToPrint.push({
                    name: data[0],
                    staffNo: data[1],
                    company: data[2],
                    site: data[3],
                    department: data[4],
                    mealType: data[5],
                    timestamp: data[6]
                });
            });

            // Log the tickets to be printed for debugging
            console.log("Tickets to Print: ", ticketsToPrint);

            // Send the collected data to the server for printing
            $.ajax({
                url: "{{ route('print.tickets') }}", // Update this with your actual route
                method: 'POST',
                data: {
                    tickets: ticketsToPrint,
                    _token: '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(response) {
                    // Handle success (e.g., show success message, redirect, etc.)
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
                    // Enhanced error logging
                    console.log(xhr); // Log the full response for inspection
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                        ? xhr.responseJSON.message 
                        : 'An error occurred while trying to print.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage
                    });
                }
            });
        });

        // Function to export data to Excel
        function exportDataToExcel() {
            var filteredData = [];
            table.rows({ search: 'applied' }).every(function() {
                filteredData.push(this.data());
            });

            var columnHeaders = table.columns().header().toArray().map(function(header) {
                return $(header).text().trim();
            });

            var exportData = [columnHeaders];
            filteredData.forEach(function(rowData) {
                var rowDataTrimmed = rowData.map(function(cellData) {
                    return cellData.trim();
                });
                exportData.push(rowDataTrimmed);
            });

            var ws = XLSX.utils.aoa_to_sheet(exportData);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'FilteredReportData');
            XLSX.writeFile(wb, 'MealTicketsReport_data.xlsx');
        }

        // Apply custom filtering function
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var logDate = data[6];
            var mealType = data[5];
            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var selectedMealTypes = $('.meal-type-checkbox:checked').map(function() {
                return this.value;
            }).get();
            var selectedCompany = $('#company-select').val();
            var selectedSite = $('#site-select').val();
            var selectedDepartment = $('#department-select').val();

            if (fromDate && toDate && (logDate < fromDate || logDate > toDate)) return false;
            if (selectedMealTypes.length > 0 && !selectedMealTypes.includes(mealType)) return false;
            if (selectedCompany && data[2] !== selectedCompany) return false;
            if (selectedSite && data[3] !== selectedSite) return false;
            if (selectedDepartment && data[4] !== selectedDepartment) return false;

            return true;
        });

        // Hide DataTable search input
        $('.dataTables_filter').hide();
    });
</script>

<!-- <script>
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

        // Print Button Click Event
        $('#reports-table').on('click', '.print-btn', function() {
            // Extract user ID from the data attribute of the table row
            var userId = $(this).closest('tr').data('user-id');

            // Send the data in a POST request to the printTicket endpoint
            $.ajax({
                url: '{{ route("print.ticket") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    userid: userId
                },
                success: function(response) {
                    console.log('Printing initiated:', response);
                    // Optionally, you can handle the response here
                },
                error: function(xhr, status, error) {
                    console.error('Error printing:', error);
                    // Optionally, you can handle errors here
                }
            });
        });
    });
</script> -->
@stop