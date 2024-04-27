@extends('layouts.admin')

@section('title')
Admin | Sites
@stop

@section('report')
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

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sites as $site)
                        <tr>
                            <td>{{ $site->bsl_cmn_sites_id }} </td>
                            <td>{{$site -> bsl_cmn_sites_name}}</td>
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