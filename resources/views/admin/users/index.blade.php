@extends('layouts.admin')

@section('title')
Admin | Roles
@stop

@section('report')

<div class="col-12">
    <div class="card">

        <div class="card-header d-flex justify-content-between">
            <h5 class="m-0">Users</h5>
            <a href="{{ route('users.create')}}" class="btn btn-primary">Add New</a>
        </div>

        <div class="card-body">
            <table id="users-table" class="table table-border-less table-striped">
                <thead>
                    <tr>

                        <th>Name</th>
                        <th>Staff No</th>
                        <th>Email</th>
                        <th>Pin</th>
                        <th>Department</th>
                        <th>Company</th>
                        <th>Roles</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td style="white-space: nowrap;">{{ $user->bsl_cmn_users_firstname }}
                            {{$user->bsl_cmn_users_lastname}}
                        </td>
                        <td style="white-space: nowrap;">{{$user -> bsl_cmn_users_employment_number}}</td>
                        <td style="white-space: nowrap;">{{$user -> email}}</td>
                        <td style="white-space: nowrap;">{{$user -> bsl_cmn_users_pin}}</td>
                        <td style="white-space: nowrap;">{{$user -> bsl_cmn_users_department}}</td>
                        <td style="white-space: nowrap;">{{$user->userType->bsl_cmn_user_types_name}}</td>
                        <td style="white-space: nowrap;">
                            @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $rolename)
                            <label for="" class="badge bg-primary mx-1">{{$rolename}}</label>
                            @endforeach
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <div class="row">
                                <div class="col">
                                    <a href="{{ url('users/'.$user->bsl_cmn_users_id.'/edit') }}"
                                        class="btn btn-success btn-block">Edit</a>
                                </div>
                                <div class="col">
                                    <a href="{{ url('users/'.$user->bsl_cmn_users_id.'/delete') }}"
                                        class="btn btn-danger btn-block">Delete</a>
                                </div>
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
    var table = $('#users-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10 // Display 10 rows per page
    });


});
</script>
@stop