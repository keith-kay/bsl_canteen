@extends('layouts.admin')

@section('title')
Admin | Reports
@stop


@section('report')
<style>
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 20px;
}

#reports-table thead {
    border-top: 1px solid #dee2e6 !important;
}
</style>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Reports</h5>
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
                <label class="col-sm-2 col-form-label fw-bold">Meal Type:</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input meal-type-checkbox" type="checkbox" id="tea" value="Tea">
                        <label class="form-check-label" for="tea">Tea</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input meal-type-checkbox" type="checkbox" id="lunch" value="Meal">
                        <label class="form-check-label" for="lunch">Meal</label>
                    </div>
                </div>
            </div>

            <!-- Reports table -->
            <table id="reports-table" class="table table-borderless table-striped my-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Staff No</th>
                        <th>Company</th>
                        <th>Site</th>
                        <th>Department</th>
                        <th>Meal Type</th>
                        <th>Timestamp</th>
                        <th>Shift</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->user->bsl_cmn_users_firstname }} {{ $log->user->bsl_cmn_users_lastname }}</td>
                        <td>{{ $log->user->bsl_cmn_users_employment_number }}</td>
                        <td>{{ $log->user->userType->bsl_cmn_user_types_name }}</td>
                        <td>{{ $log->mealType->site->bsl_cmn_sites_name }}</td>
                        <td>{{$log->user->bsl_cmn_users_department}}</td>
                        <td>{{ $log->mealType->bsl_cmn_mealtypes_mealname }}</td>
                        <td>{{ $log->bsl_cmn_logs_time }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->bsl_cmn_logs_time)->format('H:i') >= '07:00' && \Carbon\Carbon::parse($log->bsl_cmn_logs_time)->format('H:i') <= '19:00' ? 'Day Shift' : 'Night Shift' }}
                        </td>
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
<script>
$(document).ready(function() {
    var table = $('#reports-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10,
    });

    // Function to filter table based on date range and meal types
    function applyFilters() {
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        var selectedMealTypes = $('.meal-type-checkbox:checked').map(function() {
            return this.value;
        }).get();

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
        table.draw(); // Redraw the table to reset filters
    });

    $('#export-btn').on('click', function(event) {
        event.preventDefault(); // Prevent the default action of the button
        exportDataToExcel();
    });

    // Function to export data to Excel
    function exportDataToExcel() {
        // Initialize the DataTable
        var table = $('#reports-table').DataTable();

        // Get filtered data (visible rows)
        var filteredData = [];
        table.rows({
            search: 'applied'
        }).every(function() {
            filteredData.push(this.data());
        });

        // Extract column headers from the DataTable
        var columnHeaders = table.columns().header().toArray().map(function(header) {
            return $(header).text().trim();
        });

        // Create export data array with column headers
        var exportData = [columnHeaders];

        // Iterate through filtered data and add to exportData array
        filteredData.forEach(function(rowData) {
            var rowDataTrimmed = rowData.map(function(cellData) {
                return cellData.trim(); // Trim whitespace from each cell data
            });
            exportData.push(rowDataTrimmed);
        });

        // Create a worksheet with the extracted data
        var ws = XLSX.utils.aoa_to_sheet(exportData);

        // Create a workbook and add the worksheet
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'FilteredReportData');

        // Save the workbook to an Excel file
        XLSX.writeFile(wb, 'MealTicketsReport_data.xlsx');
    }

    // Apply custom filtering function
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var logDate = data[6]; // Assuming date is in 7th column (index 6)
            var mealType = data[5]; // Assuming meal type is in 6th column (index 5)
            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var selectedMealTypes = $('.meal-type-checkbox:checked').map(function() {
                return this.value;
            }).get();

            // Filter by date range
            if ((fromDate !== '' && toDate !== '') && (logDate < fromDate || logDate > toDate)) {
                return false;
            }

            // Filter by meal types
            if (selectedMealTypes.length > 0 && !selectedMealTypes.includes(mealType)) {
                return false;
            }

            return true;
        }
    );

    // Hide DataTable search input
    $('.dataTables_filter').hide();
});
</script>
@stop