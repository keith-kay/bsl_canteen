@extends('layouts.admin')

@section('title')
Admin | Sites
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
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Sites</h5>
                <a href="{{ route('sites.create')}}" class="btn btn-primary">Add New</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>

                            <th>Id</th>
                            <th>Name</th>
                            <th>IP Address</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sites as $site)
                        <tr>
                            <td>{{ $site->bsl_cmn_sites_id }} </td>
                            <td>{{$site -> bsl_cmn_sites_name}}</td>
                            <td>{{$site -> bsl_cmn_sites_device_ip}}</td>

                            <td>
                                <div class="d-inline">
                                    <a href="{{ url('sites/'.$site->bsl_cmn_sites_id.'/edit') }}"
                                        class="btn btn-success">Edit</a>
                                </div>
                                <div class="d-inline">
                                    <a href="{{ url('sites/'.$site->bsl_cmn_sites_id.'/delete') }}"
                                        class="btn btn-danger">Delete</a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@stop