<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title }} | Reimbursement</title>
    <!-- Meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('dashboard/images/icon.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/toastr/toastr.min.css') }}">

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    {{-- Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/trix.css') }}">
    <script type="text/javascript" src="{{ asset('dashboard/js/trix.js') }}"></script>

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>

</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar menu-light ">
        <div class="navbar-wrapper  ">
            <div class="navbar-content scroll-div ">

                <div class="">
                    <div class="main-menu-header">
                        <img class="img-radius" src="{{ asset('dashboard/images/user/avatar-2.jpg') }}"
                            alt="User-Profile-Image">
                        <div class="user-details">
                            <div id="more-details">{{ auth()->user()->name }} ({{ auth()->user()->status }}) <i
                                    class="fa fa-caret-down"></i></div>
                        </div>
                    </div>
                    <div class="collapse" id="nav-user-link">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="border-0"><i
                                            class="feather icon-log-out m-r-5"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <ul class="nav pcoded-inner-navbar ">
                    <li class="nav-item pcoded-menu-caption">
                        <label>Navigation</label>
                    </li>
                    <li class="nav-item {{ $active == 'dashboard' ? 'active' : '' }}">
                        <a href="/" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-home"></i>
                            </span><span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ $active == 'pengajuan' ? 'active' : '' }}">
                        <a href="/pengajuan" class="nav-link ">
                            <span class="pcoded-micon">
                                <i class="feather icon-bookmark"></i>
                            </span><span class="pcoded-mtext">Data Pengajuan</span>
                        </a>
                    </li>
                    @if (auth()->user()->status == 'Direktur')
                        <li class="nav-item {{ $active == 'user' ? 'active' : '' }}">
                            <a href="/user" class="nav-link ">
                                <span class="pcoded-micon">
                                    <i class="feather icon-users"></i>
                                </span><span class="pcoded-mtext">Data User</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">


        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="#"><span></span></a>
            <a href="/" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                {{-- <img src="{{ asset('dashboard/images/logo.png') }}" alt="" class="logo" width="90%">
                <img src="{{ asset('dashboard/images/logo-icon.png') }}" alt="" class="logo-thumb"> --}}
            </a>
            <a href="#" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="badge bg-primary border-0"><i
                                class="feather icon-log-out text-light"></i></button>
                    </form>
                </li>
            </ul>
        </div>


    </header>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">{{ $title }}</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="feather icon-star text-white"></i>
                                </li>
                                <li class="breadcrumb-item"><a href="/">{{ $title }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            @yield('isidashboard')
            <!-- [ Main Content ] end -->

        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="{{ asset('dashboard/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/ripple.js') }}"></script>
    <script src="{{ asset('dashboard/js/pcoded.min.js') }}"></script>
</body>

</html>
