<header class="admin-topbar">
    <div class="admin-search">
        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
        <input type="search" placeholder="Cari reservasi, pelanggan, atau paket..." aria-label="Cari reservasi, pelanggan, atau paket">
    </div>

    <div class="admin-topbar-actions">
        <div class="admin-date-chip">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg>
            <span>{{ now()->locale('id')->translatedFormat('l, d M Y') }}</span>
        </div>

        <button type="button" class="admin-icon-button" aria-label="Notifikasi">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
            <i></i>
        </button>

        <button type="button" class="admin-profile-button" aria-label="Profil admin">
            <span class="admin-avatar">A</span>
            <span class="admin-profile-name">Admin</span>
            <svg class="admin-chevron" viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
        </button>
    </div>
</header>
