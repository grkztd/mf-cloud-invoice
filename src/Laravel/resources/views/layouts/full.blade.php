<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="robots" content="noindex,nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <title>@yield('title')</title>

        <link rel="stylesheet" href="/vendor/font-awesome/css/font-awesome.min.css">
        @vite(['resources/js/app.js', 'resources/css/app.css'])
        @stack('assets')
    </head>
    <body>
        <header class="flex px-3 py-1 bg-green-800 text-gray-200 justify-between">
            <h1 class="md:justify-items-start">GRポータル</h1>
            <p id="logoutTrigger" class="justify-items-end md:w-auto">
                <a href="http://127.0.0.1:8082/user_management">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </p>
        </header>
        <main>
            @yield('content')
        </main>
        <footer class="mt-auto px-3 py-1 bg-green-800 text-sm text-white text-center">
            <p>Copyright (c) 2016 ギフティブリサーチ合同会社. All Rights Reserved. </p>
        </footer>
    </body>
</html>