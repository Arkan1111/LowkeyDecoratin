<aside class="admin-sidebar">
    <a href="{{ url('/admin/dashboard') }}" class="admin-brand" aria-label="Loki Decoration Dashboard">
        <span class="admin-brand-copy">
            <strong>Lowkey Decoration</strong>
            <small>WEDDING ORGANIZER</small>
        </span>
    </a>

    <div class="admin-sidebar-divider"></div>
    <p class="admin-sidebar-caption">MANAJEMEN OPERASIONAL</p>

    <nav class="admin-nav" aria-label="Navigasi admin">
        <a href="{{ url('/admin/dashboard') }}" class="admin-nav-link active" aria-current="page">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="8" height="8" rx="1.5" />
                <rect x="13" y="3" width="8" height="8" rx="1.5" />
                <rect x="3" y="13" width="8" height="8" rx="1.5" />
                <rect x="13" y="13" width="8" height="8" rx="1.5" />
            </svg>
            <span>Dashboard Operasional</span>
            <i></i>
        </a>

        <a href="#" class="admin-nav-link admin-nav-placeholder" aria-disabled="true" title="Menu paket akan dihubungkan nanti">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m12 3 8.5 4.7v8.6L12 21l-8.5-4.7V7.7L12 3Z" />
                <path d="m3.8 7.8 8.2 4.6 8.2-4.6M12 12.4V21" />
            </svg>
            <span>Mengelola Data Paket &amp; Add-on</span>
        </a>

        <a href="#" class="admin-nav-link admin-nav-placeholder" aria-disabled="true" title="Menu reservasi akan dihubungkan nanti">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="5" width="18" height="16" rx="2" />
                <path d="M16 3v4M8 3v4M3 10h18" />
            </svg>
            <span>Mengelola Data Reservasi</span>
        </a>

        <a href="#" class="admin-nav-link admin-nav-placeholder" aria-disabled="true" title="Menu portofolio akan dihubungkan nanti">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <circle cx="8.5" cy="8.5" r="1.5" />
                <path d="m21 15-5-5L5 21" />
            </svg>
            <span>Mengelola Konten &amp; Portofolio</span>
        </a>

        <a href="#" class="admin-nav-link admin-nav-placeholder" aria-disabled="true" title="Menu pengguna akan dihubungkan nanti">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="8" r="4" />
                <path d="M4 21c.5-4 3.5-6 8-6s7.5 2 8 6" />
            </svg>
            <span>Mengelola Data Pengguna</span>
        </a>

        
    </nav>

    {{-- LOGOUT --}}
    <div class="sidebar-logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="logout-button">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M10 17l5-5-5-5" />
                    <path d="M15 12H3" />
                    <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
    
</aside>