<aside class="finance-sidebar" id="financeSidebar">
    <a href="{{ url('/keuangan/dashboard') }}" class="finance-brand">
        <span class="finance-brand-name">Lowkey Decoration</span>
        <span class="finance-brand-subtitle">WEDDING ORGANIZER</span>
    </a>

    <div class="finance-sidebar-divider"></div>

    <p class="finance-sidebar-label">MANAJEMEN KEUANGAN</p>

    <nav class="finance-nav" aria-label="Navigasi keuangan">
        <a href="{{ url('/keuangan/dashboard') }}" class="finance-nav-link active" aria-current="page">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="8" height="8" rx="1.5" />
                <rect x="14" y="3" width="7" height="5" rx="1.5" />
                <rect x="14" y="11" width="7" height="10" rx="1.5" />
                <rect x="3" y="14" width="8" height="7" rx="1.5" />
            </svg>
            <span>Dashboard Keuangan</span>
            <i></i>
        </a>

        <a href="{{ url('/keuangan/pembayaran') }}" class="finance-nav-link">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="2.8" y="5" width="18.4" height="14" rx="2" />
                <path d="M3 9h18M7 14h4" />
            </svg>
            <span>Mengelola Pembayaran</span>
        </a>

        <a href="{{ url('/keuangan/kas-kecil') }}" class="finance-nav-link">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="5" width="18" height="15" rx="2" />
                <path d="M3 9h18M7 15h4m6-3h.01" />
                <path d="M7 5V3m10 2V3" />
            </svg>
            <span>Mencatat Kas Kecil</span>
        </a>

        <a href="{{ url('/keuangan/laporan') }}" class="finance-nav-link">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 19.5V4.8A1.8 1.8 0 0 1 5.8 3H20v18H5.8A1.8 1.8 0 0 1 4 19.5Z" />
                <path d="M8 16v-3m4 3V8m4 8v-5M4 19.5A1.5 1.5 0 0 0 5.5 21H20" />
            </svg>
            <span>Melihat Laporan Keuangan</span>
        </a>

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