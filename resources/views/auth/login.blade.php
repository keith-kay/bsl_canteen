@extends('layouts.app')

@section('content')
<style>
    /* Apply glow effect to input field when typing */
    .custom-input:focus {
        border-color: rgba(25, 54, 61, 0.438);
        /* Set border color when in focus */
        box-shadow: 0 0 0 0.2rem rgba(25, 54, 61, 0.438);
        /* Customize glow effect */
    }
</style>

<div style="max-width: 800px; height: 300px;" class="mx-2">
    <form class="signupForm mx-4 " action="{{ route('login-user') }}" method="POST">
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @csrf

        <div class="form-group mx-3">
            <div class="mb-3 text-center mt-4 mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto d-block" style="max-width: 70%;">
            </div>
            <h4 style="color: #153037; font-weight:600;" class="fw-bold mt-3 mb-2">Enter Pin</h4>

            <div class="mb-3  mt-4">
                <input type="password" required class="form-control custom-input" id="pin" inputmode="numeric" name="pin" placeholder="****" value="">
                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
            </div>

            <button class="btn btn-nav fw-bold mt-4" type="submit">Submit</button>
        </div>
    </form>
</div>
<script>
  const input = document.getElementById('pin');
  input.addEventListener('input', function (e) {
    // Remove non-numeric characters
    this.value = this.value.replace(/\D/g, '');
  });
</script>

@stop
