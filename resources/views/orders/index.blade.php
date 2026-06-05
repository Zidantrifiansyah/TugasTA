@extends('layouts.main')

@section('title', 'Daftar Pesanan')

@section('content')
<section class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-info"><i class="bi bi-clipboard-check me-2"></i>Daftar Pesanan</h2>
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
                    <th>ID</th>
                    <th>Nama Pembeli</th>
                    <th>No. Telepon</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->nama_pembeli }}</td>
                    <td>{{ $order->no_telepon }}</td>
                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td>
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
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ url('/orders/' . $order->id) }}" class="btn btn-sm btn-info" title="Lihat">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ url('/orders/' . $order->id . '/edit') }}" class="btn btn-sm btn-warning" title="Edit Status">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ url('/orders/' . $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox"></i> Belum ada pesanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
