@extends('layouts.admin')

@section('title')
Admin | Companies
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Companies</h5>
                <a href="{{route('companies.create')}}" class="btn btn-primary">Add New</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                        <tr>
                            <td>{{$company -> bsl_cmn_user_types_id}}</td>
                            <td>{{$company ->bsl_cmn_user_types_name}}</td>
                            <td>
                                <a href="{{url('companies/'.$company->bsl_cmn_user_types_id.'/edit') }}"
                                    class="btn btn-success">Edit</a>
                                <a href="{{url('companies/'.$company->bsl_cmn_user_types_id.'/delete') }}"
                                    class="btn btn-danger">Delete</a>
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

@section('recent-activity')

@stop