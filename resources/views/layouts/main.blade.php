<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="/favico.png" />
    <title>@yield('title') | Enchanted Kingdom</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/dist/semantic.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="/css/plugins/introjs.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="/css/plugins/iziToast.min.css">
    <link rel="stylesheet" type="text/css" href="/css/config.css">

    @yield('custom_css')
</head>

<body>

    {{-- NAVIGATION --}}
    @include('layouts.top-menu')
    {{-- END NAVIGATION --}}

    {{-- SIDEBAR --}}
    @include('layouts.sidebar-nav')
    {{-- END OF SIDEBAR --}}

    {{-- CUSTOMER REGISTRATION MODAL --}}
    @include('components.modal-customer-registration')
    {{-- END OF CUSTOMER REGISTRATION MODAL --}}

    {{-- CART MODAL --}}
    @include('components.modal-cart')
    {{-- END OF CART MODAL --}}

    {{-- CART NEXT MODAL --}}
    @include('components.modal-cart-next1')
    {{-- END OF CART NEXT MODAL --}}

    {{-- CART NEXT MODAL --}}
    @include('components.modal-cart-next2')
    {{-- END OF CART NEXT MODAL --}}

    {{-- <div class="ui stackable grid container-fluid" style="margin:5px;"> --}}
        @yield('content')
    {{-- </div> --}}

    <!-- JS -->
    <script src="/js/app.js"></script>
    <script src="/dist/semantic.min.js"></script>
    <script src="/js/plugins/iziToast.min.js"></script>
    <script src="/js/plugins/moment.js"></script>
    <script src="/js/plugins/pdfmake.min.js"></script>
    <script src="/js/plugins/vfs_fonts.js"></script>
    <script src="/js/config.js"></script>
    <!-- CUSTOM JS -->
    @yield('custom_js')
</body>

</html> 