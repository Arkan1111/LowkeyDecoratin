@extends('admin.layouts.app')

@section('title', 'Mengelola Konten & Portofolio')

@section('content')
<section class="admin-page-heading admin-heading-with-action">
    <div class="admin-heading-accent"></div>
    <div class="admin-heading-copy">
        <p class="admin-eyebrow">MANAJEMEN KONTEN / PORTOFOLIO</p>
        <h1>Mengelola Konten & Portofolio</h1>
        <p class="admin-page-subtitle">Kelola dokumentasi dekorasi dan konten yang ditampilkan pada halaman Customer.</p>
    </div>
    <button type="button" class="admin-primary-button" onclick="openPortfolioModal()">＋ Tambah Dokumentasi</button>
</section>

{{-- NOTIFIKASI --}}
@if(session('success'))
<div style="background: #e6f4ea; border-left: 4px solid #34a853; color: #137333; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
    ✓ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background: #fce8e6; border-left: 4px solid #ea4335; color: #c5221f; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
    ✕ {{ session('error') }}
</div>
@endif

@if($errors->any())
<div style="background: #fce8e6; border-left: 4px solid #ea4335; color: #c5221f; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
    <strong>Gagal menyimpan data:</strong>
    <ul style="margin: 6px 0 0 20px;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- STATISTIK DINAMIS --}}
<section class="admin-stats-grid admin-compact-stats">
    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold"><span>▧</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Total Dokumentasi</span>
            <div class="admin-stat-value-row"><strong>{{ $totalCount }}</strong></div>
            <small>Seluruh portofolio</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-green"><span>✓</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Ditampilkan</span>
            <div class="admin-stat-value-row"><strong>{{ $publishedCount }}</strong></div>
            <small>Terpublikasi di halaman Customer</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-peach"><span>◷</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Draft</span>
            <div class="admin-stat-value-row"><strong>{{ $draftCount }}</strong></div>
            <small>Belum dipublikasikan</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold"><span>▤</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Kategori Konten</span>
            <div class="admin-stat-value-row"><strong>{{ $categoriesCount }}</strong></div>
            <small>Pernikahan, lamaran, dan lainnya</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>
</section>

{{-- FILTER & SEARCH --}}
<section class="admin-panel admin-feature-panel">
    <div class="admin-panel-heading admin-feature-heading">
        <div class="admin-panel-title-wrap"><span class="admin-panel-icon">▧</span><h2>Dokumentasi Portofolio</h2></div>
    </div>

    <form method="GET" action="{{ route('admin.portfolio') }}" class="admin-feature-toolbar">
        <div class="admin-page-tabs" role="tablist">
            <button type="submit" name="category" value="" class="admin-page-tab {{ !request('category') ? 'active' : '' }}" style="border:none; background:none; cursor:pointer; padding:8px 16px;">
                Semua <span>{{ $totalCount }}</span>
            </button>
            @foreach($categories as $catName)
                <button type="submit" name="category" value="{{ $catName }}" class="admin-page-tab {{ request('category') === $catName ? 'active' : '' }}" style="border:none; background:none; cursor:pointer; padding:8px 16px;">
                    {{ $catName }} <span>{{ \App\Models\Inspiration::whereHas('category', fn($q) => $q->where('name', $catName))->count() }}</span>
                </button>
            @endforeach
        </div>
        <div class="admin-toolbar-filters">
            <label class="admin-filter-search"><span>⌕</span><input type="search" name="search" value="{{ request('search') }}" placeholder="Cari dokumentasi..."></label>
            @if(request('search') || request('category'))
                <a href="{{ route('admin.portfolio') }}" style="font-size: 13px; color: #888; text-decoration: underline; align-self: center;">Reset Filter</a>
            @endif
        </div>
    </form>

    {{-- PORTFOLIO GRID --}}
    <div class="admin-portfolio-grid" id="portfolioGrid">
        @forelse ($inspirations as $item)
        <article class="admin-portfolio-card" data-category="{{ $item->category->name ?? 'Lainnya' }}">
            <div class="admin-portfolio-image">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}">
                <span class="admin-status {{ $item->is_featured ? 'status-approved' : 'status-pending' }}">
                    <i></i>{{ $item->is_featured ? 'Dipublikasikan' : 'Draft' }}
                </span>
            </div>
            <div class="admin-portfolio-body">
                <div class="admin-portfolio-meta">
                    <span>{{ $item->category->name ?? 'Lainnya' }}</span>
                    <small>{{ $item->created_at->translatedFormat('d M Y') }}</small>
                </div>
                <h3>{{ $item->title }}</h3>
                <p>{{ Str::limit($item->description, 80) }}</p>
                <div class="admin-portfolio-actions">
                    <button class="admin-row-action" type="button" onclick="editPortfolio({{ json_encode($item->load('category', 'package')) }})">Edit</button>
                    <form action="{{ route('admin.portfolio.toggle-featured', $item->id) }}" method="POST" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="admin-row-action" style="background:none; border:none; padding:0; cursor:pointer;">
                            @if($item->is_featured)
                                <span style="color:#666;">Draft</span>
                            @else
                                <span style="color:#34a853;">Publikasikan</span>
                            @endif
                        </button>
                    </form>
                    <form action="{{ route('admin.portfolio.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi {{ $item->title }}?');">
                        @csrf @method('DELETE')
                        <button class="admin-row-action danger" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </article>
        @empty
        <div style="grid-column: 1/-1; text-align:center; padding:40px; color:#777;">
            Belum ada dokumentasi portofolio. Klik <strong>＋ Tambah Dokumentasi</strong> untuk membuat yang baru.
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($inspirations->hasPages())
    <div class="admin-table-footer" style="padding: 15px; display:flex; justify-content:space-between; align-items:center;">
        <span>Menampilkan {{ $inspirations->firstItem() }} - {{ $inspirations->lastItem() }} dari {{ $inspirations->total() }} dokumentasi</span>
        <div>{{ $inspirations->links() }}</div>
    </div>
    @endif
</section>

{{-- MODAL TAMBAH & EDIT --}}
<div class="admin-modal" id="portfolioModal" aria-hidden="true">
    <div class="admin-modal-backdrop" onclick="closePortfolioModal()"></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="portfolioModalTitle">
        <div class="admin-modal-heading">
            <div>
                <p class="admin-eyebrow">KONTEN WEBSITE</p>
                <h2 id="portfolioModalTitle">Tambah Dokumentasi</h2>
            </div>
            <button type="button" class="admin-modal-close" onclick="closePortfolioModal()" aria-label="Tutup">×</button>
        </div>

        <form id="portfolioForm" action="{{ route('admin.portfolio.store') }}" method="POST" class="admin-demo-form" enctype="multipart/form-data" style="max-height: 85vh; overflow-y: auto;">
            @csrf
            <div id="methodContainer"></div>

            <label>
                Judul Dokumentasi
                <input type="text" name="title" id="modalTitle" placeholder="Contoh: Elegant White Wedding" required>
            </label>

            <div class="admin-form-two">
                <label>
                    Kategori
                    <select name="category_id" id="modalCategory" required>
                        <option value="">Pilih Kategori</option>
                        @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Paket Terkait (Opsional)
                    <select name="package_id" id="modalPackage">
                        <option value="">Tidak ada</option>
                        @foreach(\App\Models\Package::where('is_active', true)->where('type', 'package')->orderBy('name')->get() as $pkg)
                            <option value="{{ $pkg->id }}">{{ $pkg->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <label>
                Lokasi / Venue
                <input type="text" name="venue_type" id="modalVenue" placeholder="Nama gedung atau lokasi acara">
            </label>

            <label>
                Kapasitas Tamu (Opsional)
                <input type="text" name="guest_capacity" id="modalGuestCapacity" placeholder="Contoh: 250 Tamu">
            </label>

            <label>
                Deskripsi
                <textarea name="description" id="modalDescription" rows="3" placeholder="Deskripsi singkat dokumentasi"></textarea>
            </label>

            <label id="imageLabel">
                Foto Dokumentasi
                <input type="file" name="image" id="modalImage" accept="image/*" required>
                <small id="imageHelp" style="color:#888; font-size:12px;">Pilih file gambar (max 5MB)</small>
            </label>

            <label id="imagePreviewWrap" style="display:none;">
                Preview Gambar
                <img id="imagePreview" src="" alt="Preview" style="max-width:100%; max-height:200px; border-radius:8px; border:1px solid #e2e8f0;">
            </label>

            <label>
                Status Publikasi
                <select name="is_featured" id="modalFeatured" required>
                    <option value="0">Draft (Tidak ditampilkan di website)</option>
                    <option value="1">Dipublikasikan (Tampilkan di website)</option>
                </select>
            </label>

            <div class="admin-modal-actions" style="margin-top: 15px;">
                <button type="button" class="admin-secondary-button" onclick="closePortfolioModal()">Batal</button>
                <button type="submit" class="admin-primary-button" id="modalSubmitBtn">Simpan Dokumentasi</button>
            </div>
        </form>
    </div>
</div>

{{-- TOAST NOTIFICATION --}}
<div class="admin-toast" role="status" aria-live="polite"></div>

<script>
function openPortfolioModal() {
    document.getElementById('portfolioModalTitle').innerText = 'Tambah Dokumentasi';
    document.getElementById('portfolioForm').action = "{{ route('admin.portfolio.store') }}";
    document.getElementById('methodContainer').innerHTML = '';
    document.getElementById('modalSubmitBtn').innerText = 'Simpan Dokumentasi';

    document.getElementById('portfolioForm').reset();
    document.getElementById('imagePreviewWrap').style.display = 'none';
    document.getElementById('imageLabel').style.display = 'block';
    document.getElementById('modalImage').required = true;

    const modal = document.getElementById('portfolioModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

function closePortfolioModal() {
    const modal = document.getElementById('portfolioModal');
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
}

function editPortfolio(item) {
    document.getElementById('portfolioModalTitle').innerText = 'Edit ' + item.title;
    document.getElementById('portfolioForm').action = "/admin/portofolio/" + item.id;
    document.getElementById('methodContainer').innerHTML = '@method("PUT")';
    document.getElementById('modalSubmitBtn').innerText = 'Perbarui Dokumentasi';

    document.getElementById('modalTitle').value = item.title;
    document.getElementById('modalCategory').value = item.category_id || '';
    document.getElementById('modalPackage').value = item.package_id || '';
    document.getElementById('modalVenue').value = item.venue_type || '';
    document.getElementById('modalGuestCapacity').value = item.guest_capacity || '';
    document.getElementById('modalDescription').value = item.description || '';
    document.getElementById('modalFeatured').value = item.is_featured ? '1' : '0';

    // Image preview
    if (item.image_path) {
        document.getElementById('imagePreview').src = "{{ asset('storage/') }}" + '/' + item.image_path;
        document.getElementById('imagePreviewWrap').style.display = 'block';
        document.getElementById('imageLabel').style.display = 'none';
        document.getElementById('modalImage').required = false;
    } else {
        document.getElementById('imagePreviewWrap').style.display = 'none';
        document.getElementById('imageLabel').style.display = 'block';
        document.getElementById('modalImage').required = true;
    }

    const modal = document.getElementById('portfolioModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

// Image preview on file select
document.getElementById('modalImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreviewWrap').style.display = 'block';
            document.getElementById('imageLabel').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});

// Toast notification
@if(session('success'))
document.addEventListener('DOMContentLoaded', function() {
    showToast('{{ session('success') }}', 'success');
});
@endif

function showToast(message, type = 'success') {
    const toast = document.querySelector('.admin-toast');
    toast.textContent = message;
    toast.style.background = type === 'success' ? '#34a853' : '#ea4335';
    toast.style.color = 'white';
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 4000);
}
</script>
@endsection