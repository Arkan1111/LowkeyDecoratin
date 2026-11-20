<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Admin') - Loki Decoration</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body class="admin-body">
    <div class="admin-shell">
        @include('admin.layouts.sidebar')

        <div class="admin-main">
            @include('admin.layouts.topbar')

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
