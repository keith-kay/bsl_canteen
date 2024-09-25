@extends('layouts.admin')

@section('title')
Admin | Edit Role
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Role: {{$role->name}}</h5>
                <a href="{{ route('roles.index')}}" class="btn btn-danger">Back</a>
            </div>

            <div class="card-body">
                <form action="{{ route('roles.give-permissions', ['roleid' => $role->id]) }}" method="POST">

                    @csrf
                    @method('PUT')
                    <div class="mb-3 mt-3">
                        <label for="name"><strong>Permissions</strong></label>
                        <div class="row">
                            @foreach ($permissions as $permission)
                            <div class="col-md-3">
                                <label for="">
                                    <input type="checkbox" name="permission[]" value="{{$permission->name}}"
                                        {{ in_array($permission->id, $rolePermissions) ? 'checked':'' }}>
                                    {{$permission->name}}
                                </label>

                            </div>
                            @endforeach
                        </div>

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