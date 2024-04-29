@extends('layouts.admin')

@section('title')
Admin | Edit Role
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Edit Role</h5>
                <a href="{{ route('roles.index')}}" class="btn btn-danger">Back</a>
            </div>

            <div class="card-body">
                <form action="{{url('roles/'.$role->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 mt-3">
                        <label for="name">Role Name</label>
                        <input type="text" name="name" value="{{$role->name}}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@stop

@section('recent-activity')

@stop