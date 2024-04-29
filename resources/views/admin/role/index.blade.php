@extends('layouts.admin')

@section('title')
Admin | Roles
@stop

@section('report')
<div class="col-lg-12">

    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Roles</h5>
                <a href="{{ route('roles.create')}}" class="btn btn-primary">Add New</a>
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
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{$role -> id}}</td>
                            <td>{{$role -> name}}</td>
                            <td>
                                <a href="{{url('roles/'.$role->id.'/give-permissions') }}" class="btn btn-warning">Assign
                                    role</a>
                                <a href="{{url('roles/'.$role->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <a href="{{url('roles/'.$role->id.'/delete') }}" class="btn btn-danger">Delete</a>

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