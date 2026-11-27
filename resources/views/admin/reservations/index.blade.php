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
    <button type="button" class="admin-primary-button" onclick="openManualReservationModal()">＋ Reservasi Manual</button>
</section>

{{-- NOTIFIKASI SUKSES / ERROR --}}
@if(session('success'))
<div style="background: #e6f4ea; border-left: 4px solid #34a853; color: #137333; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
    ✓ {{ session('success') }}
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

{{-- STATISTIK DINAMIS DATABASE --}}
<section class="admin-stats-grid admin-compact-stats">
    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold"><span>▦</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Total Reservasi</span>
            <div class="admin-stat-value-row"><strong>{{ $totalReservations }}</strong></div>
            <small>Seluruh pemesanan masuk</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-peach"><span>◷</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Menunggu Konfirmasi</span>
            <div class="admin-stat-value-row">
                <strong>{{ $pendingCount }}</strong>
                @if($pendingCount > 0)
                    <span class="admin-stat-trend trend-warning">Perlu ditinjau</span>
                @endif
            </div>
            <small>Belum diproses admin</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-green"><span>✓</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Disetujui / Aktif</span>
            <div class="admin-stat-value-row"><strong>{{ $approvedCount }}</strong></div>
            <small>Dalam proses pengerjaan</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold"><span>⊘</span></div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Dibatalkan</span>
            <div class="admin-stat-value-row"><strong>{{ $rejectedCount }}</strong></div>
            <small>Pesanan tidak dilanjutkan</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>
</section>

{{-- TABEL DATA RESERVASI --}}
<section class="admin-panel admin-feature-panel">
    <div class="admin-panel-heading admin-feature-heading">
        <div class="admin-panel-title-wrap"><span class="admin-panel-icon">▦</span><h2>Daftar Reservasi Pelanggan</h2></div>
    </div>

    {{-- TOOLBAR PENCARIAN & FILTER --}}
    <form method="GET" action="{{ route('admin.reservations') }}" class="admin-feature-toolbar" style="margin-bottom: 15px;">
        <div class="admin-toolbar-filters admin-toolbar-filters-full">
            <label class="admin-filter-search">
                <span>⌕</span>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama pelanggan, venue, atau kode reservasi...">
            </label>
            <select name="status" class="admin-select" onchange="this.form.submit()" aria-label="Filter status">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="dp_dibayar" {{ request('status') === 'dp_dibayar' ? 'selected' : '' }}>DP Dibayar</option>
                <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="pengerjaan" {{ request('status') === 'pengerjaan' ? 'selected' : '' }}>Pengerjaan</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.reservations') }}" style="font-size: 13px; color: #888; text-decoration: underline; align-self: center;">Reset Filter</a>
            @endif
        </div>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-data-table" id="reservationTable">
            <thead>
                <tr>
                    <th>No. Reservasi</th>
                    <th>Pelanggan</th>
                    <th>Paket Dekorasi</th>
                    <th>Tanggal Acara</th>
                    <th>Total Tagihan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $res)
                @php
                    $firstDetail = $res->details->first();
                    $packageName = $firstDetail->package->name ?? 'Custom';
                    $initials = strtoupper(substr($res->user->name ?? 'PL', 0, 2));

                    // Status style mapping
                    $statusClass = 'status-pending';
                    if (in_array($res->status, ['diterima', 'dp_dibayar', 'lunas', 'selesai'])) {
                        $statusClass = 'status-approved';
                    } elseif ($res->status === 'dibatalkan') {
                        $statusClass = 'status-rejected';
                    }
                @endphp
                <tr>
                    <td><strong>#{{ $res->reservation_code }}</strong></td>
                    <td>
                        <span class="admin-customer-cell">
                            <span class="admin-customer-avatar">{{ $initials }}</span>
                            {{ $res->user->name ?? 'Pelanggan' }}
                        </span>
                        <small>{{ $res->user->email ?? '-' }}</small>
                    </td>
                    <td>
                        <strong style="color: #4a3b32;">{{ $packageName }}</strong>
                        @if($res->venue_name)
                            <br><small style="color: #777;">📍 {{ $res->venue_name }}</small>
                        @endif
                    </td>
                    <td>
                        {{ $res->event_date->translatedFormat('d M Y') }}
                        @if($res->event_time)
                            <br><small style="color: #888;">Jam: {{ substr($res->event_time, 0, 5) }}</small>
                        @endif
                    </td>
                    <td>
                        <strong>Rp{{ number_format($res->total_amount, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <span class="admin-status {{ $statusClass }}">
                            <i></i>{{ ucfirst(str_replace('_', ' ', $res->status)) }}
                        </span>
                    </td>
                    <td>
                        <button class="admin-row-action" type="button" onclick="showReservationDetail({{ json_encode($res->load(['user', 'details.package'])) }})">Detail</button>
                        <form action="{{ route('admin.reservations.destroy', $res->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus reservasi #{{ $res->reservation_code }}?');">
                            @csrf
                            @method('DELETE')
                            <button class="admin-row-action danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 35px; color: #777;">
                        Belum ada data reservasi pelanggan di database. Klik tombol <strong>＋ Reservasi Manual</strong> di atas untuk membuat reservasi baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reservations->hasPages())
    <div class="admin-table-footer" style="padding: 15px;">
        <span>Menampilkan {{ $reservations->firstItem() ?? 0 }} - {{ $reservations->lastItem() ?? 0 }} dari {{ $reservations->total() }} reservasi</span>
        <div>{{ $reservations->links() }}</div>
    </div>
    @endif
</section>

{{-- MODAL DETAIL RESERVASI & UBAH STATUS --}}
<div class="admin-modal" id="reservationDetailModal" aria-hidden="true">
    <div class="admin-modal-backdrop" onclick="closeDetailModal()"></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true" style="max-width: 600px;">
        <div class="admin-modal-heading">
            <div>
                <p class="admin-eyebrow">RINCIAN PESANAN</p>
                <h2 id="modalResTitle">Detail Reservasi</h2>
            </div>
            <button type="button" class="admin-modal-close" onclick="closeDetailModal()">×</button>
        </div>

        <dl class="admin-detail-list">
            <div><dt>Nomor Reservasi</dt><dd id="dCode">-</dd></div>
            <div><dt>Pelanggan</dt><dd id="dCustomer">-</dd></div>
            <div><dt>Kontak Email</dt><dd id="dEmail">-</dd></div>
            <div><dt>Paket Dekorasi</dt><dd id="dPackage">-</dd></div>
            <div><dt>Tanggal & Waktu</dt><dd id="dDate">-</dd></div>
            <div><dt>Lokasi / Venue</dt><dd id="dVenue">-</dd></div>
            <div><dt>Alamat Lengkap</dt><dd id="dAddress">-</dd></div>
            <div><dt>Total Tagihan</dt><dd id="dAmount" style="font-weight: bold; color: #2d3748;">-</dd></div>
            <div><dt>Catatan Konsep</dt><dd id="dConcept" style="font-style: italic;">-</dd></div>
            <div><dt>Status Saat Ini</dt><dd id="dStatus" style="font-weight: bold;">-</dd></div>
        </dl>

        {{-- FORM UPDATE STATUS --}}
        <form id="updateStatusForm" action="" method="POST" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
            @csrf
            @method('PATCH')
            <label style="font-weight: 600; font-size: 13px; color: #4a5568; display: block; margin-bottom: 6px;">
                Perbarui Status Reservasi:
            </label>
            <div style="display: flex; gap: 10px;">
                <select name="status" id="dSelectStatus" class="admin-select" style="flex: 1;">
                    <option value="menunggu">Menunggu</option>
                    <option value="diterima">Diterima</option>
                    <option value="dp_dibayar">DP Dibayar</option>
                    <option value="lunas">Lunas</option>
                    <option value="pengerjaan">Pengerjaan</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
                <button type="submit" class="admin-primary-button" style="padding: 8px 18px;">Ubah Status</button>
            </div>
        </form>

        <div class="admin-modal-actions" style="margin-top: 15px;">
            <button type="button" class="admin-secondary-button" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH RESERVASI MANUAL --}}
<div class="admin-modal" id="reservationManualModal" aria-hidden="true">
    <div class="admin-modal-backdrop" onclick="closeManualReservationModal()"></div>
    <div class="admin-modal-dialog" role="dialog" aria-modal="true" style="max-width: 600px;">
        <div class="admin-modal-heading">
            <div>
                <p class="admin-eyebrow">FORM OPERASIONAL</p>
                <h2>Buat Reservasi Manual</h2>
            </div>
            <button type="button" class="admin-modal-close" onclick="closeManualReservationModal()">×</button>
        </div>

        <form action="{{ route('admin.reservations.store') }}" method="POST" class="admin-demo-form" style="max-height: 80vh; overflow-y: auto;">
            @csrf
            <label>
                Pilih Pelanggan (Customer Terdaftar)
                <select name="user_id" required>
                    <option value="">-- Pilih Akun Klien --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
                    @endforeach
                </select>
            </label>

            <label>
                Pilihan Paket Dekorasi
                <select name="package_id" required>
                    <option value="">-- Pilih Paket --</option>
                    @foreach($packages as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} - Rp{{ number_format($p->price, 0, ',', '.') }}</option>
                    @endforeach
                </select>
            </label>

            <div class="admin-form-two">
                <label>
                    Tanggal Acara
                    <input type="date" name="event_date" required min="{{ date('Y-m-d') }}">
                </label>
                <label>
                    Jam Acara (Opsional)
                    <input type="time" name="event_time">
                </label>
            </div>

            <label>
                Nama Gedung / Venue (Opsional)
                <input type="text" name="venue_name" placeholder="Contoh: Ballroom Hotel Grand Mercure / Rumah">
            </label>

            <label>
                Alamat Lengkap Lokasi Acara
                <textarea name="venue_address" rows="3" placeholder="Masukkan alamat lengkap venue" required></textarea>
            </label>

            <label>
                Catatan Konsep / Nuansa Tema (Opsional)
                <textarea name="concept_notes" rows="2" placeholder="Contoh: Nuansa Rustic Sage Green & Rose Gold"></textarea>
            </label>

            <div class="admin-modal-actions" style="margin-top: 15px;">
                <button type="button" class="admin-secondary-button" onclick="closeManualReservationModal()">Batal</button>
                <button type="submit" class="admin-primary-button">Buat Reservasi</button>
            </div>
        </form>
    </div>
</div>

<script>
function showReservationDetail(res) {
    document.getElementById('modalResTitle').innerText = 'Detail #' + res.reservation_code;
    document.getElementById('dCode').innerText = '#' + res.reservation_code;
    document.getElementById('dCustomer').innerText = res.user ? res.user.name : '-';
    document.getElementById('dEmail').innerText = res.user ? res.user.email : '-';

    var pkgName = '-';
    if (res.details && res.details.length > 0 && res.details[0].package) {
        pkgName = res.details[0].package.name;
    }
    document.getElementById('dPackage').innerText = pkgName;

    var timeStr = res.event_time ? (' Jam ' + res.event_time.substring(0, 5)) : '';
    document.getElementById('dDate').innerText = res.event_date + timeStr;
    document.getElementById('dVenue').innerText = res.venue_name || '-';
    document.getElementById('dAddress').innerText = res.venue_address || '-';
    document.getElementById('dAmount').innerText = 'Rp ' + Number(res.total_amount).toLocaleString('id-ID');
    document.getElementById('dConcept').innerText = res.concept_notes || 'Tidak ada catatan konsep.';
    document.getElementById('dStatus').innerText = res.status.toUpperCase().replace('_', ' ');

    document.getElementById('dSelectStatus').value = res.status;
    document.getElementById('updateStatusForm').action = "/admin/reservasi/" + res.id + "/status";

    const modal = document.getElementById('reservationDetailModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

function closeDetailModal() {
    const modal = document.getElementById('reservationDetailModal');
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
}

function openManualReservationModal() {
    const modal = document.getElementById('reservationManualModal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

function closeManualReservationModal() {
    const modal = document.getElementById('reservationManualModal');
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
}
</script>
@endsection