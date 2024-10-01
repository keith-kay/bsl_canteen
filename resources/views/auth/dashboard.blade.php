<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-xxx" crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

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

    .tea-description {
        text-align: center;
        /* Center-align the text */
        font-size: 25px;
        /* Set the font size */

        margin-bottom: 40px;
        /* Add some top margin */
    }


    @media (max-width: 768px) {

        .text-block,
        .image-div {
            margin-bottom: 30px;
        }

        .d-flex.justify-content-center.mx-auto {
            max-width: 150px;
            margin: 0 auto 0 auto;
        }

        #swal-container {
            max-width: 200px;
            /* Set the maximum width */
            margin: 0 auto;
            /* Center the container horizontally */
        }
    }
    </style>
</head>

<body>

    <div class="container landing-page">
        <!-- Logo -->
        <div class="row">
            <div class="col-md-12 mx-2">

                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                @if (Auth::check() )
                <div style="display: inline; float: right;">
                    <h5 style="display: inline;">{{ auth()->user()->bsl_cmn_users_firstname }}
                        {{ auth()->user()->bsl_cmn_users_lastname }}
                    </h5>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button class="btn btn-nav fw-bold" type="submit">Logout</button>
                    </form>
                </div>


                @endif
            </div>
        </div>
        <!-- Display IP Address -->
        <div class="row">
            <!-- <div class="col-md-12">
                <h5>Your IP Address: {{ $ip_address }}</h5>
            </div> -->
        </div>
        @if(session('errors'))
            {{ session('errors') }}
        @endif
        <div class="container">
            <!-- Main Content -->
            <form id="mealSelectionForm" action="/selectMeal" method="post">
                @csrf
                <div class="row mt-3 mb-4 justify-content-center">
                    <input type="hidden" id="mealTypeIdInput" name="meal_type_id">

                    {{-- <div class="col-md-6 mt-4">
                        <a href="javascript:void(0);" onclick="selectMeal(1)" style="text-decoration: none;">
                            <div class="image-div">
                                <div class="d-flex justify-content-center mx-auto"
                                    style="max-width: 300px; max-height: 300px;">
                                    <script
                                        src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                                        type="module"></script>
                                    <dotlottie-player
                                        src="https://lottie.host/ca9c8ad3-da81-4ead-b80d-1c8fd9d0272f/HJTyTrfTrU.json"
                                        background="transparent" speed="1" style="width: 100%; height: auto;" loop
                                        autoplay>
                                    </dotlottie-player>
                                </div>
                                <p class="text-center fs-5 mt-3 tea-description"
                                    style="color: #153037; margin-bottom: 20px;">
                                    <strong><u>Tea</u></strong>
                                </p>
                            </div>
                        </a>
                    </div> --}}

                    <div class="col-md-6 mt-4">
                        <a href="javascript:void(0);" onclick="selectMeal(2)" style="text-decoration: none;">
                            <div class="image-div">
                                <div class="d-flex justify-content-center mx-auto"
                                    style="max-width: 300px; max-height: 300px;">
                                    <script
                                        src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                                        type="module"></script>
                                    <dotlottie-player
                                        src="https://lottie.host/ea6487ee-1ebd-4373-bf94-0a646aaa9e81/Ym8ml402Rf.json"
                                        background="transparent" speed="1" style="width: 100%; height: auto;" loop
                                        autoplay>
                                    </dotlottie-player>
                                </div>
                                <p class="text-center fs-5 mt-3 tea-description"
                                    style="color: #153037; margin-bottom: 20px;">
                                    <strong><u>
                                            @php
                                            $hour = (int) date('H');
                                            if ($hour >= 7 && $hour < 19) { echo 'Lunch' ; } else { echo 'Supper' ; }
                                                @endphp </u></strong>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

            </form>
        </div>
        <button id="submitBtn" type="submit" style="display: none;"></button>

    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src=" https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlerts for success and error messages -->
    <div id="swal-container">
        @if(session('success'))
        <script>
        Swal.fire({
            icon: 'success',
            text: '{{ session("success") }}',
            footer: 'Please pick your meal ticket!',
            confirmButtonColor: '#153037',
            timer: 3000,
            timerProgressBar: true
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                // Log out after 5 seconds
                logoutUser();
            }
        });
        </script>
        @endif
    </div>

    <div id="swal-container">
        @if(session('error'))
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session("error") }}',
            confirmButtonColor: '#153037', // Change the color of the confirm button
            timer: 3000,
            timerProgressBar: true
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                // Log out after 5 seconds
                logoutUser();
            }
        });
        </script>
        @endif
    </div>

    <div id="swal-container">
        @if(session('errors'))
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session("errors") }}',
            confirmButtonColor: '#153037', // Change the color of the confirm button
            // timer: 3000,
            //timerProgressBar: true
        // }).then((result) => {
        //     if (result.dismiss === Swal.DismissReason.timer) {
        //         // Log out after 5 seconds
        //         logoutUser();
        //     }
        });
        </script>
        @endif
    </div>

    <script>
    function logoutUser() {
        window.location.href = '/logout';
    }
    </script>

    <script>
    function logFormContent() {
        var formData = $('#mealSelectionForm').serializeArray();
        console.log(formData);
    }

    function selectMeal(mealTypeId) {
        // Set the selected meal type ID in the hidden input field
        document.getElementById('mealTypeIdInput').value = mealTypeId;
        // Submit the form
        document.getElementById('mealSelectionForm').submit();
    }

    var logoutTimer; // Variable to store the timeout

    function resetLogoutTimer() {
        clearTimeout(logoutTimer); // Clear the previous timeout
        logoutTimer = setTimeout(logoutUser, 10000); // Set a new timeout for 10 seconds
    }

    function logoutUser() {
        window.location.href = '/logout'; // Redirect to the logout route
    }

    // Reset the logout timer on user activity
    document.addEventListener('mousemove', resetLogoutTimer);
    document.addEventListener('keydown', resetLogoutTimer);
    document.addEventListener('click', resetLogoutTimer);
    document.addEventListener('scroll', resetLogoutTimer);
    </script>
</body>

</html>
