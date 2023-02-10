<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('page-title')
    {{-- <link href="{{ url('assets/img/favicon.png') }}" rel="icon"> --}}
    <link rel="stylesheet" href="{{ url('assets/vandors/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vandors/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vandors/css/linearicons.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css">
    <link rel="stylesheet" href="{{ url('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/response.css') }}">
</head>
<body>
    <div class="loader-container" id="loader-container">
        <div class="lds-ripple"><div></div><div></div></div>
    </div>
    <style>
        .loader-container{
            position: fixed;
            top: 0px;
            bottom: 0px;
            left: 0px;
            right: 0;
            background-color: #000;
            z-index: 999999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .lds-ripple {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
        }
        .lds-ripple div {
        position: absolute;
        border: 4px solid #fff;
        opacity: 1;
        border-radius: 50%;
        animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }
        .lds-ripple div:nth-child(2) {
        animation-delay: -0.5s;
        }
        @keyframes lds-ripple {
        0% {
            top: 36px;
            left: 36px;
            width: 0;
            height: 0;
            opacity: 0;
        }
        4.9% {
            top: 36px;
            left: 36px;
            width: 0;
            height: 0;
            opacity: 0;
        }
        5% {
            top: 36px;
            left: 36px;
            width: 0;
            height: 0;
            opacity: 1;
        }
        100% {
            top: 0px;
            left: 0px;
            width: 72px;
            height: 72px;
            opacity: 0;
        }
        }
    </style>
    @yield('navigation')
    @yield('content')
    <div class="notification-container">

    </div>
    <script src="{{ url('assets/vandors/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/vandors/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/vandors/js/aos.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ url('assets/js/app.js') }}"></script>
    <script src="{{ url('assets/js/app.components.js') }}"></script>
    <script src="{{ url('assets/js/api-requests.js') }}"></script>
    @yield('script')
</body>
</html>