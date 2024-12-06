<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg" href="{{ asset('assets/img/logo.svg') }}">
    <title>@yield('title', 'ASI Education - Layout')</title>
    <!-- BEGIN Includes Styles  -->
    <link rel="stylesheet" href="{{ asset('node_modules/overlayscrollbars/styles/overlayscrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fa.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/flatpickr/dist/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flatpickr_asi.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/nice-select2/dist/css/nice-select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- END Includes Styles -->
</head>

<body>
    <script src="{{ asset('assets/js/body_open.js') }}"></script>
    <!-- BEGIN Site -->
    <div class="site d-flex">
        @include('includes.site-sidebar')
        @include('includes.site-header')
        <!-- BEGIN Site Main-->
        <div class="site-main d-flex flex-column">
            <!-- BEGIN Page Header -->
            @yield('page-header')
            <!-- END Page Header-->

            <!-- BEGIN Page Content -->
            @yield('page-content')
            <!-- END Page Content -->

            <!-- BEGIN Page Footer -->
            @yield('page-footer')
            <!-- END Page Header -->
        </div>
        <!-- END Site Main-->
    </div>
    <!-- END Site -->

    <!-- BEGIN Include JS -->
    <script src="{{ asset('node_modules/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('node_modules/overlayscrollbars/browser/overlayscrollbars.browser.es6.js') }}"></script>
    <script src="{{ asset('node_modules/flatpickr/dist/flatpickr.min.js') }}"></script>
    <script src="{{ asset('node_modules/flatpickr/dist/l10n/vn.js') }}"></script>
    <script src="{{ asset('node_modules/nice-select2/dist/js/nice-select2.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- END Include JS -->

    <!-- END Only for this page  -->
    <script>
        document.querySelector('.item- > .nav-link').classList.add("active");
    </script>
</body>

</html>
