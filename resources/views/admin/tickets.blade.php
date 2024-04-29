@extends('layouts.admin')

@section('title')
Admin | Tickets
@stop



@section('report')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tickets</h5>

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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr data-user-id="{{ $log->user->bsl_cmn_users_id }}">
                        <td>{{ $log->user->bsl_cmn_users_firstname }} {{ $log->user->bsl_cmn_users_lastname }}</td>
                        <td>{{ $log->user->bsl_cmn_users_employment_number }}</td>
                        <td>{{ $log->user->userType->bsl_cmn_user_types_name }}</td>
                        <td>{{ $log->mealType->site->bsl_cmn_sites_name }}</td>
                        <td>{{$log->user->bsl_cmn_users_department}}</td>
                        <td>{{ $log->mealType->bsl_cmn_mealtypes_mealname }}</td>
                        <td>{{ $log->bsl_cmn_logs_time }}</td>
                        <td>
                            <div class="d-inline">
                                <button class="btn btn-success print-btn">Print</button>
                            </div>
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
        "pageLength": 10 // Display 10 rows per page
    });

    // Print Button Click Event
    $('#reports-table').on('click', '.print-btn', function() {
        // Extract user ID from the data attribute of the table row
        var userId = $(this).closest('tr').data('user-id');

        // Extract data from the table row
        var $row = $(this).closest('tr');
        var name = $row.find('td:eq(0)').text().trim();
        var staffNo = $row.find('td:eq(1)').text().trim();
        var company = $row.find('td:eq(2)').text().trim();
        var department = $row.find('td:eq(4)').text().trim();
        var mealType = $row.find('td:eq(5)').text().trim();
        var timestamp = $row.find('td:eq(6)').text().trim();

        // Construct the data to be sent in the POST request
        var requestData = {
            userid: userId,
            userdetails: name,
            staffid: staffNo,
            department: department,
            company: company,
            mealType: mealType,
            date: timestamp
        };

        // Log the JSON data being passed
        console.log('Data to be sent:', JSON.stringify(requestData));

        // Send the data in a POST request to the printer endpoint
        $.ajax({
            url: 'http://api.bulkstream.com:1416/mealprint.php?userid=' + userId +
                '&printerid=TCMEAL',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(requestData),
            success: function(response) {
                console.log('Printing successful:', response);
                // Optionally, you can handle the response here
            },
            error: function(xhr, status, error) {
                console.error('Error printing:', error);
                // Optionally, you can handle errors here
            }
        });
    });
});
</script>
@stop