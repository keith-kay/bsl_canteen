@extends('layouts.admin')

@section('title')
Admin | Permissions
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Permissions</h5>
                <a href="{{ route('permissions.create')}}" class="btn btn-primary">Add New</a>
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
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{$permission -> id}}</td>
                            <td>{{$permission -> name}}</td>
                            <td>
                                <a href="{{url('permissions/'.$permission->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <a href="{{url('permissions/'.$permission->id.'/delete') }}" class="btn btn-danger">Delete</a>
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