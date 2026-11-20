<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Klien - Lowkey Decoration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-body">
    <div class="auth-shell">
        {{-- PANEL KIRI --}}
        <aside class="auth-story-panel">
            <div class="auth-story-overlay">
                <div class="auth-brand">
                    <div class="auth-brand-logo">
                        <img src="{{ Vite::asset('resources/images/lowkey-removebg-preview.png') }}" alt="Lowkey Decoration">
                    </div>
                    <div class="auth-brand-info">
                        <strong>LOWKEY DECORATION</strong>
                        <span>WEDDING ORGANIZER</span>
                    </div>
                </div>
                <div class="auth-story-content">
                    <h1>“Mewujudkan Momen Sakral &amp; Abadi Bersama Sentuhan Kemewahan Estetika.”</h1>
                    <p>Daftarkan akun untuk mulai merancang konsep pernikahan impian Anda bersama tim dekorator profesional kami.</p>
                </div>
                <div class="auth-story-footer"></div>
            </div>
        </aside>

        {{-- PANEL KANAN --}}
        <main class="auth-form-panel">
            <div class="auth-form-container">
                <div class="auth-heading">
                    <div>
                        <h2>Registrasi Klien Baru</h2>
                        <span>WEDDING &amp; EVENT STYLIST</span>
                    </div>
                </div>

                <form action="{{ route('register.store') }}" method="POST" class="auth-form">
                    @csrf

                    {{-- NAMA --}}
                    <div class="auth-field">
                        <label for="name">Nama Lengkap</label>
                        <div class="auth-input-wrapper">
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required autofocus>
                        </div>
                        @error('name')
                        <small class="auth-error">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="auth-field">
                        <label for="email">Alamat Email</label>
                        <div class="auth-input-wrapper">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="contoh@domain.com" required>
                        </div>
                        @error('email')
                        <small class="auth-error">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="auth-field">
                        <label for="password">Kata Sandi</label>
                        <div class="auth-input-wrapper">
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required>
                        </div>
                        @error('password')
                        <small class="auth-error">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="auth-field">
                        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="auth-input-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>

                    <button type="submit" class="auth-submit" style="margin-top: 10px;">
                        DAFTAR SEBAGAI KLIEN
                        <span aria-hidden="true">→</span>
                    </button>

                    <div class="auth-register" style="margin-top: 20px;">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" style="color: #c5a880; font-weight: 600; text-decoration: none;">Masuk di Sini</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>