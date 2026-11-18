
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - LowkeyDecoratin</title>
    <style>
        body { font-family: Arial; background: #f5f0e8; display: grid; place-items: center; min-height: 100vh; }
        .card { background: white; padding: 35px; border-radius: 15px; width: min(350px, 85%); }
        input, button { width: 100%; padding: 12px; margin: 9px 0; box-sizing: border-box; }
        button { background: #70543e; color: white; border: 0; cursor: pointer; }
        a { color: #70543e; }
    </style>
</head>
<body>
<div class="card">
    <h2>LowkeyDecoratin</h2>
    <p>Silakan masuk ke akun Anda.</p>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <a href="{{ route('register') }}">Belum punya akun? Daftar</a>
</div>
</body>
</html>
