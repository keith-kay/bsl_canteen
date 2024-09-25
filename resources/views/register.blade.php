@extends('layouts.app')

@section('content')

</style>
<div class="container">
    <div class="formContainer text-center">
        <form class="signupForm" action="{{ route('register-user') }}" method="POST">
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @csrf

            <div class="form-group">
                <img src="{{ asset('images/bslogo.png') }}" alt="Logo" style="max-width: 70%;">
                <h4>Register</h4>

                <div class="mb-2">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" required class="form-control" id="firstname" name="firstname" placeholder="Enter First Name" value="">
                </div>

                <div class="mb-2">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" required class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name" value="{{ old('lastname') }}">

                </div>

                <div class="mb-2">
                    <label for="email" class="form-label">Employment Number</label>
                    <input type="text" class="form-control" id="empno" name="employment_number" placeholder="Enter employment_number" value="{{ old('email') }}">
                </div>

                <div class="mb-2">
                    <label for="email" class="form-label">Department</label>
                    <input type="text" class="form-control" name="department" placeholder="eg ICT">
                </div>

                <div class="mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="empno" name="email" placeholder="email@bulkstream.com">
                </div>

                <div class="mb-2">
                    <label for="user_type_id" class="form-label">Company</label>
                    <select class="form-select" id="user_type_id" name="user_type_id" required>
                        <option value="">Select Company</option>
                        @foreach ($userTypes as $userTypeId => $userTypeName)
                        <option value="{{ $userTypeId }}">{{ $userTypeName }}</option>
                        @endforeach
                    </select>

                </div>
                <input type="hidden" id="status" name="status" value="1">

                <button class="btn btn-nav fw-bold" type="submit">Register</button>
            </div>
        </form>
    </div>
</div>
@stop