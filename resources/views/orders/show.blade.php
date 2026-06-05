@extends('layouts.main')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<section class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-info border-opacity-25 shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i>Detail Pesanan #{{ $order->id }}</h5>
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
                </div>
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-dark">Informasi Pembeli</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Nama:</strong> {{ $order->nama_pembeli }}</p>
                            <p class="mb-2"><strong>No. Telepon:</strong> {{ $order->no_telepon }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Email:</strong> {{ $order->email ?? '-' }}</p>
                            <p class="mb-2"><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 text-dark">Alamat Pengiriman</h6>
                    <p class="mb-4 ps-3 border-start border-info">{{ $order->alamat }}</p>

                    @if($order->catatan)
                    <h6 class="fw-bold mb-3 text-dark">Catatan Pesanan</h6>
                    <p class="mb-4 ps-3 border-start border-warning">{{ $order->catatan }}</p>
                    @endif

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3 text-dark">Detail Produk</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->items as $item)
                                <tr>
                                    <td><strong>{{ $item->product->nama }}</strong><br><small class="text-muted">{{ $item->product->varian }}</small></td>
                                    <td class="text-end">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ $item->jumlah }} pcs</td>
                                    <td class="text-end"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Tidak ada item</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mb-4">
                        <h5 class="mb-0 fw-bold">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h5>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        <a href="{{ url('/orders') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        @if(session()->has('login'))
                        <a href="{{ url('/orders/' . $order->id . '/edit') }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>Edit Status
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
