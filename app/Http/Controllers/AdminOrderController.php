<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->get();

        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => [
                'required',
                'in:menunggu,diproses,selesai,dibatalkan'
            ],
        ]);

        $order->update([
            'status' => $data['status'],
        ]);

        if ($data['status'] === 'selesai') {
            Transaction::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_code' => 'TRX-' . strtoupper(Str::random(8)),
                    'type' => 'pemasukan',
                    'description' => 'Pembayaran pesanan ' . $order->order_code,
                    'amount' => $order->total_amount,
                    'transaction_date' => now()->toDateString(),
                ]
            );
        }

        return redirect()->route('admin.orders')
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
