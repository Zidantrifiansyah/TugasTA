@extends('layouts.main')

@section('title', 'Beranda - Dan\'s Cupang')

@section('content')
<section class="container mt-4">
    <div class="hero-bg p-5 text-center rounded-4 shadow-sm border border-info border-opacity-25">
        <i class="bi bi-flower1 display-1 text-info mb-3 d-block"></i>
        <h1 class="text-body-emphasis fw-bold mb-3">🐠 Selamat Datang di Dan's Cupang</h1>
        <p class="col-lg-8 mx-auto fs-5 text-muted mb-4">
            Penjualan ikan cupang berkualitas tinggi dengan berbagai varian warna dan jenis yang menakjubkan. 
            Kami menjamin kesehatan dan kualitas setiap ikan cupang yang kami jual.
        </p>
        <div class="d-inline-flex gap-2">
            <a href="{{ url('/order') }}" class="btn btn-info btn-lg px-4 rounded-pill">
                <i class="bi bi-cart-plus me-2"></i>Pesan Sekarang
            </a>
            @if(session()->has('login'))
                <a href="{{ url('/products') }}" class="btn btn-outline-info btn-lg px-4 rounded-pill">
                    <i class="bi bi-box me-2"></i>Kelola Produk
                </a>
            @endif
        </div>
    </div>
</section>

<section class="container mt-5 mb-5">
    <h2 class="text-center mb-4 fw-bold text-info">Produk Unggulan Kami</h2>
    <div class="row g-4" id="daftarProduk">
        @forelse($products ?? [] as $product)
        <div class="col-md-4">
            <div class="card h-100 border-info border-opacity-50 shadow-sm text-center card-cupang">
                <div class="card-body py-4">
                    <div class="display-4 text-info mb-2"><i class="bi bi-droplet"></i></div>
                    <h5 class="card-title fw-bold text-dark">{{ $product->nama }}</h5>
                    <p class="card-text text-muted">{{ $product->varian }}</p>
                    <h3 class="fw-bold text-info mt-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</h3>
                    <p class="text-secondary mb-3">Stok: <span class="badge bg-info">{{ $product->stok }}</span></p>
                    @if($product->stok > 0)
                        <a href="{{ url('/order') }}" class="btn btn-info w-100"><i class="bi bi-cart-plus me-2"></i>Pesan</a>
                    @else
                        <button class="btn btn-secondary w-100" disabled>Habis</button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted fs-5">Belum ada produk. Silakan hubungi admin untuk menambahkan produk.</p>
        </div>
        @endforelse
    </div>
</section>

<section class="container mt-5 mb-5 bg-light p-5 rounded-4">
    <h2 class="text-center mb-4 fw-bold text-dark">Mengapa Memilih Dan's Cupang?</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="text-center">
                <i class="bi bi-shield-check display-4 text-success mb-3 d-block"></i>
                <h5 class="fw-bold">Kualitas Terjamin</h5>
                <p class="text-muted">Setiap ikan dipilih dengan cermat untuk menjamin kesehatan dan keindahan warna.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <i class="bi bi-truck display-4 text-primary mb-3 d-block"></i>
                <h5 class="fw-bold">Pengiriman Aman</h5>
                <p class="text-muted">Kami menggunakan kemasan khusus untuk memastikan ikan tiba dalam kondisi prima.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <i class="bi bi-chat-dots display-4 text-warning mb-3 d-block"></i>
                <h5 class="fw-bold">Customer Support</h5>
                <p class="text-muted">Tim kami siap membantu Anda sebelum, saat, dan setelah transaksi.</p>
            </div>
        </div>
    </div>
</section>

@endsection