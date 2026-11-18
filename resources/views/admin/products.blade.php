
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - LowkeyDecoratin</title>

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

        .brand {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #c5b9a8;
            font-size: 12px;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            color: #ddd4c8;
            text-decoration: none;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #80694d;
            color: white;
        }

        .main {
            margin-left: 240px;
            padding: 35px;
        }

        .header { margin-bottom: 28px; }

        .header h1 {
            margin: 0 0 8px;
            font-size: 27px;
        }

        .header p { color: #81786e; }

        .card {
            background: white;
            padding: 25px;
            border-radius: 13px;
            margin-bottom: 22px;
            box-shadow: 0 3px 15px #00000008;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd5ca;
            border-radius: 7px;
            margin: 8px 0 15px;
            font-size: 14px;
        }

        textarea {
            min-height: 75px;
            resize: vertical;
        }

        button {
            border: 0;
            padding: 11px 17px;
            border-radius: 7px;
            cursor: pointer;
            background: #80694d;
            color: white;
        }

        .edit { background: #647b68; }
        .delete { background: #b7473d; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px 12px;
            border-bottom: 1px solid #eee9e2;
            text-align: left;
            vertical-align: top;
        }

        th {
            color: #766d62;
            font-size: 13px;
        }

        .alert {
            padding: 13px;
            border-radius: 7px;
            background: #e5f3e7;
            color: #286238;
            margin-bottom: 18px;
        }

        .actions form { margin-bottom: 8px; }

        .logout {
            margin-top: 25px;
            background: #51483e;
            width: 100%;
        }

        @media(max-width: 750px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .card { overflow-x: auto; }
        }
    </style>
</head>

<body>

<aside class="sidebar">
    <div class="brand">LOWKEY DECORATIN</div>
    <div class="subtitle">ADMIN MANAGEMENT</div>

    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.categories') }}">Data Kategori</a>
    <a href="{{ route('admin.products') }}" class="active">Data Produk</a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout">Logout</button>
    </form>
</aside>

<main class="main">

    <div class="header">
        <h1>Manajemen Produk</h1>
        <p>Kelola produk dekorasi LowkeyDecoratin.</p>
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
        <h3>Tambah Produk</h3>

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <label>Nama Produk</label>
            <input type="text" name="name"
                   placeholder="Contoh: Dekorasi Backdrop Pernikahan" required>

            <label>Kategori</label>
            <select name="category_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <label>Deskripsi Produk</label>
            <textarea name="description"
                      placeholder="Masukkan deskripsi produk"></textarea>

            <label>Harga Produk (Rp)</label>
            <input type="number" name="price"
                   min="0" placeholder="Contoh: 150000" required>

            <label>Stok Produk</label>
            <input type="number" name="stock"
                   min="0" placeholder="Contoh: 10" required>

            <button type="submit">Simpan Produk</button>
        </form>
    </section>

    <section class="card">
        <h3>Daftar Produk</h3>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>{{ $product->name }}</strong>
                            <br>
                            <small>{{ $product->description }}</small>
                        </td>

                        <td>{{ $product->category->name }}</td>

                        <td>
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <td>{{ $product->stock }}</td>

                        <td class="actions">
                            <form action="{{ route('admin.products.update', $product) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')

                                <input type="text" name="name"
                                       value="{{ $product->name }}" required>

                                <select name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <textarea name="description">{{ $product->description }}</textarea>

                                <input type="number" name="price"
                                       value="{{ $product->price }}" min="0" required>

                                <input type="number" name="stock"
                                       value="{{ $product->stock }}" min="0" required>

                                <button type="submit" class="edit">
                                    Simpan Perubahan
                                </button>
                            </form>

                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="delete">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

</main>

</body>
</html>
