@extends('layouts.dashboard')

@section('title')
    Dashboard
@endsection

@push('addStyle')
    <style>
        .statistik .card{
            border-radius: 10px;
        }
        .riwayat_transaksi .harga{
            line-height: 1;
            font-size: 14px
        }
        .count_status{
            position: absolute;
            background: #A349A3;
            display: inline-block;
            min-width: 2em;
            padding: 0.3em;
            border-radius: 50%;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            color: #fefefe;
            top: 0;
            right: -8px;
        }

        @media (max-width: 991.98px) {
            .icon_status img{
                width: 40px;
            }

            .icon_status .status{
                font-size: 10px;
            }

            .count_status{
                font-size: 10px;
            }
            .w-75{
                width: 100% !important;
            }
        }
    </style>
@endpush

@section('content')
<div class="row statistik">
    <div class="col-md-3 col-12 mb-md-0 mb-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <img src="{{ asset('gambar/icon/diagram-keuntungan.png') }}" class="mr-md-3 mr-2"  alt="">
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
    <div class="col-md-3 col-12 mb-md-0 mb-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <img src="{{ asset('gambar/icon/diagram-penjualan.png') }}" class="mr-3"  alt="">
                <h5 class="font-weight-bold">Pembelian</h5>
            </div>
            <div class="mt-2">
                <div class="text-secondary">
                    Total pembelian
                </div>
                <div class="font-weight-bold text__primary">
                    Rp{{ number_format($total_pembelian) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-12 mb-md-0 mb-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <img src="{{ asset('gambar/icon/diagram-stokpng.png') }}" class="mr-3"  alt="">
                <h5 class="font-weight-bold">Stok Produk</h5>
            </div>
            <div class="mt-2">
                <div class="text-secondary">
                    Total Stok
                </div>
                <div class="font-weight-bold text__primary">
                    {{ $stok }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-12 mb-md-0 mb-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <img src="{{ asset('gambar/icon/diagram-stokpng.png') }}" class="mr-3"  alt="">
                <h5 class="font-weight-bold">Pembelian Produk</h5>
            </div>
            <div class="mt-2">
                <div class="text-secondary">
                    Total pembelian
                </div>
                <div class="font-weight-bold text__primary">
                    {{ $total_qty }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-body mt-4">
    <div class="row no-gutters">
        <div class="col text-center icon_status">
            <div class="position-relative d-inline-block">
                <img src="{{ asset('gambar/icon/dompet.png') }}" alt="">
                @if ($count_unpaid > 0)
                    <span class="count_status">{{ $count_unpaid }}</span>
                @endif
            </div>
            <div class="mt-1 status">Belum dibayar</div>
        </div>
        <div class="col text-center icon_status">
            <div class="position-relative d-inline-block">
                <img src="{{ asset('gambar/icon/dikemas.png') }}" alt="">
                @if ($count_dikemas > 0)
                    <span class="count_status">{{ $count_dikemas }}</span>
                @endif
            </div>
            <div class="mt-1 status">Dikemas</div>
        </div>
        <div class="col text-center icon_status">
            <div class="position-relative d-inline-block">
                <img src="{{ asset('gambar/icon/dikirim.png') }}" alt="">
                @if ($count_dikirim > 0)
                    <span class="count_status">{{ $count_dikirim }}</span>
                @endif
            </div>
            <div class="mt-1 status">Dikirim</div>
        </div>
        <div class="col text-center icon_status">
            <div class="position-relative d-inline-block">
                <img src="{{ asset('gambar/icon/penilain.png') }}" alt="">
                @if ($count_penilaian > 0)
                    <span class="count_status">{{ $count_penilaian }}</span>
                @endif
            </div>
            <div class="mt-1 status">Beri penilaian</div>
        </div>
    </div>
</div>

<section class="riwayat_transaksi">
    <div class="row mt-3">
        <div class="col-12 mt-2">
        <h5 class="mb-3">Riwayat Transaksi</h5>
        @foreach ($detail_transaksi as $transaction)
            <a
                href="{{ route('transaksi-detail') }}?inv={{ $transaction->transaksi->no_inv }}"
                class="card card-list d-block"
            >
                <div class="card-body">
                <div class="row">
                    <div class="col-md-1 d-flex align-items-center">
                    <img
                        src="{{ url($transaction->produk->thumbnail->photo) }}"
                        class="w-75"
                    />
                    </div>
                    <div class="col-md-4">
                    <span>{{ $transaction->produk->nama ?? '' }}</span>  <div class="harga">Rp{{ number_format($transaction->produk->harga) }}<span> qty: {{ $transaction->qty }}</span></div>

                    </div>
                    <div class="col-md-3">
                    <span>Status Pembayaran</span>
                        <div class="harga">
                            @if ($transaction->transaksi->status === 'UNPAID')
                                <span class="text-warning">Belum dibayar</span>
                            @endif
                            @if ($transaction->transaksi->status === 'penilaian')
                                <span class="text-secondary">Beri penilaian</span>
                            @endif
                            @if ($transaction->transaksi->status === 'selesai')
                                <span class="text-success">Selesai</span>
                            @endif
                            @if ($transaction->transaksi->status === 'PAID' || $transaction->status === 'dikemas')
                                    <span class="text-success">dikemas</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                    {{ $transaction->created_at ?? '' }}
                    </div>
                    <div class="col-md-1 d-none d-md-block">
                    <img
                        src="images/dashboard-arrow-right.svg"
                        alt=""
                    />
                    </div>
                </div>
                </div>
            </a>
        @endforeach
        </div>
    </div>
</section>
@endsection
