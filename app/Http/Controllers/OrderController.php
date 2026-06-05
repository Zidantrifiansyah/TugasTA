<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CupangProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan halaman daftar pesanan
    public function index()
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }
        
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    // Menampilkan form pemesanan baru (untuk publik)
    public function create()
    {
        $products = CupangProduct::where('stok', '>', 0)->get();
        return view('orders.create', compact('products'));
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pembeli' => 'required|string',
            'email' => 'nullable|email',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
            'catatan' => 'nullable|string',
            'products' => 'required|array',
            'products.*' => 'required|exists:cupang_products,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        // Hitung total harga
        $totalHarga = 0;
        foreach ($validated['products'] as $key => $productId) {
            $product = CupangProduct::findOrFail($productId);
            $jumlah = $validated['jumlah'][$key];
            $totalHarga += $product->harga * $jumlah;

            // Cek stok
            if ($product->stok < $jumlah) {
                return redirect('/order')->with('error', 'Stok produk ' . $product->nama . ' tidak cukup!');
            }
        }

        // Buat order
        $order = Order::create([
            'nama_pembeli' => $validated['nama_pembeli'],
            'email' => $validated['email'] ?? null,
            'no_telepon' => $validated['no_telepon'],
            'alamat' => $validated['alamat'],
            'catatan' => $validated['catatan'] ?? null,
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
        ]);

        // Buat order items dan kurangi stok
        foreach ($validated['products'] as $key => $productId) {
            $product = CupangProduct::findOrFail($productId);
            $jumlah = $validated['jumlah'][$key];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'jumlah' => $jumlah,
                'harga_satuan' => $product->harga,
                'subtotal' => $product->harga * $jumlah,
            ]);

            // Kurangi stok
            $product->decrement('stok', $jumlah);
        }

        return redirect('/order')->with('success', 'Pesanan berhasil dibuat! ID Pesanan: #' . $order->id);
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        
        // Cek apakah user admin atau customer
        if (!session()->has('login') && auth()->guest()) {
            // Customer hanya bisa lihat order sendiri (jika ada sistem)
        }
        
        return view('orders.show', compact('order'));
    }

    // Menampilkan form edit status pesanan (admin only)
    public function edit($id)
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        $order = Order::with('items.product')->findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    // Update status pesanan
    public function update(Request $request, $id)
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,dikirim,selesai,batal',
        ]);

        $order->update($validated);
        return redirect('/orders')->with('success', 'Status pesanan berhasil diupdate!');
    }

    // Menghapus pesanan
    public function destroy($id)
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        $order = Order::findOrFail($id);
        $order->delete();
        return redirect('/orders')->with('success', 'Pesanan berhasil dihapus!');
    }
}
