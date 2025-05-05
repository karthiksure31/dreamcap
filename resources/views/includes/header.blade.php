<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('landing/images/logo/icon.png') }}">

    <!-- jquery -->
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>

    <!-- Plugins css -->

    <link href="{{ asset('libs/@fullcalendar/core/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/@fullcalendar/daygrid/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/@fullcalendar/bootstrap/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/@fullcalendar/timegrid/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/@fullcalendar/list/main.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('libs/mohithg-switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" /> -->
    <link href="{{ asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" /> -->

    <!-- App css -->
    <link href="{{ asset('css/bootstrap-modern.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('css/app-modern.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{ asset('css/bootstrap-modern-dark.min.css') }}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{ asset('css/app-modern-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <!-- button link  -->

    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">

    <!-- date picker -->
    <link href="{{ asset('date-picker/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('date-picker/style.css') }}" rel="stylesheet" type="text/css" />

    @yield('css')
    <style>
        .error {
            color: red
        }
    </style>