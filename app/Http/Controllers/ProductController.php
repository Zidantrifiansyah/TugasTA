<?php

namespace App\Http\Controllers;

use App\Models\CupangProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan halaman daftar produk cupang
    public function index()
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }
        
        $products = CupangProduct::all();
        return view('products.index', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }
        return view('products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'varian' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('cupang', 'public');
            $validated['gambar'] = $path;
        }

        CupangProduct::create($validated);
        return redirect('/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form edit produk
    public function edit($id)
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        $product = CupangProduct::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        $product = CupangProduct::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'varian' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('cupang', 'public');
            $validated['gambar'] = $path;
        }

        $product->update($validated);
        return redirect('/products')->with('success', 'Produk berhasil diupdate!');
    }

    // Menghapus produk
    public function destroy($id)
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        $product = CupangProduct::findOrFail($id);
        $product->delete();
        return redirect('/products')->with('success', 'Produk berhasil dihapus!');
    }
}
