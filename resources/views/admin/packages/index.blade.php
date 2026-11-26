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
    <button type="button" class="admin-primary-button" onclick="openPackageModal()">＋ Tambah Layanan</button>
</section>

{{-- NOTIFIKASI SUKSES / ERROR --}}
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

{{-- STATISTIK DINAMIS DARI DATABASE --}}
<section class="admin-stats-grid admin-compact-stats">
    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold"><span>◇</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Total Paket</span>
            <div class="admin-stat-value-row"><strong>{{ $totalPackages }}</strong><span class="admin-stat-trend trend-neutral">Tersedia</span></div>
            <small>Seluruh paket dekorasi</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-green"><span>✓</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Paket Aktif</span>
            <div class="admin-stat-value-row"><strong>{{ $activePackages }}</strong><span class="admin-stat-trend trend-positive">Aktif</span></div>
            <small>Dapat dipilih pelanggan</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-peach"><span>＋</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Add-on Layanan</span>
            <div class="admin-stat-value-row"><strong>{{ $totalAddons }}</strong><span class="admin-stat-trend trend-neutral">Tersedia</span></div>
            <small>Layanan tambahan</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold"><span>Rp</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Rentang Harga Paket</span>
            <div class="admin-stat-value-row">
                <strong class="admin-currency-stat" style="font-size: 15px;">
                    @if($minPrice > 0)
                        {{ number_format($minPrice / 1000, 0) }} rb – {{ number_format($maxPrice / 1000000, 1) }} jt
                    @else
                        Belum ada data
                    @endif
                </strong>
            </div>
            <small>Harga riil database</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>
</section>

{{-- TABEL PAKET & ADD-ON --}}
<section class="admin-panel admin-feature-panel">
    <div class="admin-panel-heading admin-feature-heading">
        <div class="admin-panel-title-wrap"><span class="admin-panel-icon">▤</span><h2>Daftar Paket &amp; Add-on</h2>
        </div>
    </div>

    <div class="admin-feature-toolbar">
        <div class="admin-page-tabs" role="tablist">
            <button type="button" class="admin-page-tab active" data-admin-tab="packagesPanel">Paket Dekorasi <span>{{ $packages->count() }}</span></button>
            <button type="button" class="admin-page-tab" data-admin-tab="addonsPanel">Add-on <span>{{ $addons->count() }}</span></button>
        </div>
        <div class="admin-toolbar-filters">
            <label class="admin-filter-search"><span>⌕</span><input type="search" placeholder="Cari nama..." data-table-search="packageTable"></label>
            <select class="admin-select" data-table-filter="packageTable" aria-label="Filter status">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>
        </div>
    </div>

    {{-- TAB 1: PAKET DEKORASI --}}
    <div id="packagesPanel" class="admin-tab-panel active">
        <div class="admin-table-wrap">
            <table class="admin-data-table" id="packageTable">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packages as $pkg)
                    <tr>
                        <td>
                            <strong>{{ $pkg->name }}</strong>
                            <small>{{ $pkg->tagline ?? '-' }}</small>
                        </td>
                        <td>{{ $pkg->category->name ?? 'Umum' }}</td>
                        <td>
                            <strong>Rp{{ number_format($pkg->price, 0, ',', '.') }}</strong>
                            @if($pkg->normal_price)
                                <br><small style="text-decoration: line-through; color: #888;">Rp{{ number_format($pkg->normal_price, 0, ',', '.') }}</small>
                            @endif
                        </td>
                        <td>
                            @if(is_array($pkg->features) && count($pkg->features) > 0)
                                <span title="{{ implode(', ', $pkg->features) }}">{{ count($pkg->features) }} Fasilitas</span>
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.packages.toggle-status', $pkg->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;" title="Klik untuk ubah status">
                                    @if($pkg->is_active)
                                        <span class="admin-status status-approved"><i></i>Aktif</span>
                                    @else
                                        <span class="admin-status status-pending"><i></i>Nonaktif</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td>
                            <button class="admin-row-action" type="button" onclick="editPackage({{ json_encode($pkg) }})">Edit</button>
                            <form action="{{ route('admin.packages.destroy', $pkg->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket {{ $pkg->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button class="admin-row-action danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #777;">
                            Belum ada paket dekorasi di database. Klik <strong>＋ Tambah Layanan</strong> di atas untuk membuat paket baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TAB 2: ADD-ON --}}
    <div id="addonsPanel" class="admin-tab-panel">
        <div class="admin-table-wrap">
            <table class="admin-data-table" id="addonTable">
                <thead>
                    <tr>
                        <th>Nama Add-on</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($addons as $addon)
                    <tr>
                        <td><strong>{{ $addon->name }}</strong></td>
                        <td>{{ $addon->category->name ?? 'Add-on' }}</td>
                        <td><strong>Rp{{ number_format($addon->price, 0, ',', '.') }}</strong></td>
                        <td><small>{{ Str::limit($addon->description, 50) ?? '-' }}</small></td>
                        <td>
                            <form action="{{ route('admin.packages.toggle-status', $addon->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;" title="Klik untuk ubah status">
                                    @if($addon->is_active)
                                        <span class="admin-status status-approved"><i></i>Aktif</span>
                                    @else
                                        <span class="admin-status status-pending"><i></i>Nonaktif</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td>
                            <button class="admin-row-action" type="button" onclick="editPackage({{ json_encode($addon) }})">Edit</button>
                            <form action="{{ route('admin.packages.destroy', $addon->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus add-on {{ $addon->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button class="admin-row-action danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #777;">
                            Belum ada add-on layanan di database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- MODAL TAMBAH & EDIT LAYANAN --}}
<div class="admin-modal" id="packageModal" aria-hidden="true">
    <div class="admin-modal-backdrop" onclick="closePackageModal()"></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="packageModalTitle">
        <div class="admin-modal-heading">
            <div>
                <p class="admin-eyebrow">FORM LAYANAN</p>
                <h2 id="packageModalTitle">Tambah Paket / Add-on</h2>
            </div>
            <button type="button" class="admin-modal-close" onclick="closePackageModal()" aria-label="Tutup">×</button>
        </div>

        <form id="packageForm" action="{{ route('admin.packages.store') }}" method="POST" class="admin-demo-form" style="max-height: 80vh; overflow-y: auto;">
            @csrf
            <div id="methodContainer"></div>

            <label>
                Jenis Data
                <select name="type" id="modalType" required onchange="toggleFormFields()">
                    <option value="package">Paket Dekorasi</option>
                    <option value="addon">Add-on Layanan</option>
                </select>
            </label>

            <label>
                Nama Layanan
                <input type="text" name="name" id="modalName" placeholder="Contoh: Paket Silver Romantic" required>
            </label>

            <label>
                Kategori
                <select name="category_id" id="modalCategory">
                    <option value="">Pilih Kategori (Opsional)</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </label>

            <div class="admin-form-two">
                <label>
                    Harga Jual (Rp)
                    <input type="number" name="price" id="modalPrice" min="0" placeholder="1200000" required>
                </label>
                <label id="normalPriceWrap">
                    Harga Normal/Coret (Rp)
                    <input type="number" name="normal_price" id="modalNormalPrice" min="0" placeholder="1500000">
                </label>
            </div>

            <label id="taglineWrap">
                Tagline / Subjudul (Opsional)
                <input type="text" name="tagline" id="modalTagline" placeholder="Contoh: The Signature Floral">
            </label>

            <label>
                Status
                <select name="is_active" id="modalStatus" required>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </label>

            <label id="featuresWrap">
                Daftar Fasilitas (Khusus Paket - Satu per baris Enter)
                <textarea name="features" id="modalFeatures" rows="4" placeholder="Backdrop 3x3 meter&#10;Lighting Spotlight&#10;Bunga Fresh Import"></textarea>
            </label>

            <label>
                Deskripsi / Keterangan
                <textarea name="description" id="modalDescription" rows="3" placeholder="Tuliskan keterangan detail layanan"></textarea>
            </label>

            <div class="admin-modal-actions" style="margin-top: 15px;">
                <button type="button" class="admin-secondary-button" onclick="closePackageModal()">Batal</button>
                <button type="submit" class="admin-primary-button" id="modalSubmitBtn">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPackageModal() {
    document.getElementById('packageModalTitle').innerText = 'Tambah Paket / Add-on';
    document.getElementById('packageForm').action = "{{ route('admin.packages.store') }}";
    document.getElementById('methodContainer').innerHTML = '';
    document.getElementById('modalSubmitBtn').innerText = 'Simpan Data';

    document.getElementById('packageForm').reset();
    toggleFormFields();

    const modal = document.getElementById('packageModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

function closePackageModal() {
    const modal = document.getElementById('packageModal');
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
}

function editPackage(pkg) {
    document.getElementById('packageModalTitle').innerText = 'Edit ' + pkg.name;
    document.getElementById('packageForm').action = "/admin/paket/" + pkg.id;
    document.getElementById('methodContainer').innerHTML = '@method("PUT")';
    document.getElementById('modalSubmitBtn').innerText = 'Perbarui Data';

    document.getElementById('modalType').value = pkg.type;
    document.getElementById('modalName').value = pkg.name;
    document.getElementById('modalCategory').value = pkg.category_id || '';
    document.getElementById('modalTagline').value = pkg.tagline || '';
    document.getElementById('modalPrice').value = Math.round(pkg.price);
    document.getElementById('modalNormalPrice').value = pkg.normal_price ? Math.round(pkg.normal_price) : '';
    document.getElementById('modalStatus').value = pkg.is_active ? '1' : '0';
    document.getElementById('modalDescription').value = pkg.description || '';

    if (Array.isArray(pkg.features)) {
        document.getElementById('modalFeatures').value = pkg.features.join("\n");
    } else {
        document.getElementById('modalFeatures').value = '';
    }

    toggleFormFields();

    const modal = document.getElementById('packageModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

function toggleFormFields() {
    const type = document.getElementById('modalType').value;
    const isPackage = (type === 'package');
    document.getElementById('featuresWrap').style.display = isPackage ? 'block' : 'none';
    document.getElementById('taglineWrap').style.display = isPackage ? 'block' : 'none';
    document.getElementById('normalPriceWrap').style.display = isPackage ? 'block' : 'none';
}
</script>
@endsection