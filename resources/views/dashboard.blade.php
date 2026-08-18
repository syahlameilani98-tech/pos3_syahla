@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="text-center mb-5">
    <h1 class="fw-bold">
        Ringkasan Hari Ini
        <span class="text-muted">
            ({{ $tanggalHariIni->translatedFormat('l, d F Y') }})
        </span>
    </h1>
</div>

{{-- TODAY'S SALES --}}
<h2 class="text-center fw-bold mb-4">Today's Sales</h2>

<div class="row g-3 mb-5">

    <div class="col-md-6">
        <div class="card shadow-sm border">
            <div class="card-header text-center bg-primary">
                <span class="text-white">
                    Total Nilai Penjualan Hari ini
                </span>
            </div>

            <div class="card-body text-center py-4">
                <h3 class="fw-bold mb-0 text-primary">
                    Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border">
            <div class="card-header text-center bg-primary">
                <span class="text-white">
                    Jumlah Transaksi Hari ini
                </span>
            </div>

            <div class="card-body text-center py-4">
                <h3 class="fw-bold mb-0 text-primary">
                    {{ $ringkasan['total_transaksi'] }}
                </h3>
            </div>
        </div>
    </div>

</div>

{{-- CASH & PAYMENT STATUS --}}
<h2 class="text-center fw-bold mb-4">
    Cash & Payment Status
</h2>

<div class="row g-3 mb-5">

    <div class="col-md-6">
        <div class="card shadow-sm border">
            <div class="card-header text-center bg-primary">
                <span class="text-white">
                    Total pembayaran tunai
                </span>
            </div>

            <div class="card-body text-center py-4">
                <h3 class="fw-bold mb-0 text-primary">
                    Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border">
            <div class="card-header text-center bg-primary">
                <span class="text-white">
                    Total pembayaran non-tunai
                </span>
            </div>

            <div class="card-body text-center py-4">
                <h3 class="fw-bold mb-0 text-primary">
                    Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

</div>

{{-- PRODUK TERLARIS --}}
<h2 class="text-center fw-bold mb-4">
    Produk Terlaris Hari Ini
</h2>

<div class="table-responsive mb-5">
    <table class="table text-center align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Stok</th>
                <th>Total Terjual</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($produkTerlaris as $produk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $produk->name }}</td>
                    <td>{{ $produk->stok }}</td>
                    <td>{{ $produk->total_terjual }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-muted py-3">
                        Belum ada penjualan hari ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- CRITICAL INVENTORY STATUS --}}
<h2 class="text-center fw-bold mb-4">
    Critical Inventory Status
</h2>

<div class="row g-4">

    {{-- STOK RENDAH --}}
    <div class="col-md-6">

        <h4 class="text-center fw-bold mb-3">
            Daftar produk stok rendah
        </h4>

        <div class="table-responsive">
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Stok</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($produkStokRendah as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produk->name }}</td>
                            <td>{{ $produk->stok }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted py-3">
                                Seluruh produk berada dalam kondisi stok aman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $produkStokRendah->links() }}

    </div>

    {{-- PRODUK HABIS --}}
    <div class="col-md-6">

        <h4 class="text-center fw-bold mb-3">
            Produk habis stok
        </h4>

        <div class="table-responsive">
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Stok</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($produkStokHabis as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produk->name }}</td>
                            <td>{{ $produk->stok }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted py-3">
                                Seluruh produk berada dalam kondisi stok aman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $produkStokHabis->links() }}

    </div>

</div>

@endsection