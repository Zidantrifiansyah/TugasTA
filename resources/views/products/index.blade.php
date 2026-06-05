@extends('layouts.main')

@section('title', 'Daftar Produk')

@section('content')
<section class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-info"><i class="bi bi-box me-2"></i>Kelola Produk Cupang</h2>
        <a href="{{ url('/products/create') }}" class="btn btn-info">
            <i class="bi bi-plus-circle me-2"></i>Tambah Produk
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover border border-info border-opacity-25 rounded-4 overflow-hidden">
            <thead class="table-info text-white">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Varian</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $product->nama }}</strong></td>
                    <td>{{ $product->varian }}</td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $product->stok > 10 ? 'success' : ($product->stok > 0 ? 'warning' : 'danger') }}">
                            {{ $product->stok }} pcs
                        </span>
                    </td>
                    <td>
                        <a href="{{ url('/products/' . $product->id . '/edit') }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ url('/products/' . $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox"></i> Belum ada produk. <a href="{{ url('/products/create') }}">Tambah produk sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
