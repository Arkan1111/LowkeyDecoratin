@extends('admin.layouts.app')

@section('title', 'Mengelola Konten & Portofolio')

@section('content')
<section class="admin-page-heading admin-heading-with-action">
    <div class="admin-heading-accent"></div>
    <div class="admin-heading-copy">
        <p class="admin-eyebrow">MANAJEMEN KONTEN / PORTOFOLIO</p>
        <h1>Mengelola Konten &amp; Portofolio</h1>
        <p class="admin-page-subtitle">Kelola dokumentasi dekorasi dan konten yang ditampilkan pada halaman Customer.</p>
    </div>
    <button type="button" class="admin-primary-button" data-modal-open="portfolioModal">＋ Tambah Dokumentasi</button>
</section>

<section class="admin-stats-grid admin-compact-stats">
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-gold"><span>▧</span></div><div class="admin-stat-content"><span class="admin-stat-label">Total Dokumentasi</span><div class="admin-stat-value-row"><strong>36</strong></div><small>Seluruh portofolio</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-green"><span>✓</span></div><div class="admin-stat-content"><span class="admin-stat-label">Ditampilkan</span><div class="admin-stat-value-row"><strong>30</strong></div><small>Terpublikasi di halaman Customer</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-peach"><span>◷</span></div><div class="admin-stat-content"><span class="admin-stat-label">Draft</span><div class="admin-stat-value-row"><strong>6</strong></div><small>Belum dipublikasikan</small></div><span class="admin-stat-decoration"></span></article>
    <article class="admin-stat-card"><div class="admin-stat-icon stat-icon-gold"><span>▤</span></div><div class="admin-stat-content"><span class="admin-stat-label">Kategori Konten</span><div class="admin-stat-value-row"><strong>4</strong></div><small>Pernikahan, lamaran, dan lainnya</small></div><span class="admin-stat-decoration"></span></article>
</section>

<section class="admin-panel admin-feature-panel">
    <div class="admin-panel-heading admin-feature-heading">
        <div class="admin-panel-title-wrap"><span class="admin-panel-icon">▧</span><h2>Dokumentasi Portofolio</h2></div>
        <span class="admin-demo-note">Data contoh tampilan · Belum terhubung ke database</span>
    </div>
    <div class="admin-feature-toolbar">
        <div class="admin-page-tabs" role="tablist">
            <button type="button" class="admin-page-tab active" data-portfolio-filter="all">Semua <span>36</span></button>
            <button type="button" class="admin-page-tab" data-portfolio-filter="Pernikahan">Pernikahan</button>
            <button type="button" class="admin-page-tab" data-portfolio-filter="Lamaran">Lamaran</button>
            <button type="button" class="admin-page-tab" data-portfolio-filter="Lainnya">Lainnya</button>
        </div>
        <div class="admin-toolbar-filters"><label class="admin-filter-search"><span>⌕</span><input type="search" placeholder="Cari dokumentasi..." data-card-search="portfolioGrid"></label></div>
    </div>

    <div class="admin-portfolio-grid" id="portfolioGrid">
        <article class="admin-portfolio-card" data-category="Pernikahan">
            <div class="admin-portfolio-image"><img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=85" alt="Dekorasi pernikahan klasik"><span class="admin-status status-approved"><i></i>Dipublikasikan</span></div>
            <div class="admin-portfolio-body"><div class="admin-portfolio-meta"><span>Pernikahan</span><small>12 Nov 2026</small></div><h3>Elegant White Wedding</h3><p>Dekorasi floral putih dengan nuansa hangat dan elegan.</p><div class="admin-portfolio-actions"><button type="button" class="admin-row-action" data-demo-action="edit">Edit</button><button type="button" class="admin-row-action danger" data-demo-action="delete">Hapus</button></div></div>
        </article>
        <article class="admin-portfolio-card" data-category="Lamaran">
            <div class="admin-portfolio-image"><img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=800&q=85" alt="Dekorasi lamaran"><span class="admin-status status-approved"><i></i>Dipublikasikan</span></div>
            <div class="admin-portfolio-body"><div class="admin-portfolio-meta"><span>Lamaran</span><small>08 Nov 2026</small></div><h3>Warm Terracotta Engagement</h3><p>Konsep intimate dengan sentuhan warna terracotta.</p><div class="admin-portfolio-actions"><button type="button" class="admin-row-action" data-demo-action="edit">Edit</button><button type="button" class="admin-row-action danger" data-demo-action="delete">Hapus</button></div></div>
        </article>
        <article class="admin-portfolio-card" data-category="Pernikahan">
            <div class="admin-portfolio-image"><img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?auto=format&fit=crop&w=800&q=85" alt="Dekorasi ballroom"><span class="admin-status status-pending"><i></i>Draft</span></div>
            <div class="admin-portfolio-body"><div class="admin-portfolio-meta"><span>Pernikahan</span><small>05 Nov 2026</small></div><h3>Royal Ballroom Grandeur</h3><p>Penataan ballroom dengan detail floral premium.</p><div class="admin-portfolio-actions"><button type="button" class="admin-row-action" data-demo-action="edit">Edit</button><button type="button" class="admin-row-action danger" data-demo-action="delete">Hapus</button></div></div>
        </article>
        <article class="admin-portfolio-card" data-category="Lainnya">
            <div class="admin-portfolio-image"><img src="https://images.unsplash.com/photo-1507504031003-b417219a0fde?auto=format&fit=crop&w=800&q=85" alt="Dekorasi outdoor"><span class="admin-status status-approved"><i></i>Dipublikasikan</span></div>
            <div class="admin-portfolio-body"><div class="admin-portfolio-meta"><span>Lainnya</span><small>01 Nov 2026</small></div><h3>Botanical Garden Party</h3><p>Konsep outdoor dengan elemen natural dan greenery.</p><div class="admin-portfolio-actions"><button type="button" class="admin-row-action" data-demo-action="edit">Edit</button><button type="button" class="admin-row-action danger" data-demo-action="delete">Hapus</button></div></div>
        </article>
    </div>
</section>

<div class="admin-modal" id="portfolioModal" aria-hidden="true">
    <div class="admin-modal-backdrop" data-modal-close></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="portfolioModalTitle">
        <div class="admin-modal-heading"><div><p class="admin-eyebrow">KONTEN WEBSITE</p><h2 id="portfolioModalTitle">Tambah Dokumentasi</h2></div><button type="button" class="admin-modal-close" data-modal-close>×</button></div>
        <form class="admin-demo-form" data-demo-form>
            <label>Judul Dokumentasi<input type="text" placeholder="Contoh: Elegant White Wedding" required></label>
            <div class="admin-form-two"><label>Kategori<select required><option value="">Pilih kategori</option><option>Pernikahan</option><option>Lamaran</option><option>Lainnya</option></select></label><label>Status Publikasi<select><option>Draft</option><option>Dipublikasikan</option></select></label></div>
            <label>Lokasi / Venue<input type="text" placeholder="Nama gedung atau lokasi acara"></label>
            <label>Deskripsi<textarea rows="3" placeholder="Deskripsi singkat dokumentasi"></textarea></label>
            <label>Foto Dokumentasi<input type="file" accept="image/*"></label>
            <div class="admin-modal-actions"><button type="button" class="admin-secondary-button" data-modal-close>Batal</button><button type="submit" class="admin-primary-button">Simpan Dokumentasi</button></div>
        </form>
    </div>
</div>
<div class="admin-toast" role="status" aria-live="polite"></div>
@endsection
