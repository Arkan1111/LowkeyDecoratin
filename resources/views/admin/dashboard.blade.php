
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - LowkeyDecoratin</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f2ee;
            color: #392f29;
        }

        .navbar {
            background: #5b4334;
            color: white;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .navbar h2 {
            margin: 0;
        }

        .navbar form {
            margin: 0;
        }

        .navbar button {
            background: #e8d2bc;
            color: #392f29;
            border: none;
            padding: 10px 18px;
            border-radius: 7px;
            cursor: pointer;
        }

        .container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .welcome {
            background: #eaddcf;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .welcome h1 {
            margin-top: 0;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px #0000000d;
        }

        .stat-card h3 {
            color: #79583f;
            margin-top: 0;
        }

        .stat-card p {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 0;
        }

        .menu-title {
            margin-bottom: 18px;
        }

        .menus {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .menu-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px #0000000d;
        }

        .menu-card h3 {
            margin-top: 0;
            color: #79583f;
        }

        .menu-card p {
            color: #6c625c;
            line-height: 1.5;
        }

        .menu-card a {
            display: inline-block;
            background: #79583f;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 7px;
            margin-top: 8px;
        }

        .menu-card a:hover {
            background: #5b4334;
        }

        @media(max-width: 700px) {
            .stats, .menus {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <h2>LowkeyDecoratin</h2>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <main class="container">

        <section class="welcome">
            <h1>Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p>
                Ini adalah dashboard Admin LowkeyDecoratin.
                Kelola produk, kategori, dan pesanan pelanggan melalui halaman ini.
            </p>
        </section>

        <h2>Ringkasan Data</h2>

        <section class="stats">
            <div class="stat-card">
                <h3>Total Produk</h3>
                <p>{{ $totalProducts }}</p>
            </div>

            <div class="stat-card">
                <h3>Total Kategori</h3>
                <p>{{ $totalCategories }}</p>
            </div>

            <div class="stat-card">
                <h3>Total Stok Produk</h3>
                <p>{{ $totalStock }}</p>
            </div>
        </section>

        <h2 class="menu-title">Menu Pengelolaan</h2>

        <section class="menus">

            <div class="menu-card">
                <h3>Manajemen Produk</h3>
                <p>
                    Tambah, edit, dan hapus produk dekorasi
                    yang tersedia di toko.
                </p>
                <a href="{{ route('admin.products') }}">Kelola Produk</a>
            </div>

            <div class="menu-card">
                <h3>Manajemen Kategori</h3>
                <p>
                    Kelola kategori produk agar katalog
                    dekorasi lebih terorganisir.
                </p>
                <a href="{{ route('admin.categories') }}">Kelola Kategori</a>
            </div>

            <div class="menu-card">
                <h3>Manajemen Pesanan</h3>
                <p>
                    Lihat pesanan Customer dan ubah status
                    pesanan dari Menunggu, Diproses, hingga Selesai.
                </p>
                <a href="{{ route('admin.orders') }}">Kelola Pesanan</a>
            </div>

            <div class="menu-card">
                <h3>Dashboard Admin</h3>
                <p>
                    Pantau ringkasan data dan aktivitas
                    pengelolaan toko LowkeyDecoratin.
                </p>
                <a href="{{ route('admin.dashboard') }}">Lihat Dashboard</a>
            </div>

        </section>

    </main>

</body>
</html>
