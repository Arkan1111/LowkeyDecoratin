@php
$navigation = [
[
'label' => 'Beranda',
'url' => url('/'),
'active' => request()->is('/')
],
[
'label' => 'Paket Dekorasi',
'url' => url('/#paket'),
'active' => false
],
[
'label' => 'Kalender Ketersediaan',
'url' => url('/#ketersediaan'),
'active' => false
],
[
'label' => 'Reservasi Online',
'url' => url('/reservasi'),
'active' => request()->is('reservasi*')
],
[
'label' => 'Cek Status & Pembayaran',
'url' => url('/cek-status-pembayaran'),
'active' => request()->is('cek-status-pembayaran*')
],
];
@endphp

<header class="cust-header">

    <div class="cust-navbar">

        {{-- LOGO DAN BRAND --}}
        <a href="{{ url('/') }}" class="cust-brand">

            <img
                src="{{ Vite::asset('resources/images/lowkey-removebg-preview.png') }}"
                alt="Lowkey Decoration Logo"
                class="cust-logo">

            <div class="cust-brand-info">
                <h2>Lowkey Decoration</h2>
                <span>WEDDING ORGANIZER</span>
            </div>

        </a>

        {{-- MOBILE MENU BUTTON --}}
        <button
            type="button"
            class="cust-menu-toggle"
            id="custMenuToggle"
            aria-label="Buka navigasi"
            aria-controls="custNavbarContent"
            aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        {{-- NAVIGATION CONTENT --}}
        <div class="cust-navbar-content" id="custNavbarContent">

            {{-- MENU --}}
            <nav class="cust-nav-menu">

                @foreach ($navigation as $item)

                <a
                    href="{{ $item['url'] }}"
                    class="cust-nav-link {{ $item['active'] ? 'active' : '' }}"
                    @if ($item['active'])
                    aria-current="page"
                    @endif>
                    {{ $item['label'] }}
                </a>

                @endforeach

            </nav>

            {{-- NAVBAR ACTIONS --}}
            <div class="cust-navbar-actions">

                {{-- WHATSAPP CONTACT --}}
                <a
                    href="https://wa.me/6281234567890?text={{ urlencode('Halo Loki Decoration, saya ingin konsultasi dekorasi.') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="cust-contact">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="19"
                        height="19"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                        19.79 19.79 0 0 1-8.63-3.07
                        19.5 19.5 0 0 1-6-6
                        19.79 19.79 0 0 1-3.07-8.67
                        A2 2 0 0 1 4.11 2h3a2 2 0 0 1
                        2 1.72c.12.96.35 1.91.69 2.82
                        a2 2 0 0 1-.45 2.11L8.08 9.91
                        a16 16 0 0 0 6 6l1.27-1.27
                        a2 2 0 0 1 2.11-.45
                        c.91.34 1.86.57 2.82.69
                        A2 2 0 0 1 22 16.92z" />
                    </svg>

                    <span>
                        <small>KONSULTASI GRATIS</small>
                        <strong>0812-3456-7890</strong>
                    </span>

                </a>

                {{-- LOGIN BUTTON --}}
                <a href="{{ url('/login') }}" class="cust-login-button">
                    Login Klien / Admin
                </a>

            </div>

        </div>

    </div>

</header>