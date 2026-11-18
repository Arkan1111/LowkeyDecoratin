
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori - LowkeyDecoratin</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f3ef;
            color: #29251f;
        }
        .sidebar {
            position: fixed;
            width: 240px;
            height: 100vh;
            background: #29251f;
            color: white;
            padding: 28px 20px;
        }
        .brand { font-size: 20px; font-weight: bold; margin-bottom: 8px; }
        .subtitle { color: #c5b9a8; font-size: 12px; margin-bottom: 40px; }
        .sidebar a {
            display: block;
            color: #ddd4c8;
            text-decoration: none;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #80694d;
            color: white;
        }
        .main { margin-left: 240px; padding: 35px; }
        .header { margin-bottom: 28px; }
        .header h1 { margin: 0 0 8px; font-size: 27px; }
        .header p { color: #81786e; margin: 0; }
        .card {
            background: white;
            padding: 25px;
            border-radius: 13px;
            margin-bottom: 22px;
            box-shadow: 0 3px 15px #00000008;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd5ca;
            border-radius: 7px;
            margin: 8px 0 15px;
            font-size: 14px;
        }
        textarea { min-height: 75px; resize: vertical; }
        button {
            border: 0;
            padding: 11px 17px;
            border-radius: 7px;
            cursor: pointer;
            background: #80694d;
            color: white;
        }
        .delete { background: #b7473d; }
        .edit { background: #647b68; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            padding: 15px 12px;
            border-bottom: 1px solid #eee9e2;
            text-align: left;
        }
        th { color: #766d62; font-size: 13px; }
        .alert {
            padding: 13px;
            border-radius: 7px;
            background: #e5f3e7;
            color: #286238;
            margin-bottom: 18px;
        }
        .error { color: #b7473d; font-size: 13px; }
        .actions { display: flex; gap: 7px; align-items: center; }
        .actions form { margin: 0; }
        @media(max-width: 750px) {
            .sidebar { position: static; width: 100%; height: auto; }
            .main { margin-left: 0; padding: 20px; }
            .card { overflow-x: auto; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="brand">LOWKEY DECORATIN</div>
    <div class="subtitle">ADMIN MANAGEMENT</div>

    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.categories') }}" class="active">Data Kategori</a>
    <a href="{{ route('admin.products') }}">Data Produk</a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" style="margin-top:25px;background:#51483e;width:100%">
            Logout
        </button>
    </form>
</aside>

<main class="main">
    <div class="header">
        <h1>Manajemen Kategori</h1>
        <p>Kelola kategori produk dekorasi LowkeyDecoratin.</p>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert" style="background:#fce9e7;color:#a33329">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <section class="card">
        <h3>Tambah Kategori</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <label>Nama Kategori</label>
            <input type="text" name="name" placeholder="Contoh: Dekorasi Kamar" required>

            <label>Deskripsi</label>
            <textarea name="description" placeholder="Masukkan deskripsi kategori"></textarea>

            <button type="submit">Simpan Kategori</button>
        </form>
    </section>

    <section class="card">
        <h3>Daftar Kategori</h3>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description ?? '-' }}</td>
                        
<td>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name"
               value="{{ $category->name }}" required>

        <textarea name="description">{{ $category->description }}</textarea>

        <button type="submit" class="edit">Simpan Perubahan</button>
    </form>

    <form action="{{ route('admin.categories.destroy', $category) }}"
          method="POST"
          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
          style="margin-top:8px">
        @csrf
        @method('DELETE')
        <button class="delete" type="submit">Hapus</button>
    </form>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</main>

</body>
</html>
