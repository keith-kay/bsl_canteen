@extends('layouts.admin')

@section('title')
Admin | Reports
@stop


@section('report')
<style>
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 20px;
    /* Adjust the margin-top value as needed */
}

#reports-table thead {
    border-top: 1px solid #dee2e6 !important;
}
</style>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Reports</h5>

            <table id="reports-table" class="table table-border-less table-striped my-3">

                <thead>
                    <div class="col-md-4 text-right mb-3">
                        <button id="export-btn" class="btn btn-primary float-left">Export to Excel</button>
                    </div>

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
                        <td>{{ \Carbon\Carbon::parse($log->bsl_cmn_logs_time)->format('H:i') >= '07:00' 
                            && \Carbon\Carbon::parse($log->bsl_cmn_logs_time)->format('H:i') <= '19:00'
                             ? 'Day Shift' : 'Night Shift' }}
                        </td> <!-- Determine shift based on time -->
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
        "pageLength": 10 // Display 10 rows per page
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
});
</script>
@stop