@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Ringkasan Hari Ini</h3>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center p-4">
                <h6 class="text-muted mb-2">Total Nilai Penjualan Hari ini</h6>
                <h2 class="fw-bold text-primary mb-0">Rp 350,000</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center p-4">
                <h6 class="text-muted mb-2">Jumlah Transaksi Hari ini</h6>
                <h2 class="fw-bold text-primary mb-0">1</h2>
            </div>
        </div>
    </div>
</div>

<h5 class="fw-bold mb-3">Cash & Payment Status</h5>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center p-3">
                <small class="text-muted">Total Pembayaran Tunai</small>
                <h4 class="fw-bold mt-1 text-success mb-0">Rp 350,000</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center p-3">
                <small class="text-muted">Total Pembayaran Non-Tunai</small>
                <h4 class="fw-bold mt-1 text-secondary mb-0">Rp 0</h4>
            </div>
        </div>
    </div>
</div>
@endsection