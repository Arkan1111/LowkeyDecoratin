<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan ringkasan data operasional real-time di Dashboard Admin.
     */
    public function index()
    {
        // 1. Statistik Utama Dinamis
        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'menunggu')->count();
        $approvedReservations = Reservation::whereIn('status', ['diterima', 'dp_dibayar', 'lunas', 'pengerjaan', 'selesai'])->count();
        $activePackages = Package::where('is_active', true)->where('type', 'package')->count();

        // 2. Lima Reservasi Terbaru Masuk
        $recentReservations = Reservation::with(['user', 'details.package'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Lima Jadwal Acara Terdekat Mendatang
        $upcomingEvents = Reservation::with(['user', 'details.package'])
            ->where('event_date', '>=', now()->toDateString())
            ->whereIn('status', ['diterima', 'dp_dibayar', 'lunas', 'pengerjaan'])
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalReservations',
            'pendingReservations',
            'approvedReservations',
            'activePackages',
            'recentReservations',
            'upcomingEvents'
        ));
    }
}