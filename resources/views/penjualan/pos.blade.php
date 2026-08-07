@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-4">Tambah Penjualan</h3>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- ================= SISI KIRI: DAFTAR PRODUK ================= --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3">
                {{-- Form Pencarian --}}
                <form action="{{ route('penjualan.create') }}" method="GET" class="mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                </form>

                {{-- List Produk dengan Scrollbar --}}
                <div style="max-height: 480px; overflow-y: auto;" class="pe-2">
                    @forelse($produks as $product)
                        <form action="{{ route('penjualan.add-to-cart') }}" method="POST" class="mb-2">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $product->id }}">
                            
                            <div class="card p-2 border rounded shadow-sm d-flex flex-row align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2" style="width: 55%;">
                                    <img src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://via.placeholder.com/50' }}" 
                                         alt="Gambar" class="rounded" style="width: 45px; height: 45px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0 text-primary fw-semibold" style="font-size: 0.95rem;">
                                            {{ $product->nama ?? $product->nama_produk }}
                                        </h6>
                                        <small class="text-muted d-block">
                                            Rp.{{ number_format($product->harga_jual ?? $product->harga ?? 0, 0, ',', '.') }}
                                        </small>
                                        {{-- Badge Status Stok --}}
                                        <span class="badge {{ $product->stok > 0 ? 'bg-info' : 'bg-danger' }}" style="font-size: 0.7rem;">
                                            Stok: {{ $product->stok }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2" style="width: 40%;">
                                    @if($product->stok > 0)
                                        <input type="number" name="qty" value="1" min="1" max="{{ $product->stok }}" 
                                               class="form-control form-control-sm text-center" style="width: 65px;">
                                        
                                        <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold flex-grow-1">
                                            +
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm w-100" disabled>
                                            Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    @empty
                        <div class="text-center text-muted py-4">Produk tidak ditemukan</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ================= SISI KANAN: TABEL KERANJANG ================= --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3">
                <div class="table-responsive" style="min-height: 220px;">
                    <table class="table align-middle text-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th style="width: 70px;">Qty</th>
                                <th>Subtotal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @forelse($sale->itemPenjualan as $item)
                                @php $grandTotal += $item->subtotal; @endphp
                                <tr>
                                    <td class="fw-semibold text-break" style="max-width: 130px;">
                                        {{ $item->produk->nama ?? $item->produk->nama_produk }}
                                    </td>
                                    {{-- Menggunakan $item->harga_satuan bukan $item->harga --}}
                                    <td>Rp.{{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm text-center p-1" value="{{ $item->kuantitas }}" readonly style="background-color: #f8f9fa;">
                                    </td>
                                    <td class="fw-bold">Rp.{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('penjualan.remove-from-cart', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-2 py-1" style="font-size: 0.8rem;">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">Belum ada item di keranjang</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <hr class="my-3">

                {{-- Total Pembayaran & Form Checkout --}}
                <form action="{{ route('penjualan.update', $sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold fs-5 text-dark">Rp.{{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="mb-3">
                        <select name="payment_method" class="form-select form-select-sm" required>
                            <option value="CASH" {{ $sale->metode_pembayaran == 'CASH' ? 'selected' : '' }}>Cash</option>
                            <option value="QRIS" {{ $sale->metode_pembayaran == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 mb-2" 
                            {{ $sale->itemPenjualan->count() == 0 ? 'disabled' : '' }}>
                        Checkout
                    </button>
                </form>

                {{-- Tombol Batal Transaksi --}}
                <form action="{{ route('penjualan.clear-cart') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 py-1" style="font-size: 0.9rem;"
                            onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')"
                            {{ $sale->itemPenjualan->count() == 0 ? 'disabled' : '' }}>
                        Batalkan Transaksi
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection