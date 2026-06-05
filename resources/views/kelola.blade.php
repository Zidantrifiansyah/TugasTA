@extends('layouts.main')

@section('title', 'Kelola Data')

@section('content')
<main class="container mt-5 mb-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-success border-opacity-25">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-plus me-2"></i>Input Data Takjil Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="#" method="POST">
                        <div class="mb-3">
                            <label for="namaMenu" class="form-label fw-bold text-secondary">Nama Menu</label>
                            <input type="text" class="form-control" id="namaMenu" placeholder="Contoh: Es Buah, Nasi Kotak..." required />
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-bold text-secondary">Kategori</label>
                            <select class="form-select" id="kategori" required>
                                <option value="" selected disabled>Pilih Kategori...</option>
                                <option value="makanan">Makanan Berat</option>
                                <option value="jajanan">Kue / Jajanan</option>
                                <option value="minuman">Minuman</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlahPorsi" class="form-label fw-bold text-secondary">Jumlah Porsi</label>
                            <input type="number" class="form-control" id="jumlahPorsi" placeholder="Masukkan angka" min="1" required />
                        </div>
                        <div class="mb-4">
                            <label for="penanggungJawab" class="form-label fw-bold text-secondary">Penanggung Jawab / Donatur</label>
                            <input type="text" class="form-control" id="penanggungJawab" placeholder="Nama individu atau organisasi" required />
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-save me-2"></i>Simpan Data Takjil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection