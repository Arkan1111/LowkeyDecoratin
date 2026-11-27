@extends('admin.layouts.app')

@section('title', 'Dashboard Operasional')

@section('content')
<section class="admin-page-heading">
    <div class="admin-heading-accent"></div>
    <div>
        <p class="admin-eyebrow">OPERASIONAL / RINGKASAN</p>
        <h1>Dashboard Operasional</h1>
        <p class="admin-page-subtitle">Ringkasan aktivitas dan kondisi operasional Lowkey Decoration terkini.</p>
    </div>
</section>

{{-- STATISTIK UTAMA DINAMIS --}}
<section class="admin-stats-grid" aria-label="Ringkasan statistik">
    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="5" width="18" height="16" rx="2" />
                <path d="M16 3v4M8 3v4M3 10h18" />
            </svg>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Total Reservasi</span>
            <div class="admin-stat-value-row">
                <strong>{{ $totalReservations }}</strong>
                <span class="admin-stat-trend trend-positive">Database</span>
            </div>
            <small>Seluruh pemesanan masuk</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-peach">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7v5l3 2" />
            </svg>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Menunggu Konfirmasi</span>
            <div class="admin-stat-value-row">
                <strong>{{ $pendingReservations }}</strong>
                @if($pendingReservations > 0)
                    <span class="admin-stat-trend trend-warning">Perlu tindakan</span>
                @else
                    <span class="admin-stat-trend trend-neutral">Aman</span>
                @endif
            </div>
            <small>Reservasi belum diproses</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-green">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9" />
                <path d="m8 12 2.5 2.5L16.5 9" />
            </svg>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Reservasi Aktif / Disetujui</span>
            <div class="admin-stat-value-row">
                <strong>{{ $approvedReservations }}</strong>
                <span class="admin-stat-trend trend-positive">Aktif</span>
            </div>
            <small>Dalam proses pengerjaan</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>

    <article class="admin-stat-card">
        <div class="admin-stat-icon stat-icon-gold">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z" />
                <path d="m4.5 7.7 7.5 4.4 7.5-4.4M12 12.1V21" />
            </svg>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-label">Paket Dekorasi Aktif</span>
            <div class="admin-stat-value-row">
                <strong>{{ $activePackages }}</strong>
                <span class="admin-stat-trend trend-neutral">Tersedia</span>
            </div>
            <small>Paket yang siap dipilih</small>
        </div>
        <span class="admin-stat-decoration"></span>
    </article>
</section>

{{-- RESERVASI TERBARU DAN JADWAL MENDATANG --}}
<section class="admin-dashboard-grid">

    {{-- PANEL 1: RESERVASI TERBARU --}}
    <article class="admin-panel admin-reservations-panel">
        <div class="admin-panel-heading">
            <div class="admin-panel-title-wrap">
                <span class="admin-panel-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path d="M16 3v4M8 3v4M3 10h18" />
                    </svg>
                </span>
                <h2>Reservasi Terbaru</h2>
            </div>
            <a href="{{ route('admin.reservations') }}" class="admin-panel-link">Lihat Semua <span>→</span></a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-reservation-table">
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Lokasi / Catatan</th>
                        <th>Paket</th>
                        <th>Tanggal Acara</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentReservations as $res)
                    @php
                        $firstDetail = $res->details->first();
                        $packageName = $firstDetail->package->name ?? 'Paket';
                        $initials = strtoupper(substr($res->user->name ?? 'PL', 0, 2));

                        $statusClass = 'status-pending';
                        if (in_array($res->status, ['diterima', 'dp_dibayar', 'lunas', 'selesai'])) {
                            $statusClass = 'status-approved';
                        } elseif ($res->status === 'dibatalkan') {
                            $statusClass = 'status-rejected';
                        }
                    @endphp
                    <tr>
                        <td>
                            <span class="admin-customer-cell">
                                <span class="admin-customer-avatar">{{ $initials }}</span>
                                {{ $res->user->name ?? 'Pelanggan' }}
                            </span>
                        </td>
                        <td>{{ $res->venue_name ?? Str::limit($res->venue_address, 25) }}</td>
                        <td>
                            <span class="admin-package-pill package-gold">{{ $packageName }}</span>
                        </td>
                        <td>{{ $res->event_date->translatedFormat('d M Y') }}</td>
                        <td>
                            <span class="admin-status {{ $statusClass }}">
                                <i></i>{{ ucfirst(str_replace('_', ' ', $res->status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 25px; color: #777;">
                            Belum ada aktivitas reservasi terbaru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>

    {{-- PANEL 2: JADWAL ACARA MENDATANG --}}
    <article class="admin-panel admin-schedule-panel">
        <div class="admin-panel-heading">
            <div class="admin-panel-title-wrap">
                <span class="admin-panel-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path d="M16 3v4M8 3v4M3 10h18" />
                    </svg>
                </span>
                <h2>Jadwal Acara Terdekat</h2>
            </div>
            <a href="{{ route('admin.reservations') }}" class="admin-panel-link">Semua Jadwal <span>→</span></a>
        </div>

        <div class="admin-event-list">
            @forelse ($upcomingEvents as $evt)
            @php
                $pkg = $evt->details->first()->package->name ?? 'Dekorasi';
            @endphp
            <div class="admin-event-item">
                <div class="admin-event-date">
                    <strong>{{ $evt->event_date->format('d') }}</strong>
                    <span>{{ $evt->event_date->translatedFormat('M') }}</span>
                </div>
                <div class="admin-event-info">
                    <strong>Acara {{ $evt->user->name ?? 'Klien' }}</strong>
                    <span><b>⌖</b> {{ $evt->venue_name ?? 'Lokasi Klien' }} · {{ $pkg }}</span>
                </div>
                <span class="admin-status status-approved"><i></i>{{ ucfirst($evt->status) }}</span>
            </div>
            @empty
            <div style="padding: 25px; text-align: center; color: #777;">
                Belum ada jadwal acara terdekat yang terkonfirmasi.
            </div>
            @endforelse
        </div>
    </article>

</section>
@endsection