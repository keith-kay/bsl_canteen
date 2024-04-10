<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}" type="image/x-icon">
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
            border: solid 2px #f8f9fa;
        }

        .btn-nav {
            background-color: #153037;
            color: #f8f9fa;
            border: solid 2px #f8f9fa;
        }

        .btn-nav:hover {
            background-color: #f8f9fa;
            color: #153037;
            border: solid 2px #153037;
        }

        .welcome-text {
            color: #000;
            font-size: 70px;
            font-weight: 300;
        }



        @media (max-width: 768px) {

            .text-block,
            .image-div {
                margin-bottom: 30px;
            }

            .welcome-text {
                font-size: 40px;
            }
        }
    </style>
</head>

<body>

    <div class="container landing-page">
        <!-- Logo -->
        <div class="row">
            <div class="col-md-12 mx-3">
                <img src="{{ asset('images/bslogo.png') }}" alt="Logo" class="logo">
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-md-8">
                <div class="text-block">
                    <p class="welcome-text">Welcome to <strong style="color: #153037; font-weight:600;">Bulkstream
                            Limited</strong> Canteen</p>
                </div>
                <div class="mx-2">
                    <a href="{{ route('login') }}" class="btn btn-nav fw-bold mx-4 btn-lg" style="width: 200px;">Login</a>
                </div>
            </div>

            <div class="col-md-4 d-none d-md-block">
                <div class="image-div">
                    <div class="mx-auto" style="width: 500px; height: 350px;">
                        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

                        <dotlottie-player src="https://lottie.host/7145321f-a493-4fd2-bceb-70f7dd73f86f/Y0OsIyfEzi.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
                        </dotlottie-player>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>