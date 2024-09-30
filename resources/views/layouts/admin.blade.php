<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel=" stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- CSS file for DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- JavaScript file for DataTables -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 7 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{route( 'admin.dashboard' )}}" class="logo d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" style="width:auto;">
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    @if (Auth::check() )
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle" style="font-size:30px;"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->bsl_cmn_users_firstname }}
                            {{ auth()->user()->bsl_cmn_users_lastname }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                    @endif
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="{{route( 'admin.dashboard' )}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#components-nav">
                    <i class="bi bi-gear"></i><span>Configs</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                    <li>
                        <a href="{{ url('guests') }}">
                            <i class="bi bi-circle"></i><span>Guests</span>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasRole('super-admin'))
                    <li>
                        <a href="{{ url('users') }}">
                            <i class="bi bi-circle"></i><span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('companies') }}">
                            <i class="bi bi-circle"></i><span>Companies</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('sites')}}">
                            <i class="bi bi-circle"></i><span>Sites</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('permissions') }}">
                            <i class="bi bi-circle"></i><span>Permissions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('roles')  }}">
                            <i class="bi bi-circle"></i><span>Roles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('printers') }}">
                            <i class="bi bi-circle"></i><span>Printers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('shifts') }}">
                            <i class="bi bi-circle"></i><span>Shifts</span>
                        </a>
                    </li>
                @endif
                </ul>
            </li><!-- End Users Nav -->
            @endif


            <!-- End Companies -->
            @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('security'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{url('ticket')}}">
                    <i class="bi bi-grid"></i>
                    <span>Meal-tickets</span>
                </a>
            </li>
            @endif
            <!-- End Meal-tickets -->

            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{url('report')}}">
                    <i class="bi bi-grid"></i>
                    <span>Reports</span>
                </a>
            </li><!-- End Meal-tickets -->
            @endif
        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="row">
                    <!-- Sales Card -->
                    @yield('tea')
                    <!-- End Sales Card -->

                    <!-- Revenue Card -->
                    @yield('lunch')
                    <!-- End Revenue Card -->

                    <!-- Customers Card -->
                    @yield('supper')
                    <!-- End Customers Card -->
                </div>
                <!-- Left side columns -->
                <!-- <div class="col-lg-9"> -->
                <!-- Reports -->
                @yield('report')
                <!-- End Reports -->
                <!-- </div> -->
                <!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">
                    <!-- Recent Activity -->
                    @yield('recent-activity')
                    <!-- End Recent Activity -->

                </div>
                <!-- End Right side columns -->


            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>{{ env("ENTITY") }}</span></strong>. All Rights Reserved
        </div>
        <!--  -->
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    @yield('scripts');

</body>

</html>