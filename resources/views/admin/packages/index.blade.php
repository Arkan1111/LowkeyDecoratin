@extends('admin.layouts.app')

@section('title', 'Mengelola Data Paket & Add-on')

@section('content')
<section class="admin-page-heading admin-heading-with-action">
    <div class="admin-heading-accent"></div>
    <div class="admin-heading-copy">
        <p class="admin-eyebrow">MANAJEMEN LAYANAN / PAKET &amp; ADD-ON</p>
        <h1>Mengelola Data Paket &amp; Add-on</h1>
        <p class="admin-page-subtitle">Atur pilihan paket dekorasi, fasilitas, harga, dan layanan tambahan Lowkey Decoration.</p>
    </div>
    <button type="button" class="admin-primary-button" data-modal-open="packageModal">＋ Tambah Paket</button>
</section>

<section class="admin-stats-grid admin-compact-stats">
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-gold"><span>◇</span></div><div class="admin-stat-content"><span class="admin-stat-label">Total Paket</span><div class="admin-stat-value-row"><strong>12</strong><span class="admin-stat-trend trend-neutral">Tersedia</span></div><small>Seluruh paket dekorasi</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-green"><span>✓</span></div><div class="admin-stat-content"><span class="admin-stat-label">Paket Aktif</span><div class="admin-stat-value-row"><strong>10</strong><span class="admin-stat-trend trend-positive">Aktif</span></div><small>Dapat dipilih pelanggan</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-peach"><span>＋</span></div><div class="admin-stat-content"><span class="admin-stat-label">Add-on Layanan</span><div class="admin-stat-value-row"><strong>8</strong><span class="admin-stat-trend trend-neutral">Tersedia</span></div><small>Layanan tambahan</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-gold"><span>Rp</span></div><div class="admin-stat-content"><span class="admin-stat-label">Rentang Harga Paket</span><div class="admin-stat-value-row"><strong class="admin-currency-stat">800 rb–5 jt</strong></div><small>Harga contoh tampilan</small></div><span class="admin-stat-decoration"></span></article>
</section>

<section class="admin-panel admin-feature-panel">
    <div class="admin-panel-heading admin-feature-heading">
        <div class="admin-panel-title-wrap"><span class="admin-panel-icon">▤</span><h2>Daftar Paket &amp; Add-on</h2></div>
        <span class="admin-demo-note">Data contoh tampilan · Belum terhubung ke database</span>
    </div>

    <div class="admin-feature-toolbar">
        <div class="admin-page-tabs" role="tablist">
            <button type="button" class="admin-page-tab active" data-admin-tab="packagesPanel">Paket Dekorasi <span>12</span></button>
            <button type="button" class="admin-page-tab" data-admin-tab="addonsPanel">Add-on <span>8</span></button>
        </div>
        <div class="admin-toolbar-filters">
            <label class="admin-filter-search"><span>⌕</span><input type="search" placeholder="Cari nama paket..." data-table-search="packageTable"></label>
            <select class="admin-select" data-table-filter="packageTable" aria-label="Filter status"><option value="">Semua Status</option><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select>
        </div>
    </div>

    <div id="packagesPanel" class="admin-tab-panel active">
        <div class="admin-table-wrap">
            <table class="admin-data-table" id="packageTable">
                <thead><tr><th>Nama Paket</th><th>Kategori</th><th>Harga Mulai</th><th>Fasilitas</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    <tr><td><strong>Paket Bronze</strong><small>Konsep intimate sederhana</small></td><td>Intimate</td><td>Rp800.000</td><td>5 Fasilitas</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button class="admin-row-action" type="button" data-demo-action="edit">Edit</button><button class="admin-row-action danger" type="button" data-demo-action="delete">Hapus</button></td></tr>
                    <tr><td><strong>Paket Silver</strong><small>Konsep elegan dan modern</small></td><td>Wedding</td><td>Rp1.200.000</td><td>8 Fasilitas</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button class="admin-row-action" type="button" data-demo-action="edit">Edit</button><button class="admin-row-action danger" type="button" data-demo-action="delete">Hapus</button></td></tr>
                    <tr><td><strong>Paket Gold</strong><small>Dekorasi premium dan eksklusif</small></td><td>Wedding</td><td>Rp2.000.000</td><td>12 Fasilitas</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button class="admin-row-action" type="button" data-demo-action="edit">Edit</button><button class="admin-row-action danger" type="button" data-demo-action="delete">Hapus</button></td></tr>
                    <tr><td><strong>Paket Garden</strong><small>Dekorasi outdoor botanical</small></td><td>Outdoor</td><td>Rp3.500.000</td><td>10 Fasilitas</td><td><span class="admin-status status-pending"><i></i>Nonaktif</span></td><td><button class="admin-row-action" type="button" data-demo-action="edit">Edit</button><button class="admin-row-action danger" type="button" data-demo-action="delete">Hapus</button></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="addonsPanel" class="admin-tab-panel">
        <div class="admin-table-wrap">
            <table class="admin-data-table" id="addonTable">
                <thead><tr><th>Nama Add-on</th><th>Kategori</th><th>Harga</th><th>Keterangan</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    <tr><td><strong>Standing Flower</strong><small>Rangkaian bunga tambahan</small></td><td>Floral</td><td>Rp350.000</td><td>Per titik</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button class="admin-row-action" type="button" data-demo-action="edit">Edit</button><button class="admin-row-action danger" type="button" data-demo-action="delete">Hapus</button></td></tr>
                    <tr><td><strong>Welcome Sign</strong><small>Papan sambutan custom</small></td><td>Display</td><td>Rp250.000</td><td>Per unit</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button class="admin-row-action" type="button" data-demo-action="edit">Edit</button><button class="admin-row-action danger" type="button" data-demo-action="delete">Hapus</button></td></tr>
                    <tr><td><strong>Lighting Tambahan</strong><small>Pencahayaan dekoratif</small></td><td>Lighting</td><td>Rp400.000</td><td>Per set</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button class="admin-row-action" type="button" data-demo-action="edit">Edit</button><button class="admin-row-action danger" type="button" data-demo-action="delete">Hapus</button></td></tr>
                    <tr><td><strong>Backdrop Custom</strong><small>Backdrop sesuai tema acara</small></td><td>Dekorasi</td><td>Rp750.000</td><td>Mulai dari</td><td><span class="admin-status status-pending"><i></i>Nonaktif</span></td><td><button class="admin-row-action" type="button" data-demo-action="edit">Edit</button><button class="admin-row-action danger" type="button" data-demo-action="delete">Hapus</button></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="admin-modal" id="packageModal" aria-hidden="true">
    <div class="admin-modal-backdrop" data-modal-close></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="packageModalTitle">
        <div class="admin-modal-heading"><div><p class="admin-eyebrow">DATA LAYANAN</p><h2 id="packageModalTitle">Tambah Paket / Add-on</h2></div><button type="button" class="admin-modal-close" data-modal-close aria-label="Tutup">×</button></div>
        <form class="admin-demo-form" data-demo-form>
            <label>Jenis Data<select required><option value="">Pilih jenis</option><option>Paket Dekorasi</option><option>Add-on</option></select></label>
            <label>Nama Layanan<input type="text" placeholder="Contoh: Paket Silver" required></label>
            <div class="admin-form-two"><label>Harga (Rp)<input type="number" min="0" placeholder="1200000" required></label><label>Status<select><option>Aktif</option><option>Nonaktif</option></select></label></div>
            <label>Deskripsi<textarea rows="3" placeholder="Tuliskan deskripsi singkat layanan"></textarea></label>
            <div class="admin-modal-actions"><button type="button" class="admin-secondary-button" data-modal-close>Batal</button><button type="submit" class="admin-primary-button">Simpan Data</button></div>
        </form>
    </div>
</div>
<div class="admin-toast" role="status" aria-live="polite"></div>
@endsection
