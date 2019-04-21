﻿<!DOCTYPE html>
<html lang="en">
<head>
    @routes()
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicons Icon -->
    {{-- <link rel="shortcut icon" href="http://htmldemo.themessoft.com/freshia/version3/favicon1.ico" type="image/x-icon"> --}}
    {{-- <link rel="icon" href="http://htmldemo.themessoft.com/freshia/version3/favicon1.ico" type="image/x-icon"> --}}
    <title>Smart Drink</title>
    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">
    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/slick.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/slick-theme.css') }}" />
    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}" />
@yield('css')
</head>

<body class="home cms-index-index cms-home-page">
    <div id="page">
        <!-- Header -->
            @include('layouts.header_client')
            @include('layouts.menu_client')
        @yield('content')
        @include('layouts.footer_client')
    </div>
    <!-- JavaScript -->
    <script src="{{ asset('asset/client/js/themessoft/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/client/js/themessoft/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/client/js/themessoft/slick.min.js') }}"></script>
    <script src="{{ asset('asset/client/js/themessoft/nouislider.min.js') }}"></script>
    <script src="{{ asset('asset/client/js/themessoft/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('asset/client/js/themessoft/main.js') }}"></script>

    <script src="{{ asset('asset/client/js/themessoft/toastr.min.js') }}"></script>
    <script src="{{ asset('asset/client/js/themessoft/jquery.validate.min.js') }}"></script>

    @yield('js')

</body>
</html>
