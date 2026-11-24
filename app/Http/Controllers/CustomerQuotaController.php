<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerQuotaController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input pencarian kuota
        $validated = $request->validate([

            'jenis_acara' => [
                'required',
                'in:Pernikahan,Lamaran,Khitan & Sunatan,Acara Lainnya'
            ],

            'tanggal' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today'
            ],

            'kota' => [
                'required',
                'in:Jakarta,Bekasi,Karawang,Depok,Bandung'
            ],

        ]);

        // Kirim data ke halaman hasil cek kuota
        return view('customer.sections.customer-kuota', [

            'jenisAcara' => $validated['jenis_acara'],

            'tanggal' => $validated['tanggal'],

            'kota' => $validated['kota'],

        ]);
    }
}
