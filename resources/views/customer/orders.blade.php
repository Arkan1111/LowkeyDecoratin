
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - LowkeyDecoratin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f4f0;
            color: #342c27;
            margin: 0;
            padding: 25px 6%;
        }
        h1 { color: #594333; }
        .order {
            background: white;
            padding: 22px;
            margin: 18px 0;
            border-radius: 12px;
        }
        .status {
            display: inline-block;
            background: #f1e3d5;
            padding: 7px 12px;
            border-radius: 20px;
        }
        a { color: #79583e; }
    </style>
</head>
<body>

<a href="{{ route('customer.dashboard') }}">← Kembali ke Katalog</a>

<h1>Pesanan Saya</h1>
<p>Lihat daftar pesanan dan status pemrosesannya.</p>

@forelse($orders as $order)
    <div class="order">
        <h3>{{ $order->order_code }}</h3>

        <p>Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>

        <p>Status:
            <span class="status">{{ ucfirst($order->status) }}</span>
        </p>

        <h4>Produk:</h4>

        @foreach($order->items as $item)
            <p>
                {{ $item->product->name ?? 'Produk dihapus' }}
                — {{ $item->quantity }} x
                Rp{{ number_format($item->price, 0, ',', '.') }}
            </p>
        @endforeach

        <h3>
            Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}
        </h3>
    </div>
@empty
    <p>Belum ada pesanan.</p>
@endforelse

</body>
</html>
