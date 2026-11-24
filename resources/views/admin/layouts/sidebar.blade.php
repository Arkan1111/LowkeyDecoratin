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
        <a href="{{ url('/admin/dashboard') }}" class="admin-nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" @if(request()->is('admin/dashboard')) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="8" height="8" rx="1.5" />
                <rect x="13" y="3" width="8" height="8" rx="1.5" />
                <rect x="3" y="13" width="8" height="8" rx="1.5" />
                <rect x="13" y="13" width="8" height="8" rx="1.5" />
            </svg>
            <span>Dashboard Operasional</span><i></i>
        </a>

        <a href="{{ url('/admin/paket') }}" class="admin-nav-link {{ request()->is('admin/paket*') ? 'active' : '' }}" @if(request()->is('admin/paket*')) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m12 3 8.5 4.7v8.6L12 21l-8.5-4.7V7.7L12 3Z" />
                <path d="m3.8 7.8 8.2 4.6 8.2-4.6M12 12.4V21" />
            </svg>
            <span>Mengelola Data Paket &amp; Add-on</span><i></i>
        </a>

        <a href="{{ url('/admin/reservasi') }}" class="admin-nav-link {{ request()->is('admin/reservasi*') ? 'active' : '' }}" @if(request()->is('admin/reservasi*')) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="5" width="18" height="16" rx="2" />
                <path d="M16 3v4M8 3v4M3 10h18" />
            </svg>
            <span>Mengelola Data Reservasi</span><i></i>
        </a>

        <a href="{{ url('/admin/portofolio') }}" class="admin-nav-link {{ request()->is('admin/portofolio*') ? 'active' : '' }}" @if(request()->is('admin/portofolio*')) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <circle cx="8.5" cy="8.5" r="1.5" />
                <path d="m21 15-5-5L5 21" />
            </svg>
            <span>Mengelola Konten &amp; Portofolio</span><i></i>
        </a>

        <a href="{{ url('/admin/pengguna') }}" class="admin-nav-link {{ request()->is('admin/pengguna*') ? 'active' : '' }}" @if(request()->is('admin/pengguna*')) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="8" r="4" />
                <path d="M4 21c.5-4 3.5-6 8-6s7.5 2 8 6" />
            </svg>
            <span>Mengelola Data Pengguna</span><i></i>
        </a>
    </nav>

    <form class="admin-nav admin-sidebar-bottom" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="admin-nav-link admin-nav-logout">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M10 17l5-5-5-5M15 12H3" />
                <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" />
            </svg>
            <span>Logout</span><i></i>
        </button>
    </form>
</aside>