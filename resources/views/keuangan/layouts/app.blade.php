<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Keuangan - Lowkey Decoration')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body class="finance-body">
    <div class="finance-shell">
        @include('keuangan.layouts.sidebar')

        <div class="finance-workspace">
            @include('keuangan.layouts.topbar')

            <main class="finance-main">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
