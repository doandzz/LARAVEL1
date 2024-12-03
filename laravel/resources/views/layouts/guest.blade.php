<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg" href="{{ asset('assets/img/logo.svg') }}">
    <title>ASI Traffic Portable - Sign In</title>
    <!-- BEGIN Includes Styles  -->
    <link rel="stylesheet" href="{{ asset('node_modules/overlayscrollbars/styles/overlayscrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fa.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- END Includes Styles  -->
</head>

<body class="page login no-sidebar no-header">
    <div class="min-h-screen flex flex-col items-center bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
