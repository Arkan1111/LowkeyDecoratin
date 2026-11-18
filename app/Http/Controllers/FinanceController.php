<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class FinanceController extends Controller
{
    public function index()
    {
        $totalPemasukan = Transaction::where('type', 'pemasukan')->sum('amount');

        $totalPengeluaran = Transaction::where('type', 'pengeluaran')->sum('amount');

        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $totalTransaksi = Transaction::count();

        $transactions = Transaction::latest('transaction_date')
            ->latest()
            ->paginate(10);

        // Data grafik keuangan 6 bulan terakhir
        $bulan = [];
        $dataPemasukan = [];
        $dataPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subMonths($i);

            $bulan[] = $tanggal->translatedFormat('M Y');

            $dataPemasukan[] = Transaction::where('type', 'pemasukan')
                ->whereYear('transaction_date', $tanggal->year)
                ->whereMonth('transaction_date', $tanggal->month)
                ->sum('amount');

            $dataPengeluaran[] = Transaction::where('type', 'pengeluaran')
                ->whereYear('transaction_date', $tanggal->year)
                ->whereMonth('transaction_date', $tanggal->month)
                ->sum('amount');
        }

        return view('keuangan.dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'totalTransaksi',
            'transactions',
            'bulan',
            'dataPemasukan',
            'dataPengeluaran'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:pemasukan,pengeluaran'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'transaction_date' => ['required', 'date'],
        ]);

        $data['transaction_code'] = 'TRX-' . strtoupper(Str::random(8));

        Transaction::create($data);

        return back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
