<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->latest()
            ->get();

        return view('customer.dashboard', compact('products'));
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'product_id' => ['required', 'array', 'min:1'],
            'product_id.*' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($data) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'total_amount' => 0,
                'status' => 'menunggu',
            ]);

            $total = 0;

            foreach ($data['product_id'] as $index => $productId) {
                $product = Product::whereKey($productId)
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = $data['quantity'][$index];

                if ($product->stock < $quantity) {
                    throw new \RuntimeException(
                        'Stok produk ' . $product->name . ' tidak mencukupi.'
                    );
                }

                $subtotal = $product->price * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $quantity);
                $total += $subtotal;
            }

            $order->update(['total_amount' => $total]);
        });

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function orders()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.orders', compact('orders'));
    }
}
