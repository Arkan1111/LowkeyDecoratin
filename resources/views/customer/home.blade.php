<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Loki Decoration - Wedding Organizer</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])
</head>

<body>

    {{-- NAVBAR --}}
    @include('customer.layouts.navbar')

    <main class="cd-page">

        {{-- 1. HERO --}}
        @include('customer.sections.hero')

        {{-- 2. PORTFOLIO LAYANAN --}}
        @include('customer.sections.portfolio')

        {{-- 3. KEUNGGULAN --}}
        @include('customer.sections.benefits')

        {{-- 4. PAKET DEKORASI --}}
        @include('customer.sections.packages')

        {{-- 5. DOKUMENTASI --}}
        @include('customer.sections.gallery')

        {{-- 6. TESTIMONI --}}
        @include('customer.sections.testimonials')

    </main>

    {{-- FOOTER --}}
    @include('customer.layouts.footer')

</body>

</html>