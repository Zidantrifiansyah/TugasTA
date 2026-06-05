@extends('layouts.main')

@section('title', 'Edit Produk')

@section('content')
<section class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-info border-opacity-25 shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Produk</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ url('/products/' . $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">Nama Produk</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $product->nama }}" required>
                            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="varian" class="form-label fw-bold">Varian/Jenis</label>
                            <input type="text" class="form-control @error('varian') is-invalid @enderror" id="varian" name="varian" value="{{ $product->varian }}" required>
                            @error('varian') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ $product->deskripsi }}</textarea>
                            @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label fw-bold">Harga (Rp)</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ $product->harga }}" min="0" step="1000" required>
                                @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label fw-bold">Stok (pcs)</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ $product->stok }}" min="0" required>
                                @error('stok') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label fw-bold">Gambar Produk</label>
                            @if($product->gambar)
                            <div class="mb-2">
                                <small class="text-muted">Gambar saat ini:</small><br>
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" style="max-width: 150px; max-height: 150px;" class="rounded">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                            @error('gambar') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ url('/products') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-info">
                                <i class="bi bi-check-circle me-2"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
