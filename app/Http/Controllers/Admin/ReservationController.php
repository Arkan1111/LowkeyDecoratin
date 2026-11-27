<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Menampilkan daftar reservasi dan statistik dinamis.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'details.package', 'payments'])->latest();

        // Filter status jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama pelanggan atau kode reservasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reservation_code', 'like', "%{$search}%")
                  ->orWhere('venue_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $reservations = $query->paginate(10)->withQueryString();

        // Hitung statistik dinamis
        $totalReservations = Reservation::count();
        $pendingCount = Reservation::where('status', 'menunggu')->count();
        $approvedCount = Reservation::whereIn('status', ['diterima', 'dp_dibayar', 'lunas', 'pengerjaan', 'selesai'])->count();
        $rejectedCount = Reservation::where('status', 'dibatalkan')->count();

        // Data pendukung untuk modal reservasi manual
        $customers = User::where('role', 'customer')->orderBy('name')->get();
        $packages = Package::where('is_active', true)->where('type', 'package')->orderBy('price')->get();

        return view('admin.reservations.index', compact(
            'reservations',
            'totalReservations',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'customers',
            'packages'
        ));
    }

    /**
     * Menyimpan reservasi manual oleh admin.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'package_id' => ['required', 'exists:packages,id'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_time' => ['nullable', 'date_format:H:i'],
            'venue_name' => ['nullable', 'string', 'max:255'],
            'venue_address' => ['required', 'string'],
            'concept_notes' => ['nullable', 'string'],
        ], [
            'user_id.required' => 'Pelanggan wajib dipilih.',
            'package_id.required' => 'Paket dekorasi wajib dipilih.',
            'event_date.required' => 'Tanggal acara wajib diisi.',
            'event_date.after_or_equal' => 'Tanggal acara tidak boleh di masa lampau.',
            'venue_address.required' => 'Alamat venue/lokasi wajib diisi.',
        ]);

        $package = Package::findOrFail($validated['package_id']);

        // Generate nomor reservasi unik: RSV-YYYYMMDD-XXXX
        $dateCode = date('Ymd');
        $randomSeq = str_pad(Reservation::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        $reservationCode = "RSV-{$dateCode}-{$randomSeq}";

        DB::transaction(function () use ($validated, $package, $reservationCode) {
            $reservation = Reservation::create([
                'reservation_code' => $reservationCode,
                'user_id' => $validated['user_id'],
                'event_date' => $validated['event_date'],
                'event_time' => $validated['event_time'] ?? null,
                'venue_name' => $validated['venue_name'] ?? null,
                'venue_address' => $validated['venue_address'],
                'concept_notes' => $validated['concept_notes'] ?? null,
                'total_amount' => $package->price,
                'status' => 'diterima', // Reservasi manual langsung berstatus diterima
            ]);

            ReservationDetail::create([
                'reservation_id' => $reservation->id,
                'package_id' => $package->id,
                'price' => $package->price,
                'quantity' => 1,
                'subtotal' => $package->price,
            ]);
        });

        return redirect()->route('admin.reservations')
            ->with('success', "Reservasi manual #{$reservationCode} berhasil dibuat!");
    }

    /**
     * Memperbarui status reservasi.
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:menunggu,diterima,dp_dibayar,lunas,pengerjaan,selesai,dibatalkan'],
        ]);

        $oldStatus = $reservation->status;
        $reservation->status = $validated['status'];
        $reservation->save();

        return redirect()->route('admin.reservations')
            ->with('success', "Status reservasi #{$reservation->reservation_code} berhasil diubah dari '{$oldStatus}' menjadi '{$validated['status']}'.");
    }

    /**
     * Menghapus data reservasi.
     */
    public function destroy(Reservation $reservation)
    {
        $code = $reservation->reservation_code;
        $reservation->delete();

        return redirect()->route('admin.reservations')
            ->with('success', "Reservasi #{$code} berhasil dihapus dari sistem.");
    }
}