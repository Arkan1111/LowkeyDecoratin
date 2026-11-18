
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - LowkeyDecoratin</title>
</head>
<body>
    <h2>Daftar LowkeyDecoratin</h2>

    @if($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <input name="name" placeholder="Nama lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password minimal 8 karakter" required>
        <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
        <button type="submit">Daftar</button>
    </form>

    <a href="{{ route('login') }}">Kembali ke login</a>
</body>
</html>
