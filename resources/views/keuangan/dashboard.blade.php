@extends('keuangan.layouts.app')

@section('title', 'Dashboard Keuangan - Lowkey Decoration')

@php
    // DATA CONTOH UNTUK PREVIEW FRONTEND — BELUM TERHUBUNG KE DATABASE
    $stats = [
        [
            'label' => 'Pemasukan Bulan Ini',
            'value' => 'Rp 38,5 Jt',
            'note' => '+12% dari bulan lalu',
            'tone' => 'gold',
            'icon' => 'wallet',
        ],
        [
            'label' => 'Menunggu Pembayaran',
            'value' => 'Rp 8,75 Jt',
            'note' => '3 transaksi perlu dicek',
            'tone' => 'orange',
            'icon' => 'clock',
        ],
        [
            'label' => 'Pembayaran Lunas',
            'value' => '25',
            'note' => 'Transaksi bulan ini',
            'tone' => 'green',
            'icon' => 'check',
        ],
        [
            'label' => 'Saldo Kas Kecil',
            'value' => 'Rp 1,55 Jt',
            'note' => 'Dana operasional tersedia',
            'tone' => 'gold',
            'icon' => 'cash',
        ],
    ];

    $payments = [
        ['invoice' => 'INV-026', 'customer' => 'Sarah Anindita', 'event' => 'Pernikahan', 'date' => '25 Nov 2026', 'amount' => 'Rp 12.500.000', 'status' => 'Lunas', 'status_class' => 'paid'],
        ['invoice' => 'INV-025', 'customer' => 'Rizky Pratama', 'event' => 'Lamaran', 'date' => '28 Nov 2026', 'amount' => 'Rp 4.500.000', 'status' => 'DP Diterima', 'status_class' => 'partial'],
        ['invoice' => 'INV-024', 'customer' => 'Nadia Putri', 'event' => 'Pernikahan', 'date' => '02 Des 2026', 'amount' => 'Rp 10.000.000', 'status' => 'Menunggu', 'status_class' => 'pending'],
        ['invoice' => 'INV-023', 'customer' => 'Dimas Ardi', 'event' => 'Wedding Party', 'date' => '06 Des 2026', 'amount' => 'Rp 3.500.000', 'status' => 'Lunas', 'status_class' => 'paid'],
    ];

    $pettyCash = [
        ['description' => 'Transport survei lokasi', 'category' => 'Transportasi', 'date' => '20 Nov 2026', 'amount' => 'Rp 150.000', 'initial' => 'T'],
        ['description' => 'Pembelian kabel lampu', 'category' => 'Perlengkapan', 'date' => '19 Nov 2026', 'amount' => 'Rp 275.000', 'initial' => 'P'],
        ['description' => 'Konsumsi tim pemasangan', 'category' => 'Operasional', 'date' => '18 Nov 2026', 'amount' => 'Rp 180.000', 'initial' => 'K'],
    ];

    $cashFlow = [
        ['month' => 'Jun', 'income' => 52, 'expense' => 24],
        ['month' => 'Jul', 'income' => 64, 'expense' => 31],
        ['month' => 'Agu', 'income' => 58, 'expense' => 29],
        ['month' => 'Sep', 'income' => 76, 'expense' => 40],
        ['month' => 'Okt', 'income' => 84, 'expense' => 46],
        ['month' => 'Nov', 'income' => 92, 'expense' => 51],
    ];
@endphp

@section('content')
<div class="finance-page-heading">
    <div>
        <span class="finance-eyebrow">KEUANGAN / RINGKASAN</span>
        <h1>Dashboard Keuangan</h1>
        <p>Ringkasan pembayaran dan aktivitas keuangan Lowkey Decoration.</p>
    </div>
    <button class="finance-period-button" type="button">
        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 10h18"/></svg>
        November 2026
        <span>⌄</span>
    </button>
</div>

{{-- STATISTICS --}}
<section class="finance-stats-grid" aria-label="Ringkasan keuangan">
    @foreach ($stats as $stat)
        <article class="finance-stat-card">
            <div class="finance-stat-icon {{ $stat['tone'] }}">
                @if ($stat['icon'] === 'wallet')
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2.8" y="5" width="18.4" height="14" rx="2"/><path d="M3 9h18m-5 5h.01M7 5V3m10 2V3"/></svg>
                @elseif ($stat['icon'] === 'clock')
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                @elseif ($stat['icon'] === 'check')
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16 9"/></svg>
                @else
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="6" width="18" height="13" rx="2"/><path d="M7 6V4h10v2m-14 4h18m-12 4h6"/></svg>
                @endif
            </div>
            <div class="finance-stat-content">
                <span class="finance-stat-label">{{ $stat['label'] }}</span>
                <strong>{{ $stat['value'] }}</strong>
                <small>{{ $stat['note'] }}</small>
            </div>
        </article>
    @endforeach
</section>

{{-- PAYMENT TABLE + PETTY CASH --}}
<section class="finance-main-grid">
    <article class="finance-panel finance-payment-panel" id="pembayaran">
        <div class="finance-panel-heading">
            <div class="finance-panel-title-wrap">
                <span class="finance-panel-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2.8" y="5" width="18.4" height="14" rx="2"/><path d="M3 9h18m-14 5h4"/></svg>
                </span>
                <div>
                    <h2>Pembayaran Terbaru</h2>
                    <p>Daftar transaksi pembayaran pelanggan.</p>
                </div>
            </div>
            <a href="{{ url('/keuangan/pembayaran') }}" class="finance-text-link">Lihat Semua <span>→</span></a>
        </div>

        <div class="finance-table-wrap">
            <table class="finance-table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Acara</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="finance-search-item">
                            <td><span class="finance-invoice">{{ $payment['invoice'] }}</span></td>
                            <td>
                                <div class="finance-customer-cell">
                                    <span class="finance-initial">{{ strtoupper(substr($payment['customer'], 0, 1)) }}</span>
                                    <span>{{ $payment['customer'] }}</span>
                                </div>
                            </td>
                            <td>{{ $payment['date'] }}</td>
                            <td class="finance-amount">{{ $payment['amount'] }}</td>
                            <td><span class="finance-status {{ $payment['status_class'] }}">{{ $payment['status'] }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="finance-panel-footnote">Data contoh tampilan · Belum terhubung ke database.</p>
    </article>

    <article class="finance-panel finance-petty-panel" id="kas-kecil">
        <div class="finance-panel-heading">
            <div class="finance-panel-title-wrap">
                <span class="finance-panel-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="15" rx="2"/><path d="M3 9h18m-13 5h4m5-2h.01M7 5V3m10 2V3"/></svg>
                </span>
                <div>
                    <h2>Kas Kecil Terbaru</h2>
                    <p>Pengeluaran operasional terakhir.</p>
                </div>
            </div>
            <a href="{{ url('/keuangan/kas-kecil') }}" class="finance-text-link">Lihat Semua <span>→</span></a>
        </div>

        <div class="finance-petty-list">
            @foreach ($pettyCash as $item)
                <div class="finance-petty-item finance-search-item">
                    <span class="finance-petty-avatar">{{ $item['initial'] }}</span>
                    <div class="finance-petty-description">
                        <strong>{{ $item['description'] }}</strong>
                        <small>{{ $item['category'] }} · {{ $item['date'] }}</small>
                    </div>
                    <span class="finance-petty-amount">− {{ $item['amount'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="finance-balance-strip">
            <div>
                <span>Saldo kas kecil saat ini</span>
                <strong>Rp 1.550.000</strong>
            </div>
            <span class="finance-balance-indicator">Tersedia</span>
        </div>
        <p class="finance-panel-footnote">Data contoh tampilan · Belum terhubung ke database.</p>
    </article>
</section>

{{-- FINANCIAL REPORT SUMMARY --}}
<section class="finance-panel finance-report-panel" id="laporan">
    <div class="finance-panel-heading">
        <div class="finance-panel-title-wrap">
            <span class="finance-panel-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19.5V4.8A1.8 1.8 0 0 1 5.8 3H20v18H5.8A1.8 1.8 0 0 1 4 19.5Z"/><path d="M8 16v-3m4 3V8m4 8v-5"/></svg>
            </span>
            <div>
                <h2>Ringkasan Laporan Keuangan</h2>
                <p>Perbandingan pemasukan dan pengeluaran bulan ini.</p>
            </div>
        </div>
        <a href="{{ url('/keuangan/laporan') }}" class="finance-text-link">Lihat Laporan <span>→</span></a>
    </div>

    <div class="finance-report-content">
        <div class="finance-report-metrics">
            <div class="finance-report-metric">
                <span class="finance-metric-dot income"></span>
                <small>Total Pemasukan</small>
                <strong>Rp 38.500.000</strong>
            </div>
            <div class="finance-report-metric">
                <span class="finance-metric-dot expense"></span>
                <small>Total Pengeluaran</small>
                <strong>Rp 12.800.000</strong>
            </div>
            <div class="finance-report-metric net">
                <span class="finance-metric-dot net-dot"></span>
                <small>Selisih Pemasukan</small>
                <strong>Rp 25.700.000</strong>
            </div>
        </div>

        <div class="finance-chart" role="img" aria-label="Grafik ilustrasi perbandingan pemasukan dan pengeluaran selama enam bulan">
            <div class="finance-chart-legend">
                <span><i class="income"></i> Pemasukan</span>
                <span><i class="expense"></i> Pengeluaran</span>
            </div>
            <div class="finance-bars">
                @foreach ($cashFlow as $month)
                    <div class="finance-bar-group">
                        <div class="finance-bar-pair">
                            <span class="finance-bar income" style="height: {{ $month['income'] }}%"></span>
                            <span class="finance-bar expense" style="height: {{ $month['expense'] }}%"></span>
                        </div>
                        <small>{{ $month['month'] }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <p class="finance-panel-footnote">Ilustrasi laporan bulanan · Angka belum terhubung ke database.</p>
</section>
@endsection
