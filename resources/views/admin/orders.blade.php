
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Pesanan - LowkeyDecoratin</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f2ee;
            color: #392f29;
        }
        header {
            background: #5b4334;
            color: white;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header a { color: white; text-decoration: none; }
        main { max-width: 1150px; margin: 35px auto; padding: 0 20px; }
        .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px #0000000d;
        }
        .success {
            background: #d9f2df;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 11px; border-bottom: 1px solid #eee; text-align: left; }
        select, button {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: #79583f;
            color: white;
            cursor: pointer;
            border: none;
        }
        .status { font-weight: bold; color: #79583f; }
        @media(max-width:650px) {
            table { font-size: 13px; }
            th, td { padding: 7px; }
        }
    </style>
</head>
<body>

<header>
    <h2>LowkeyDecoratin - Admin</h2>
    <a href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
</header>

<main>
    <h1>Manajemen Pesanan</h1>
    <p>Kelola pesanan yang masuk dari Customer.</p>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @forelse($orders as $order)
        <div class="card">
            <div class="order-header">
                <div>
                    <h3>{{ $order->order_code }}</h3>
                    <p>Customer: {{ $order->customer_name }}</p>
                    <p>Email akun: {{ $order->user->email ?? '-' }}</p>
                    <p>Telepon: {{ $order->phone }}</p>
                    <p>Alamat: {{ $order->address }}</p>
                    <p>Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <p>Status saat ini:</p>
                    <p class="status">{{ ucfirst($order->status) }}</p>
                    <h3>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</h3>
                </div>
            </div>

            <h4>Produk yang dipesan</h4>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Produk dihapus' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('admin.orders.status', $order) }}"
                  method="POST" style="margin-top:20px;">
                @csrf
                @method('PUT')

                <label>Ubah Status: </label>
                <select name="status">
                    <option value="menunggu" @selected($order->status == 'menunggu')>Menunggu</option>
                    <option value="diproses" @selected($order->status == 'diproses')>Diproses</option>
                    <option value="selesai" @selected($order->status == 'selesai')>Selesai</option>
                    <option value="dibatalkan" @selected($order->status == 'dibatalkan')>Dibatalkan</option>
                </select>

                <button type="submit">Simpan Status</button>
            </form>
        </div>
    @empty
        <div class="card">
            <p>Belum ada pesanan dari Customer.</p>
        </div>
    @endforelse
</main>

</body>
</html>
