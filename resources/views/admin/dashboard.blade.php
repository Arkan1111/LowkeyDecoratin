@extends('admin.layouts.app')

@section('title', 'Dashboard Operasional')

@section('content')
<section class="admin-page-heading">
    <div class="admin-heading-accent"></div>
    <div>
        <p class="admin-eyebrow">OPERASIONAL / RINGKASAN</p>
        <h1>Dashboard Operasional</h1>
        <p class="admin-page-subtitle">Ringkasan aktivitas dan kondisi operasional Loki Decoration.</p>
    </div>
</section>

{{-- STATISTIK UTAMA --}}
<section class="admin-stats-grid" aria-label="Ringkasan statistik">
    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="5" width="18" height="16" rx="2" />
                <path d="M16 3v4M8 3v4M3 10h18" />
            </svg>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Total Reservasi</span>
            <div class="admin-stat-value-row"><strong>38</strong><span class="admin-stat-trend trend-positive">↑ 12%</span></div>
            <small>Pemesanan bulan ini</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-peach">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7v5l3 2" />
            </svg>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Menunggu Konfirmasi</span>
            <div class="admin-stat-value-row"><strong>8</strong><span class="admin-stat-trend trend-warning">Perlu tindakan</span></div>
            <small>Reservasi belum dikonfirmasi</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-green">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9" />
                <path d="m8 12 2.5 2.5L16.5 9" />
            </svg>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Reservasi Disetujui</span>
            <div class="admin-stat-value-row"><strong>25</strong><span class="admin-stat-trend trend-positive">↑ 18%</span></div>
            <small>Pemesanan telah disetujui</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z" />
                <path d="m4.5 7.7 7.5 4.4 7.5-4.4M12 12.1V21" />
            </svg>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Paket Dekorasi</span>
            <div class="admin-stat-value-row"><strong>12</strong><span class="admin-stat-trend trend-neutral">Aktif</span></div>
            <small>Paket layanan yang tersedia</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>
</section>

{{-- RESERVASI TERBARU DAN JADWAL MENDATANG --}}
<section class="admin-dashboard-grid">
    <article class="admin-panel admin-reservations-panel">
        <div class="admin-panel-heading">
            <div class="admin-panel-title-wrap">
                <span class="admin-panel-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path d="M16 3v4M8 3v4M3 10h18" />
                    </svg>
                </span>
                <h2>Reservasi Terbaru</h2>
            </div>
            <a href="#" class="admin-panel-link" aria-disabled="true">Lihat Semua <span>→</span></a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-reservation-table">
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Acara</th>
                        <th>Paket</th>
                        <th>Tanggal Acara</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="admin-customer-cell"><span class="admin-customer-avatar">SA</span>Sarah Anindita</span></td>
                        <td>Pernikahan</td>
                        <td><span class="admin-package-pill package-gold">Gold</span></td>
                        <td>25 Nov 2026</td>
                        <td><span class="admin-status status-pending"><i></i>Menunggu</span></td>
                    </tr>
                    <tr>
                        <td><span class="admin-customer-cell"><span class="admin-customer-avatar">RP</span>Rizky Pratama</span></td>
                        <td>Lamaran</td>
                        <td><span class="admin-package-pill package-silver">Silver</span></td>
                        <td>28 Nov 2026</td>
                        <td><span class="admin-status status-approved"><i></i>Disetujui</span></td>
                    </tr>
                    <tr>
                        <td><span class="admin-customer-cell"><span class="admin-customer-avatar">NP</span>Nadia Putri</span></td>
                        <td>Pernikahan</td>
                        <td><span class="admin-package-pill package-gold">Gold</span></td>
                        <td>02 Des 2026</td>
                        <td><span class="admin-status status-pending"><i></i>Menunggu</span></td>
                    </tr>
                    <tr>
                        <td><span class="admin-customer-cell"><span class="admin-customer-avatar">DA</span>Dimas Ardi</span></td>
                        <td>Wedding Party</td>
                        <td><span class="admin-package-pill package-bronze">Bronze</span></td>
                        <td>06 Des 2026</td>
                        <td><span class="admin-status status-approved"><i></i>Disetujui</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="admin-demo-note">Data contoh tampilan · Belum terhubung ke database</p>
    </article>

    <article class="admin-panel admin-schedule-panel">
        <div class="admin-panel-heading">
            <div class="admin-panel-title-wrap">
                <span class="admin-panel-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path d="M16 3v4M8 3v4M3 10h18" />
                    </svg>
                </span>
                <h2>Jadwal Acara Mendatang</h2>
            </div>
            <a href="#" class="admin-panel-link" aria-disabled="true">Lihat Kalender <span>→</span></a>
        </div>

        <div class="admin-event-list">
            <div class="admin-event-item">
                <div class="admin-event-date"><strong>25</strong><span>Nov</span></div>
                <div class="admin-event-info">
                    <strong>Pernikahan Sarah &amp; Andi</strong>
                    <span><b>⌖</b> Gedung Serbaguna · Paket Gold</span>
                </div>
                <span class="admin-status status-approved"><i></i>Terkonfirmasi</span>
            </div>

            <div class="admin-event-item">
                <div class="admin-event-date"><strong>28</strong><span>Nov</span></div>
                <div class="admin-event-info">
                    <strong>Lamaran Rizky &amp; Nabila</strong>
                    <span><b>⌖</b> Rumah Keluarga · Paket Silver</span>
                </div>
                <span class="admin-status status-approved"><i></i>Terkonfirmasi</span>
            </div>

            <div class="admin-event-item">
                <div class="admin-event-date"><strong>02</strong><span>Des</span></div>
                <div class="admin-event-info">
                    <strong>Pernikahan Nadia &amp; Fajar</strong>
                    <span><b>⌖</b> Ballroom Hotel · Paket Gold</span>
                </div>
                <span class="admin-status status-pending"><i></i>Menunggu</span>
            </div>

            <div class="admin-event-item">
                <div class="admin-event-date"><strong>06</strong><span>Des</span></div>
                <div class="admin-event-info">
                    <strong>Wedding Party Dimas &amp; Ara</strong>
                    <span><b>⌖</b> Outdoor Venue · Paket Bronze</span>
                </div>
                <span class="admin-status status-approved"><i></i>Terkonfirmasi</span>
            </div>
        </div>
        <p class="admin-demo-note">Jadwal contoh tampilan · Belum terhubung ke database</p>
    </article>
</section>
@endsection