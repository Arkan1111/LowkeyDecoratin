<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Keuangan - Lowkey Decoration</title>
    <style>body{font-family:sans-serif;padding:40px;background:#f4f7f6;}.card{background:#fff;padding:24px;border-radius:8px;max-width:600px;box-shadow:0 2px 10px rgba(0,0,0,0.05);}</style>
</head>
<body>
    <div class="card">
        <h2>Panel Dashboard Keuangan</h2>
        <p>Halo, {{ Auth::user()->name }} (Role: Keuangan)</p>
        <p>Kelola verifikasi pembayaran DP/pelunasan dan pembukuan kas masuk/keluar.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="padding:10px 20px;background:#1b4d3e;color:#fff;border:none;border-radius:4px;cursor:pointer;">Logout</button>
        </form>
    </div>
</body>
</html>