<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="A team is created here based on the combination of players you select, and we recommend good combinations to help you succeed" />
    <meta name="keywords" content="create dream11 team" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat%7COpen+Sans:700,400%7CRaleway:400,800,900" rel="stylesheet" />
    <link rel="icon" href="{{ asset('landing/images/logo/icon.png') }}">
    <script type="text/javascript" src="{{ asset('landing/js/library/jquery.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">

    <link href="{{ asset('landing/css/library/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css-min/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/dev-assets/preloader-default.css') }}" rel="stylesheet" type="text/css" />
    @yield('css')
    <style>
        .error{
            color:red
        }
    </style>
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">

</head>

<body class="esport-black">
    <div class="preloader-wrapper" id="preloader">
        <div class="motion-line dark-big"></div>
        <div class="motion-line yellow-big"></div>
        <div class="motion-line dark-small"></div>
        <div class="motion-line yellow-normal"></div>
        <div class="motion-line yellow-small1"></div>
        <div class="motion-line yellow-small2"></div>
    </div>

    <!-- HEADER BEGIN-->
    <div id="esport-team-landing-header" class="esport-team-landing-header">
        <div class="container">
            <div class="wrapper">
                <a class="logo" href="javascript:void(0)">
                    <img src="{{ asset('landing/images/logo/dreamcapvc.png') }}" alt="logo">
                </a>
                <button type="button" data-toggle="collapse" data-target="#landing-header" aria-expanded="false" class="navbar-toggle">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <div class="clear-header">
                    <div id="landing-header" class="navbar-collapse collapse">
                        <ul class="list">
                            <li>
                                <a href="#matches">matches</a>
                            </li>
                            <li>
                                <a href="#contact">contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- HEADER END-->