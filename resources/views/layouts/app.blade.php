<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
    /* Adjust styles as needed */
    .landing-page {
        padding: 50px 0;
    }

    .logo {
        margin-bottom: 20px;
        max-width: 150px;
        /* Set maximum width for the logo */
    }

    .text-block {
        background-color: #fff;
        /* Soft gray */
        border-radius: 10px;
        padding: 30px;
    }

    .image-div {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }

    .image-div img {
        width: 100%;
        height: auto;
        display: block;
    }

    .btn {
        background-color: #f8f9fa;
        color: #153037;
    }

    .btn:hover {
        background-color: #153037;
        color: #f8f9fa;
    }

    .btn-nav {
        background-color: #153037;
        color: #f8f9fa;
    }

    .btn-nav:hover {
        background-color: #f8f9fa;
        color: #153037;
    }

    @media (max-width: 768px) {

        .text-block,
        .image-div {
            margin-bottom: 30px;
        }
    }
    </style>
</head>

<body>

    <header>
        <!-- Header content goes here -->
    </header>

    <div class="container landing-page">
        <!-- Logo -->
        <div class="row">
            <div class="col-md-12 mb-4 mx-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-md-7 d-none d-md-block">
                <div class="text-block">
                    <p style="color: #000; font-size: 70px; font-weight:300;">Welcome to <br><strong
                            style="color: #153037; font-weight:600;">{{ env("ENTITY") }}</strong> Canteen</p>
                </div>

            </div>
            <div class="col-md-4 mt-4">
                @yield('content')
            </div>
        </div>
    </div>

    <footer>
        <!-- Footer content goes here -->
    </footer>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>