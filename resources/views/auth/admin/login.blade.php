<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin / Tim - Lowkey Decoration</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])
</head>

<body class="auth-body">

    <div class="auth-shell">

        {{-- PANEL KIRI: BRAND DAN MANIFESTO --}}
        <aside class="auth-story-panel">

            <div class="auth-story-overlay">

                <div class="auth-brand">
                    <div class="auth-brand-logo">
                        <img
                            src="{{ Vite::asset('resources/images/lowkey-removebg-preview.png') }}"
                            alt="Lowkey Decoration">
                    </div>

                    <div class="auth-brand-info">
                        <strong>LOWKEY DECORATION</strong>
                        <span>WEDDING ORGANIZER</span>
                    </div>
                </div>

                <div class="auth-story-content">

                    <h1>
                        “Mewujudkan Momen Sakral &amp; Abadi Bersama Sentuhan Kemewahan Estetika.”
                    </h1>

                    <p>
                        Koleksi tata panggung, kurasi flora botani,
                        serta instalasi ruang intim yang dirancang
                        eksklusif untuk setiap kisah cinta Anda.
                    </p>

                </div>

                <div class="auth-story-footer">
                    <span></span>
                    <p>
                    </p>
                </div>

            </div>
        </aside>

        {{-- PANEL KANAN: FORM LOGIN ADMIN / TIM --}}
        <main class="auth-form-panel">

            <div class="auth-form-container">

                {{-- HEADER --}}
                <div class="auth-heading">
                    <div>
                        <h2>Portal Admin / Tim</h2>
                        <span>AKSES KHUSUS INTERNAL</span>
                    </div>
                </div>

                {{-- NAVIGASI LOGIN KLIEN / ADMIN --}}
                <nav class="auth-tabs" aria-label="Pilihan portal login">
                    <a href="{{ route('login') }}" class="auth-tab">
                        Masuk sebagai Klien
                    </a>
                    <a href="{{ route('admin.login') }}" class="auth-tab active" aria-current="page">
                        Portal Admin / Tim
                    </a>
                </nav>

                {{-- FORM LOGIN ADMIN / TIM --}}
                <form
                    action="{{ route('admin.login.store') }}"
                    method="POST"
                    class="auth-form">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="auth-field">
                        <label for="email">Alamat Email</label>

                        <div class="auth-input-wrapper">
                            <img
                                src="{{ Vite::asset('resources/images/emaill.png') }}"
                                alt="Lowkey Decoration"
                                style="width: 15px !important; height: 15px !important; object-fit: contain;">

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan alamat email admin atau tim"
                                autocomplete="username"
                                maxlength="255"
                                required
                                autofocus>
                        </div>

                        @error('email')
                        <small class="auth-error">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="auth-field">
                        <div class="auth-label-row">
                            <label for="password">Kata Sandi</label>
                        </div>

                        <div class="auth-input-wrapper">
                            <img
                                src="{{ Vite::asset('resources/images/lockk.png') }}"
                                alt="Lowkey Decoration"
                                style="width: 18px !important; height: 18px !important; object-fit: contain;">

                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Masukkan kata sandi akun admin atau tim"
                                autocomplete="current-password"
                                required>

                            <button
                                type="button"
                                class="auth-password-toggle"
                                id="passwordToggle"
                                aria-label="Tampilkan kata sandi">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="19"
                                    height="19"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>


                        </div>

                        @error('password')
                        <small class="auth-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <a
                        href="#"
                        class="auth-forgot"
                        aria-disabled="true"
                        onclick="return false;">
                        Lupa Kata Sandi?
                    </a>

                    {{-- ERROR AUTENTIKASI --}}
                    @error('login')
                    <div class="auth-alert" role="alert">
                        {{ $message }}
                    </div>
                    @enderror

                    {{-- TOMBOL LOGIN ADMIN / TIM --}}
                    <button type="submit" class="auth-submit">
                        MASUK KE PORTAL ADMIN / TIM
                        <span aria-hidden="true">→</span>
                    </button>

                    {{-- LOGIN GOOGLE BELUM DIAKTIFKAN --}}
                    <div class="auth-divider">
                        <span>ATAU MASUK DENGAN</span>
                    </div>

                    <button
                        type="button"
                        class="auth-google"
                        disabled
                        title="Login Google belum diaktifkan">
                        <span class="google-letter" aria-hidden="true">G</span>
                        Lanjutkan dengan Google
                    </button>

                </form>


            </div>
        </main>

    </div>

</body>

</html>