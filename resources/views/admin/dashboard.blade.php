@extends('crudbooster::admin_template')

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        .bg-success{
            background-color: #00a65a !important;
            color: white;
        }
        .bg-info{
            background-color: #17a2b8!important;
            color: white

        }
        .bg-warning{
            background-color: #ffc107!important;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp.{{ number_format($subtotal_penjualan_member) }}</h3>
                <p>Penjualan Member</p>
            </div>
            <div class="icon">
                <i class="bi bi-currency-dollar"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ number_format($memberStok) }}</h3>
                <p>Stok Member</p>
            </div>
            <div class="icon">
                <i class="bi bi-cart"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($barang_terjual) }}</h3>
                <p>Produk Terjual</p>
            </div>
            <div class="icon">
                <i class="bi bi-box"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp.{{ number_format($subtotal_pembelian_member) }}</h3>
                <p>Pembelian Member</p>
            </div>
            <div class="icon">
                <i class="bi bi-currency-dollar"></i>
            </div>
        </div>
    </div>
</div>

@endsection
