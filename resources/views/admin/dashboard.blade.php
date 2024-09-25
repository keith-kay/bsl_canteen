@extends('layouts.admin')

@section('title')
Admin | Dashboard
@stop

@section('tea')
<!-- day shift tea count -->
<!-- <div class="col-xxl-4 col-md-3">
    <div class="card info-card sales-card">

        <div class="card-body">
            <h5 class="card-title">Tea <span>| Day Shift</span></h5>

            <div class="d-flex align-items-center">
                <div class=" rounded-circle d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/cup.png') }}" alt="">
                </div>
                <div class="ps-3">
                    <h6>{{$teaCount}}</h6>


                </div>
            </div>
        </div>

    </div>

</div> -->

<!-- nigh shift tea count -->
<!-- <div class="col-xxl-4 col-md-3">
    <div class="card info-card sales-card">

        <div class="card-body">
            <h5 class="card-title">Tea <span>| Night Shift</span></h5>

            <div class="d-flex align-items-center">
                <div class=" rounded-circle d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/cup.png') }}" alt="">
                </div>
                <div class="ps-3">
                    <h6>{{$nightTeaCount}}</h6>


                </div>
            </div>
        </div>

    </div>

</div> -->
@stop


@section('lunch')
<!-- <div class="col-xxl-4 col-md-3">
    <div class="card info-card revenue-card">

        <div class="card-body">
            <h5 class="card-title">Lunch <span>| Day Shift</span></h5>

            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/dinner.png') }}" alt="">
                </div>
                <div class="ps-3">
                    <h6>{{$lunchCount}}</h6>

                </div>
            </div>
        </div>

    </div>
</div> -->
@stop

@section('supper')
<!-- <div class="col-xxl-4 col-md-3">

    <div class="card info-card customers-card">

        <div class="card-body">
            <h5 class="card-title">Supper <span>| Night Shift</span></h5>

            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/dinner.png') }}" alt="">
                </div>
                <div class="ps-3">
                    <h6>{{$supperCount}}</h6>

                </div>
            </div>

        </div>
    </div>

</div> -->
@stop

@section('report')

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tickets <span>/
                    @php
                    $currentHour = date('H'); // Get current hour
                    if ($currentHour >= 7 && $currentHour < 19) { echo 'Day Shift' ; } else { echo 'Night Shift' ; } @endphp </span>
            </h5>
            <table id="reports-table" class="table table-border-less table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Site</th>
                        <th>Meal Type</th>
                        <th>Timestamp</th>
                        <th>Shift</th> <!-- Add a new column for Shift -->
                    </tr>
                </thead>
                <tbody>
                    @php
                    // Sort $logs array by timestamp in descending order
                    $sortedLogs = $logs->sortByDesc('bsl_cmn_logs_time');
                    @endphp
                    @foreach($sortedLogs as $log)
                    <tr>
                        <td>{{ $log->user->bsl_cmn_users_firstname }} {{ $log->user->bsl_cmn_users_lastname }}</td>
                        <td>{{ $log->user->userType->bsl_cmn_user_types_name }}</td>
                        <td>{{ $log->site ? $log->site->bsl_cmn_sites_name : 'No site available' }}</td>
                        <td>{{ $log->mealType->bsl_cmn_mealtypes_mealname }}</td>
                        <td>{{ $log->bsl_cmn_logs_time }}</td>
                        <td>
                            @php
                            $time = strtotime($log->bsl_cmn_logs_time);
                            $hour = date('H', $time);
                            $shift = ($hour >= 7 && $hour < 19) ? 'Day' : 'Night' ; echo $shift; @endphp </td>
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
            "searching": false,
            "ordering": false,
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