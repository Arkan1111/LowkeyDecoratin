@extends('admin.layouts.app')

@section('title', 'Mengelola Data Pengguna')

@section('content')
<section class="admin-page-heading admin-heading-with-action">
    <div class="admin-heading-accent"></div>
    <div class="admin-heading-copy">
        <p class="admin-eyebrow">MANAJEMEN AKUN / PENGGUNA</p>
        <h1>Mengelola Data Pengguna</h1>
        <p class="admin-page-subtitle">Kelola akun pelanggan dan tim yang memiliki akses ke sistem Loki Decoration.</p>
    </div>
    <button type="button" class="admin-primary-button" data-modal-open="userModal">＋ Tambah Pengguna</button>
</section>

<section class="admin-stats-grid admin-compact-stats">
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-gold"><span>♙</span></div><div class="admin-stat-content"><span class="admin-stat-label">Total Pengguna</span><div class="admin-stat-value-row"><strong>126</strong></div><small>Seluruh akun terdaftar</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-green"><span>✓</span></div><div class="admin-stat-content"><span class="admin-stat-label">Akun Aktif</span><div class="admin-stat-value-row"><strong>119</strong></div><small>Dapat mengakses sistem</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-peach"><span>♧</span></div><div class="admin-stat-content"><span class="admin-stat-label">Pelanggan</span><div class="admin-stat-value-row"><strong>118</strong></div><small>Akun customer</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-gold"><span>♙</span></div><div class="admin-stat-content"><span class="admin-stat-label">Admin &amp; Tim</span><div class="admin-stat-value-row"><strong>8</strong></div><small>Pengelola operasional</small></div><span class="admin-stat-decoration"></span></article>
</section>

<section class="admin-panel admin-feature-panel">
    <div class="admin-panel-heading admin-feature-heading">
        <div class="admin-panel-title-wrap"><span class="admin-panel-icon">♙</span><h2>Daftar Pengguna</h2></div>
        <span class="admin-demo-note">Data contoh tampilan · Belum terhubung ke database</span>
    </div>
    <div class="admin-feature-toolbar">
        <div class="admin-toolbar-filters admin-toolbar-filters-full">
            <label class="admin-filter-search"><span>⌕</span><input type="search" placeholder="Cari nama atau email pengguna..." data-table-search="userTable"></label>
            <select class="admin-select" data-table-filter="userTable" aria-label="Filter role"><option value="">Semua Role</option><option value="Customer">Customer</option><option value="Admin">Admin</option><option value="Staff">Staff</option></select>
            <select class="admin-select" aria-label="Filter status"><option>Semua Status</option><option>Aktif</option><option>Nonaktif</option></select>
        </div>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-data-table" id="userTable">
            <thead><tr><th>Pengguna</th><th>Email</th><th>Role</th><th>Tanggal Bergabung</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <tr><td><span class="admin-customer-cell"><span class="admin-customer-avatar">SA</span>Sarah Anindita</span></td><td>sarah@email.com</td><td><span class="admin-role-pill role-customer">Customer</span></td><td>12 Okt 2026</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button type="button" class="admin-row-action" data-demo-action="edit">Edit</button></td></tr>
                <tr><td><span class="admin-customer-cell"><span class="admin-customer-avatar">RP</span>Rizky Pratama</span></td><td>rizky@email.com</td><td><span class="admin-role-pill role-customer">Customer</span></td><td>18 Okt 2026</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button type="button" class="admin-row-action" data-demo-action="edit">Edit</button></td></tr>
                <tr><td><span class="admin-customer-cell"><span class="admin-customer-avatar">AD</span>Admin Decoration</span></td><td>admin@lokidecoration.test</td><td><span class="admin-role-pill role-admin">Admin</span></td><td>01 Sep 2026</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button type="button" class="admin-row-action" data-demo-action="edit">Edit</button></td></tr>
                <tr><td><span class="admin-customer-cell"><span class="admin-customer-avatar">ST</span>Staff Operasional</span></td><td>staff@lokidecoration.test</td><td><span class="admin-role-pill role-staff">Staff</span></td><td>10 Sep 2026</td><td><span class="admin-status status-approved"><i></i>Aktif</span></td><td><button type="button" class="admin-row-action" data-demo-action="edit">Edit</button></td></tr>
                <tr><td><span class="admin-customer-cell"><span class="admin-customer-avatar">MW</span>Maya Wulandari</span></td><td>maya@email.com</td><td><span class="admin-role-pill role-customer">Customer</span></td><td>21 Okt 2026</td><td><span class="admin-status status-pending"><i></i>Nonaktif</span></td><td><button type="button" class="admin-row-action" data-demo-action="edit">Edit</button></td></tr>
            </tbody>
        </table>
    </div>
    <div class="admin-table-footer"><span>Menampilkan 5 dari 126 pengguna</span><div class="admin-pagination"><button type="button" disabled>‹</button><button type="button" class="active">1</button><button type="button">2</button><button type="button">3</button><button type="button">›</button></div></div>
</section>

<div class="admin-modal" id="userModal" aria-hidden="true">
    <div class="admin-modal-backdrop" data-modal-close></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="userModalTitle">
        <div class="admin-modal-heading"><div><p class="admin-eyebrow">AKUN SISTEM</p><h2 id="userModalTitle">Tambah Pengguna</h2></div><button type="button" class="admin-modal-close" data-modal-close>×</button></div>
        <form class="admin-demo-form" data-demo-form>
            <label>Nama Lengkap<input type="text" placeholder="Masukkan nama lengkap" required></label>
            <label>Alamat Email<input type="email" placeholder="nama@email.com" required></label>
            <div class="admin-form-two"><label>Role<select required><option value="">Pilih role</option><option>Customer</option><option>Admin</option><option>Staff</option></select></label><label>Status<select><option>Aktif</option><option>Nonaktif</option></select></label></div>
            <p class="admin-modal-description">Pembuatan akun dan pengaturan kata sandi akan dihubungkan pada tahap integrasi backend.</p>
            <div class="admin-modal-actions"><button type="button" class="admin-secondary-button" data-modal-close>Batal</button><button type="submit" class="admin-primary-button">Simpan Pengguna</button></div>
        </form>
    </div>
</div>
<div class="admin-toast" role="status" aria-live="polite"></div>
@endsection
