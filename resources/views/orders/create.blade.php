@extends('layouts.main')

@section('title', 'Pesan Ikan Cupang')

@section('content')
<section class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-info border-opacity-25 shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-cart-plus me-2"></i>Form Pemesanan Ikan Cupang</h5>
                </div>
                <div class="card-body p-4">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ url('/orders') }}" method="POST" id="orderForm">
                        @csrf

                        <!-- Bagian Data Pembeli -->
                        <h6 class="fw-bold mb-3 text-info">Data Pembeli</h6>

                        <div class="mb-3">
                            <label for="nama_pembeli" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_pembeli') is-invalid @enderror" id="nama_pembeli" name="nama_pembeli" placeholder="Nama lengkap Anda" required>
                            @error('nama_pembeli') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_telepon" class="form-label fw-bold">No. Telepon</label>
                                <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" placeholder="08xxxxxxxxx" required>
                                @error('no_telepon') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email (Opsional)</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="email@example.com">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-bold">Alamat Pengiriman</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap untuk pengiriman..." required></textarea>
                            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="catatan" class="form-label fw-bold">Catatan Pesanan (Opsional)</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="2" placeholder="Catatan khusus untuk pesanan..."></textarea>
                            @error('catatan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Bagian Produk -->
                        <h6 class="fw-bold mb-3 text-info">Pilih Produk</h6>

                        <div id="productsContainer">
                            <div class="product-row card p-3 mb-3 border-info border-opacity-25">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Produk</label>
                                        <select class="form-select form-select-sm @error('products.*') is-invalid @enderror product-select" name="products[]" required onchange="updatePrice(this)">
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->harga }}" data-stok="{{ $product->stok }}">
                                                {{ $product->nama }} ({{ $product->varian }}) - Rp {{ number_format($product->harga, 0, ',', '.') }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Jumlah (pcs)</label>
                                        <input type="number" class="form-control form-control-sm @error('jumlah.*') is-invalid @enderror jumlah-input" name="jumlah[]" placeholder="Berapa pcs?" min="1" value="1" required onchange="updatePrice(this)">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm w-100 removeProduct" onclick="removeProduct(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted mt-2 d-block">Subtotal: <span class="subtotal">Rp 0</span></small>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-info btn-sm mb-3" onclick="addProduct()">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Produk Lain
                        </button>

                        <div class="alert alert-info alert-dismissible" role="alert">
                            <strong>Total Harga: </strong>
                            <h5 class="mb-0 fw-bold text-dark" id="totalHarga">Rp 0</h5>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-info btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Lanjutkan Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function addProduct() {
    const container = document.getElementById('productsContainer');
    const newRow = container.querySelector('.product-row').cloneNode(true);
    newRow.querySelector('.product-select').value = '';
    newRow.querySelector('.jumlah-input').value = '1';
    newRow.querySelector('.subtotal').textContent = 'Rp 0';
    container.appendChild(newRow);
}

function removeProduct(btn) {
    btn.closest('.product-row').remove();
    updatePrice();
}

function updatePrice(element) {
    let total = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        const select = row.querySelector('.product-select');
        const jumlah = parseInt(row.querySelector('.jumlah-input').value) || 0;
        const price = parseInt(select.options[select.selectedIndex].dataset.price) || 0;
        const subtotal = price * jumlah;
        row.querySelector('.subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        total += subtotal;
    });
    document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('productsContainer').addEventListener('change', function() {
        updatePrice();
    });
});

// Validate form before submit
document.getElementById('orderForm').addEventListener('submit', function(e) {
    const products = document.querySelectorAll('.product-select');
    let hasProduct = false;
    
    products.forEach(p => {
        if (p.value) hasProduct = true;
    });
    
    if (!hasProduct) {
        e.preventDefault();
        alert('Pilih minimal 1 produk!');
    }
});
</script>
@endsection
