@extends('layouts.admin')

@section('title')
Admin | Edit User
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Edit User</h5>
                <a href="{{ route('users.index')}}" class="btn btn-danger">Back</a>
            </div>

            <div class="card-body">
                <form action="{{ url('users/'.$user->bsl_cmn_users_id) }}" method="POST">
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 mt-3 col-lg-4">
                            <label for="name" class="fw-bold">First Name</label>
                            <input type="text" name="firstname" value="{{$user->bsl_cmn_users_firstname}}" class="form-control">
                            @error('firstname')<span class="text-danger">{!! $message !!}</span>@enderror
                        </div>
                        <div class="mb-3 mt-3 col-lg-4">
                            <label for="name" class="fw-bold">Last Name</label>
                            <input type="text" name="lastname" value="{{$user->bsl_cmn_users_lastname}}" class="form-control">
                            @error('lastname')<span class="text-danger">{!! $message !!}</span>@enderror
                        </div>
                        <div class="mb-3 mt-3 col-lg-4">
                            <label for="name" class="fw-bold">Email</label>
                            <input type="text" name="email" value="{{$user->email}}" class="form-control">
                            @error('email')<span class="text-danger">{!! $message !!}</span>@enderror
                        </div>
                        <div class="mb-3 mt-3 col-lg-4">
                            <label for="name" class="fw-bold">Employment Number</label>
                            <input type="text" name="employment_number" value="{{$user->bsl_cmn_users_employment_number}}" class="form-control">
                            @error('employment_number')<span class="text-danger">{!! $message !!}</span>@enderror
                        </div>
                        <div class="mb-3 mt-3 col-lg-4">
                            <label for="name" class="fw-bold">Department</label>
                            <input type="text" name="department" value="{{$user->bsl_cmn_users_department}}" class="form-control">
                            @error('department')<span class="text-danger">{!! $message !!}</span>@enderror
                        </div>
                        <div class="mb-3 mt-3 col-lg-4">
                            <label for="name" class="fw-bold">Password</label>
                            <input type="password" name="password" value="" class="form-control">
                            @error('password')<span class="text-danger">{!! $message !!}</span>@enderror
                        </div>
                        <div class="mb-2 col-lg-6">
                            <label for="user_type_id" class="form-label fw-bold">Company</label>
                            <select class="form-select" id="user_type_id" name="user_type_id" required>
                                <option value="">Select User Type</option>
                                @foreach ($userTypes as $userTypeId => $userTypeName)
                                <option value="{{ $userTypeId }}" {{ $user->bsl_cmn_users_type == $userTypeId ? 'selected' : '' }}>
                                    {{ $userTypeName }}
                                </option>
                                @endforeach
                            </select>
                            @error('user_type_id')<span class="text-danger">{!! $message !!}</span>@enderror
                        </div>
                        <div class="mb-2 col-lg-6">
                            <label for="name" class="fw-bold">Pin</label>
                            <input type="text" name="pin" value="{{$user->bsl_cmn_users_pin}}" class="form-control">
                            @error('pin')<span class="text-danger">{!! $message !!}</span>@enderror
                        </div>
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="name" class="fw-bold">Roles</label>
                            <select name="roles[]" class="form-control" multiple>
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                <option value="{{$role}}" {{in_array($role, $userRoles) ? 'selected': ''}}>{{$role}}
                                </option>
                                @endforeach
                                @error('roles')<span class="text-danger">{!! $message !!}</span>@enderror
                            </select>
                        </div>
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="user_type_id" class="form-label fw-bold">Shifts</label>
                            <select name="shifts[]" id="shifts" class="form-control" required>
                                @foreach($allShifts as $shiftId => $shiftName)
                                <option value="{{ $shiftId }}" {{ $user->shifts->contains($shiftId) ? 'selected' : '' }}>
                                    {{ $shiftName }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="status" name="status" value="1">

                        <div class="mb-3 mt-3 col-lg-12">
                            <button type="submit" class="btn btn-primary ">Update</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

@stop

@section('recent-activity')

@stop