@extends('admin.layouts.app')

@section('title', 'Mengelola Data Reservasi')

@section('content')
<section class="admin-page-heading admin-heading-with-action">
    <div class="admin-heading-accent"></div>
    <div class="admin-heading-copy">
        <p class="admin-eyebrow">MANAJEMEN OPERASIONAL / RESERVASI</p>
        <h1>Mengelola Data Reservasi</h1>
        <p class="admin-page-subtitle">Pantau permintaan pelanggan, periksa detail acara, dan kelola status reservasi.</p>
    </div>
    <button type="button" class="admin-primary-button" data-modal-open="reservationInfoModal">＋ Reservasi Manual</button>
</section>

<section class="admin-stats-grid admin-compact-stats">
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-gold"><span>▦</span></div><div class="admin-stat-content"><span class="admin-stat-label">Total Reservasi</span><div class="admin-stat-value-row"><strong>38</strong></div><small>Seluruh reservasi bulan ini</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-peach"><span>◷</span></div><div class="admin-stat-content"><span class="admin-stat-label">Menunggu Konfirmasi</span><div class="admin-stat-value-row"><strong>8</strong><span class="admin-stat-trend trend-warning">Perlu ditinjau</span></div><small>Belum diproses admin</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-green"><span>✓</span></div><div class="admin-stat-content"><span class="admin-stat-label">Disetujui</span><div class="admin-stat-value-row"><strong>25</strong></div><small>Reservasi terkonfirmasi</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-gold"><span>⊘</span></div><div class="admin-stat-content"><span class="admin-stat-label">Ditolak / Dibatalkan</span><div class="admin-stat-value-row"><strong>5</strong></div><small>Reservasi tidak dilanjutkan</small></div><span class="admin-stat-decoration"></span></article>
</section>

<section class="admin-panel admin-feature-panel">
    <div class="admin-panel-heading admin-feature-heading">
        <div class="admin-panel-title-wrap"><span class="admin-panel-icon">▦</span><h2>Daftar Reservasi Pelanggan</h2></div>
        <span class="admin-demo-note">Data contoh tampilan · Belum terhubung ke database</span>
    </div>
    <div class="admin-feature-toolbar">
        <div class="admin-toolbar-filters admin-toolbar-filters-full">
            <label class="admin-filter-search"><span>⌕</span><input type="search" placeholder="Cari nama pelanggan atau nomor reservasi..." data-table-search="reservationTable"></label>
            <select class="admin-select" data-table-filter="reservationTable" aria-label="Filter status"><option value="">Semua Status</option><option value="Menunggu">Menunggu</option><option value="Disetujui">Disetujui</option><option value="Ditolak">Ditolak</option></select>
            <select class="admin-select" aria-label="Filter jenis acara"><option>Semua Acara</option><option>Pernikahan</option><option>Lamaran</option><option>Khitanan</option></select>
        </div>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-data-table" id="reservationTable">
            <thead><tr><th>No. Reservasi</th><th>Pelanggan</th><th>Jenis Acara</th><th>Paket</th><th>Tanggal Acara</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <tr data-status="Menunggu"><td><strong>#RSV-0261</strong></td><td><span class="admin-customer-cell"><span class="admin-customer-avatar">SA</span>Sarah Anindita</span><small>sarah@email.com</small></td><td>Pernikahan</td><td><span class="admin-package-pill package-gold">Gold</span></td><td>25 Nov 2026</td><td><span class="admin-status status-pending"><i></i>Menunggu</span></td><td><button class="admin-row-action" type="button" data-reservation-detail data-customer="Sarah Anindita" data-code="#RSV-0261" data-event="Pernikahan" data-package="Gold" data-date="25 November 2026" data-location="Gedung Serbaguna" data-status="Menunggu">Detail</button></td></tr>
                <tr data-status="Disetujui"><td><strong>#RSV-0260</strong></td><td><span class="admin-customer-cell"><span class="admin-customer-avatar">RP</span>Rizky Pratama</span><small>rizky@email.com</small></td><td>Lamaran</td><td><span class="admin-package-pill package-silver">Silver</span></td><td>28 Nov 2026</td><td><span class="admin-status status-approved"><i></i>Disetujui</span></td><td><button class="admin-row-action" type="button" data-reservation-detail data-customer="Rizky Pratama" data-code="#RSV-0260" data-event="Lamaran" data-package="Silver" data-date="28 November 2026" data-location="Rumah Keluarga" data-status="Disetujui">Detail</button></td></tr>
                <tr data-status="Menunggu"><td><strong>#RSV-0259</strong></td><td><span class="admin-customer-cell"><span class="admin-customer-avatar">NP</span>Nadia Putri</span><small>nadia@email.com</small></td><td>Pernikahan</td><td><span class="admin-package-pill package-gold">Gold</span></td><td>02 Des 2026</td><td><span class="admin-status status-pending"><i></i>Menunggu</span></td><td><button class="admin-row-action" type="button" data-reservation-detail data-customer="Nadia Putri" data-code="#RSV-0259" data-event="Pernikahan" data-package="Gold" data-date="2 Desember 2026" data-location="Ballroom Hotel" data-status="Menunggu">Detail</button></td></tr>
                <tr data-status="Disetujui"><td><strong>#RSV-0258</strong></td><td><span class="admin-customer-cell"><span class="admin-customer-avatar">DA</span>Dimas Ardi</span><small>dimas@email.com</small></td><td>Wedding Party</td><td><span class="admin-package-pill package-bronze">Bronze</span></td><td>06 Des 2026</td><td><span class="admin-status status-approved"><i></i>Disetujui</span></td><td><button class="admin-row-action" type="button" data-reservation-detail data-customer="Dimas Ardi" data-code="#RSV-0258" data-event="Wedding Party" data-package="Bronze" data-date="6 Desember 2026" data-location="Outdoor Venue" data-status="Disetujui">Detail</button></td></tr>
                <tr data-status="Ditolak"><td><strong>#RSV-0257</strong></td><td><span class="admin-customer-cell"><span class="admin-customer-avatar">MW</span>Maya Wulandari</span><small>maya@email.com</small></td><td>Lamaran</td><td><span class="admin-package-pill package-silver">Silver</span></td><td>10 Des 2026</td><td><span class="admin-status status-rejected"><i></i>Ditolak</span></td><td><button class="admin-row-action" type="button" data-reservation-detail data-customer="Maya Wulandari" data-code="#RSV-0257" data-event="Lamaran" data-package="Silver" data-date="10 Desember 2026" data-location="Rumah Keluarga" data-status="Ditolak">Detail</button></td></tr>
            </tbody>
        </table>
    </div>
    <div class="admin-table-footer"><span>Menampilkan 5 dari 38 reservasi</span><div class="admin-pagination"><button type="button" disabled>‹</button><button type="button" class="active">1</button><button type="button">2</button><button type="button">3</button><button type="button">›</button></div></div>
</section>

<div class="admin-modal" id="reservationDetailModal" aria-hidden="true">
    <div class="admin-modal-backdrop" data-modal-close></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="reservationDetailTitle">
        <div class="admin-modal-heading"><div><p class="admin-eyebrow">INFORMASI RESERVASI</p><h2 id="reservationDetailTitle">Detail Reservasi</h2></div><button type="button" class="admin-modal-close" data-modal-close>×</button></div>
        <dl class="admin-detail-list">
            <div><dt>Nomor Reservasi</dt><dd id="detailCode">-</dd></div>
            <div><dt>Nama Pelanggan</dt><dd id="detailCustomer">-</dd></div>
            <div><dt>Jenis Acara</dt><dd id="detailEvent">-</dd></div>
            <div><dt>Paket Dekorasi</dt><dd id="detailPackage">-</dd></div>
            <div><dt>Tanggal Acara</dt><dd id="detailDate">-</dd></div>
            <div><dt>Lokasi Acara</dt><dd id="detailLocation">-</dd></div>
            <div><dt>Status</dt><dd id="detailStatus">-</dd></div>
        </dl>
        <div class="admin-modal-actions"><button type="button" class="admin-secondary-button" data-modal-close>Tutup</button></div>
    </div>
</div>
<div class="admin-modal" id="reservationInfoModal" aria-hidden="true">
    <div class="admin-modal-backdrop" data-modal-close></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true">
        <div class="admin-modal-heading"><div><p class="admin-eyebrow">INFORMASI</p><h2>Reservasi Manual</h2></div><button type="button" class="admin-modal-close" data-modal-close>×</button></div>
        <p class="admin-modal-description">Form reservasi manual akan dihubungkan dengan proses penyimpanan data pada tahap integrasi backend.</p>
        <div class="admin-modal-actions"><button type="button" class="admin-primary-button" data-modal-close>Mengerti</button></div>
    </div>
</div>
<div class="admin-toast" role="status" aria-live="polite"></div>
@endsection
