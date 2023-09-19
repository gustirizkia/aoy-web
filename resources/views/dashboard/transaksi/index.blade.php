@extends('layouts.dashboard')

@section('title')
    Transaksi
@endsection

@push('addStyle')
    <style>
        .item_jenis_inv {
            font-weight: 500;
            font-size: 18px;
            line-height: 27px;
            color: #9191A9;
            cursor: pointer;
        }

        .item_jenis_inv.active {
            color: #0C0D36;
            border-bottom: 3px #0C0D36 solid;
        }

        .statistik .card {
            border-radius: 10px;
        }

        .riwayat_transaksi .harga {
            line-height: 1;
            font-size: 14px
        }

        @media (max-width: 991.98px) {
            .item_jenis_inv {
                font-size: 14px;
            }

            .w-75 {
                width: 15% !important;
            }
        }

        .card-list .card-body {
            line-height: unset;
            font-size: 12px;
            padding: 8px;

        }
    </style>
@endpush


@section('content')
    <section x-data="funcData">
        <div class="header mb-md-5 mb-3">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">

                        <div class="item_jenis_inv " :class="pembelian ? 'active' : ''"
                            @click="() =>{pembelian = true}">
                            Pembelian
                        </div>

                        @if (auth()->user()->level)
                            <div class="item_jenis_inv ml-md-5 ml-3" :class="!pembelian ? 'active' : ''" @click="() =>{pembelian = false}">
                                Penjualan
                            </div>
                        @endif
                    </div>
                    @if (auth()->user()->level)
                        <div class="">
                            <a href="{{ route('dashboard-transaksi-create') }}" class="btn btn__primary btn-sm">Buat Invoice</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        {{-- pembelian --}}
        <section x-show="pembelian">
            @forelse ($pembelian as $transaction)
                {{-- mobile view --}}
                <a href="{{ route('transaksi-detail') }}?inv={{ $transaction->transaksi->no_inv }}"
                    class="card card-list d-md-none">
                    <div class="card-body">
                        <div class="">
                            <div class=" d-flex align-items-center">
                                <img src="{{ url($transaction->produk->thumbnail->photo) }}" class="w-75" />
                                <div class="ml-2 w-100">
                                    <div>{{ $transaction->produk->nama ?? '' }}</div>

                                    <div class="w-100">
                                        <div class="d-flex">
                                            <span class="mr-2">Status</span>
                                            <div class="harga">
                                                @if ($transaction->transaksi->status === 'UNPAID')
                                                    <span class="text-warning">Belum dibayar</span>
                                                @endif
                                                @if ($transaction->transaksi->status === 'konfirmasi')
                                                    <span class="text-warning">Butuh konfirmasi</span>
                                                @endif
                                                @if ($transaction->transaksi->status === 'selesai')
                                                    <span class="text-success">Selesai</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between w-100">
                                            <div class="harga">
                                                Rp{{ number_format($transaction->produk->harga) }}<span> qty:
                                                    {{ $transaction->qty }}</span>
                                            </div>
                                            <div class="">
                                                {{ $transaction->created_at ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1 d-none d-md-block">
                                <img src="images/dashboard-arrow-right.svg" alt="" />
                            </div>
                        </div>
                    </div>
                </a>
                {{-- mobile view end --}}
                <a href="{{ route('transaksi-detail') }}?inv={{ $transaction->transaksi->no_inv }}"
                    class="card card-list d-md-block d-none">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-1 d-flex align-items-center">
                                <img src="{{ url($transaction->produk->thumbnail->photo) }}" class="w-75" />
                            </div>
                            <div class="col-md-4">
                                <span>{{ $transaction->produk->nama ?? '' }}</span>
                                <div class="harga">Rp{{ number_format($transaction->produk->harga) }}<span> qty:
                                        {{ $transaction->qty }}</span>
                                </div>

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
                                    @if ($transaction->transaksi->status === 'konfirmasi')
                                        <span class="text-warning">Butuh konfirmasi</span>
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
                                <img src="images/dashboard-arrow-right.svg" alt="" />
                            </div>
                        </div>
                    </div>
                </a>

            @empty
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Belum ada pembelian</h5>
                    </div>
                </div>
            @endforelse
        </section>

        {{-- penjualan --}}
        <section x-show="!pembelian">
            @forelse ($penjualan as $transaction)
                <a href="{{ route('transaksi-detail') }}?inv={{ $transaction->transaksi->no_inv }}"
                    class="card card-list d-md-block d-none">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-1 col-3 d-flex align-items-center">
                                <img src="{{ url($transaction->produk->thumbnail->photo) }}" class="w-75" />
                            </div>
                            <div class="col-md-4">
                                <span>{{ $transaction->produk->nama ?? '' }}</span>
                                <div class="harga">Rp{{ number_format($transaction->produk->harga) }}<span> qty:
                                        {{ $transaction->qty }}</span></div>

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
                                <img src="images/dashboard-arrow-right.svg" alt="" />
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('transaksi-detail') }}?inv={{ $transaction->transaksi->no_inv }}"
                    class="card card-list d-md-none">
                    <div class="card-body">
                        <div class="">
                            <div class=" d-flex align-items-center">
                                <img src="{{ url($transaction->produk->thumbnail->photo) }}" class="w-75" />
                                <div class="ml-2 w-100">
                                    <div>{{ $transaction->produk->nama ?? '' }}</div>

                                    <div class="w-100">

                                        <div class="d-flex justify-content-between w-100">
                                            <div class="harga">
                                                Rp{{ number_format($transaction->produk->harga) }}<span> qty:
                                                    {{ $transaction->qty }}</span>
                                            </div>
                                            <div class="">
                                                {{ $transaction->created_at ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1 d-none d-md-block">
                                <img src="images/dashboard-arrow-right.svg" alt="" />
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Belum ada penjualan</h5>
                    </div>
                </div>
            @endforelse
        </section>
    </section>
@endsection

@push('addScript')
    <script>
        function funcData() {
            return {
                pembelian: true,

            }
        }
    </script>
@endpush
