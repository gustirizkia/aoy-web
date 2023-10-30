@extends('layouts.dashboard')

@section('title')
    Produk Saya
@endsection

@section('content')
    <section>
        <a href="/produk" class="btn btn__primary">Order Produk</a>
        <div class="row mt-4">
            <div class="col-md-3 mb-md-0 mb-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('gambar/icon/diagram-keuntungan.png') }}" class="mr-3"  alt="">
                        <h5 class="font-weight-bold">Penjualan</h5>
                    </div>
                    <div class="mt-2">
                        <div class="text-secondary">
                            Total revenue
                        </div>
                        <div class="font-weight-bold text__primary">
                            Rp.{{ number_format($total_penjualan) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-md-0 mb-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('gambar/icon/diagram-stokpng.png') }}" class="mr-3"  alt="">
                        <h5 class="font-weight-bold">Pembelian</h5>
                    </div>
                    <div class="mt-2">
                        <div class="text-secondary">
                            Total pembelian
                        </div>
                        <div class="font-weight-bold text__primary">
                            {{ $total_pembelian }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            @foreach ($produk as $item)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <a
                    href="{{ route('detail-produk', $item->produk->slug) }}"
                    class="card card-dashboard-product d-block"
                    >
                    <div class="card-body">
                        <img
                        src="{{ url($item->produk->thumbnail->photo) }}"
                        alt=""
                        class="w-100 mb-2"
                        />
                        <div class="product-title">{{ $item->produk->nama }}</div>
                        <div class="product-category">Stok : {{ $item->qty }}</div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endsection
