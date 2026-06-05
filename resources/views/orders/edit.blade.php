@extends('layouts.main')

@section('title', 'Edit Status Pesanan')

@section('content')
<section class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-info border-opacity-25 shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Update Status Pesanan #{{ $order->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 p-3 bg-light rounded">
                        <h6 class="fw-bold mb-2">Informasi Pesanan</h6>
                        <p class="mb-1"><strong>Pembeli:</strong> {{ $order->nama_pembeli }}</p>
                        <p class="mb-1"><strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        <p class="mb-0"><strong>Status Saat Ini:</strong> 
                            @if($order->status === 'menunggu')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($order->status === 'diproses')
                                <span class="badge bg-info">Diproses</span>
                            @elseif($order->status === 'dikirim')
                                <span class="badge bg-primary">Dikirim</span>
                            @elseif($order->status === 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($order->status === 'batal')
                                <span class="badge bg-danger">Batal</span>
                            @endif
                        </p>
                    </div>

                    <h6 class="fw-bold mb-3">Item Pesanan</h6>
                    <div class="list-group mb-4">
                        @foreach($order->items as $item)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">{{ $item->product->nama }}</h6>
                                    <small class="text-muted">{{ $item->product->varian }} x {{ $item->jumlah }}</small>
                                </div>
                                <div class="text-end">
                                    <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <form action="{{ url('/orders/' . $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">Ubah Status</label>
                            <select class="form-select form-select-lg @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="menunggu" {{ $order->status === 'menunggu' ? 'selected' : '' }}>📋 Menunggu</option>
                                <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>⚙️ Diproses</option>
                                <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>🚚 Dikirim</option>
                                <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="batal" {{ $order->status === 'batal' ? 'selected' : '' }}>❌ Batal</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="alert alert-info">
                            <small><i class="bi bi-info-circle me-2"></i>Status akan diupdate dan sistem akan siap mencatat perubahannya.</small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <a href="{{ url('/orders/' . $order->id) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-info">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
