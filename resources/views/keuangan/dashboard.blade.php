
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Keuangan - LowkeyDecoratin</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f5f7;
            color: #252b36;
        }

        .sidebar {
            position: fixed;
            width: 245px;
            height: 100vh;
            background: #202b3c;
            color: white;
            padding: 28px 20px;
        }

        .brand { font-size: 19px; font-weight: bold; }
        .subtitle { color: #aab4c2; font-size: 11px; margin: 8px 0 40px; }

        .sidebar a {
            display: block;
            padding: 13px;
            color: #d4dbe5;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .sidebar a.active, .sidebar a:hover {
            background: #354761;
            color: white;
        }

        .logout {
            position: absolute;
            bottom: 30px;
            left: 20px;
            width: calc(100% - 40px);
        }

        .logout button {
            width: 100%;
            padding: 12px;
            background: #354761;
            color: white;
            border: 0;
            border-radius: 7px;
            cursor: pointer;
        }

        .main { margin-left: 245px; padding: 35px; }

        .header { margin-bottom: 28px; }
        .header h1 { margin: 0 0 8px; font-size: 27px; }
        .header p { color: #7b8492; margin: 0; }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 25px;
        }

        .stat, .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 3px 15px #00000008;
        }

        .stat p { color: #7b8492; margin: 0 0 12px; font-size: 13px; }
        .stat h2 { margin: 0; font-size: 23px; }

        .green { color: #269568; }
        .red { color: #d15b55; }
        .blue { color: #4779bb; }
        .brown { color: #92744f; }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 22px;
        }

        .card h3 { margin-top: 0; margin-bottom: 20px; }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dce1e8;
            border-radius: 7px;
            margin: 8px 0 15px;
        }

        button {
            padding: 11px 17px;
            border: 0;
            border-radius: 7px;
            color: white;
            cursor: pointer;
            background: #4779bb;
        }

        .income-btn { background: #269568; }
        .expense-btn { background: #d15b55; }

        .alert {
            background: #e5f3e9;
            color: #28633d;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .errors {
            background: #fce9e7;
            color: #a33329;
        }

        table { width: 100%; border-collapse: collapse; }
        th, td {
            padding: 14px 10px;
            text-align: left;
            border-bottom: 1px solid #edf0f3;
            font-size: 13px;
        }

        th { color: #778292; }
        .delete { background: #d15b55; padding: 8px 12px; }

        .chart-wrap { height: 280px; position: relative; }

        .pagination { margin-top: 18px; }

        @media(max-width: 1000px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
        }

        @media(max-width: 750px) {
            .sidebar { position: static; width: 100%; height: auto; }
            .logout { position: static; margin-top: 20px; width: 100%; }
            .main { margin-left: 0; padding: 20px; }
            .grid { grid-template-columns: 1fr; }
            .stats { grid-template-columns: 1fr 1fr; }
            .card { overflow-x: auto; }
        }
    </style>
</head>

<body>

<aside class="sidebar">
    <div class="brand">LOWKEY DECORATIN</div>
    <div class="subtitle">FINANCE MANAGEMENT</div>

    <a href="{{ route('keuangan.dashboard') }}" class="active">Dashboard Keuangan</a>
    <a href="#pemasukan">Pemasukan</a>
    <a href="#pengeluaran">Pengeluaran</a>
    <a href="#riwayat">Riwayat Transaksi</a>

    <form action="{{ route('logout') }}" method="POST" class="logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
</aside>

<main class="main">

    <div class="header">
        <h1>Dashboard Keuangan</h1>
        <p>Ringkasan dan pengelolaan keuangan LowkeyDecoratin.</p>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert errors">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <section class="stats">
        <div class="stat">
            <p>Total Pemasukan</p>
            <h2 class="green">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</h2>
        </div>

        <div class="stat">
            <p>Total Pengeluaran</p>
            <h2 class="red">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</h2>
        </div>

        <div class="stat">
            <p>Total Saldo</p>
            <h2 class="blue">Rp{{ number_format($totalSaldo, 0, ',', '.') }}</h2>
        </div>

        <div class="stat">
            <p>Total Transaksi</p>
            <h2 class="brown">{{ $totalTransaksi }}</h2>
        </div>
    </section>

    <section class="card" style="margin-bottom:22px">
        <h3>Grafik Keuangan 6 Bulan Terakhir</h3>
        <div class="chart-wrap">
            <canvas id="financeChart"></canvas>
        </div>
    </section>

    <section class="grid">
        <div class="card" id="pemasukan">
            <h3>Tambah Pemasukan</h3>
            <form action="{{ route('keuangan.transactions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="pemasukan">

                <label>Keterangan</label>
                <input type="text" name="description" placeholder="Contoh: Penjualan dekorasi" required>

                <label>Jumlah (Rp)</label>
                <input type="number" name="amount" min="1" placeholder="Masukkan jumlah" required>

                <label>Tanggal</label>
                <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required>

                <button class="income-btn" type="submit">Simpan Pemasukan</button>
            </form>
        </div>

        <div class="card" id="pengeluaran">
            <h3>Tambah Pengeluaran</h3>
            <form action="{{ route('keuangan.transactions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="pengeluaran">

                <label>Keterangan</label>
                <input type="text" name="description" placeholder="Contoh: Pembelian bahan dekorasi" required>

                <label>Jumlah (Rp)</label>
                <input type="number" name="amount" min="1" placeholder="Masukkan jumlah" required>

                <label>Tanggal</label>
                <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required>

                <button class="expense-btn" type="submit">Simpan Pengeluaran</button>
            </form>
        </div>
    </section>

    <section class="card" id="riwayat">
        <h3>Riwayat Transaksi</h3>

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_code }}</td>
                        <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>
                            <span class="{{ $transaction->type == 'pemasukan' ? 'green' : 'red' }}">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td>Rp{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('keuangan.transactions.destroy', $transaction) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $transactions->links() }}
        </div>
    </section>

</main>

<script>
    const labels = @json($bulan);
    const pemasukan = @json($dataPemasukan);
    const pengeluaran = @json($dataPengeluaran);

    new Chart(document.getElementById('financeChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: pemasukan,
                    backgroundColor: '#269568',
                    borderRadius: 5
                },
                {
                    label: 'Pengeluaran',
                    data: pengeluaran,
                    backgroundColor: '#d15b55',
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
