@extends('layouts.admin')

@section('title')
Admin | Roles
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
                        <th>Shift</th>
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
                            <div class="d-flex flex-column">
                                @foreach($user->shifts as $shift)
                                <span class="badge bg-primary mb-1">{{ $shift->bsl_cmn_shifts_name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td style="white-space: nowrap;">
                            <div class="d-flex flex-column">
                                @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $rolename)
                                <span for="" class="badge bg-primary mb-1">{{$rolename}}</span>
                                @endforeach
                                @endif
                            </div>
                        </td>
                        <td style="white-space: nowrap;">
                            <div class="row">
                                <div class="col mb-1">
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