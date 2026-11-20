<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Lowkey Decoration</title>
    <style>body{font-family:sans-serif;padding:40px;background:#f4f5f7;}.card{background:#fff;padding:24px;border-radius:8px;max-width:600px;box-shadow:0 2px 10px rgba(0,0,0,0.05);}</style>
</head>
<body>
    <div class="card">
        <h2>Panel Dashboard Admin</h2>
        <p>Halo, {{ Auth::user()->name }} (Role: Admin)</p>
        <p>Kelola katalog layanan, jadwal tim, dan pemesanan dekorasi.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="padding:10px 20px;background:#2d3748;color:#fff;border:none;border-radius:4px;cursor:pointer;">Logout</button>
        </form>
    </div>
</body>
</html>