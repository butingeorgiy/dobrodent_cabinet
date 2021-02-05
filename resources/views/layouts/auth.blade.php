<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <title>@yield('title')</title>
</head>
<body class="bg-gray-100">
    <div class="container h-screen mx-auto">
        <div class="flex flex-col h-full">
            <a href="/" class="absolute pt-5 pl-4 sm:pl-8">
                <img src="{{ asset('images/logo.png') }}" alt="logo" width="150px">
            </a>
            <div class="h-full flex justify-center items-center">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
