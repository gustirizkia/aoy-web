@extends('layouts.dashboard')

@section('title')
    Transaksi
@endsection

@push('addStyle')
    <style>
        .item_jenis_inv{
            font-weight: 500;
            font-size: 18px;
            line-height: 27px;
            color: #9191A9;
            cursor: pointer;
        }
        .item_jenis_inv.active{
            color: #0C0D36;
            border-bottom: 3px #0C0D36 solid;
        }

        .statistik .card{
            border-radius: 10px;
        }
        .riwayat_transaksi .harga{
            line-height: 1;
            font-size: 14px
        }
    </style>
@endpush

@section('content')
    <section x-data="funcData">
        <div class="header mb-5">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <div class="item_jenis_inv " :class="!pembelian ? 'active' : ''" @click="() =>{pembelian = false}">
                            Penjualan
                        </div>
                        <div class="item_jenis_inv ml-5" :class="pembelian ? 'active' : ''" @click="() =>{pembelian = true}">
                            Pembelian
                        </div>
                    </div>
                    <div class="">
                        <a href="{{ route('dashboard-transaksi-create') }}" class="btn btn__primary">Buat Invoice</a>
                    </div>
                </div>
            </div>
        </div>


        {{-- pembelian --}}
        <section x-show="pembelian">
            @foreach ($pembelian as $transaction)
                <a
                    href=""
                    class="card card-list d-block"
                >
                    <div class="card-body">
                    <div class="row align-items-center">
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
                        <span>Status</span>
                            <div class="harga">
                                @if ($transaction->transaksi->status === 'UNPAID')
                                    <span class="text-warning">Belum dibayar</span>
                                @endif
                                @if ($transaction->transaksi->status === 'selesai')
                                    <span class="text-success">Selesai</span>
                                @endif
                                @if ($transaction->transaksi->status === 'PAID')
                                    <span class="text-success">dibayar</span>
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
        </section>

        {{-- penjualan --}}
        <section x-show="!pembelian">
            @foreach ($penjualan as $transaction)
                <a
                    href=""
                    class="card card-list d-block"
                >
                    <div class="card-body">
                    <div class="row align-items-center">
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
                        <span>Status</span>
                            <div class="harga">
                                @if ($transaction->transaksi->status === 'UNPAID')
                                    <span class="text-warning">Belum dibayar</span>
                                @endif
                                @if ($transaction->transaksi->status === 'selesai')
                                    <span class="text-success">Selesai</span>
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
        </section>
    </section>
@endsection

@push('addScript')
    <script>
        function funcData(){
            return{
                pembelian: false,

            }
        }
    </script>
@endpush
