@extends('layouts.frontend')

@section('title')
    Keranjang Produk Saya
@endsection

@push('addStyle')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
@endpush

@section('content')
    <section class="md:px-32 px-6 mt-6 md:mt-12">
        <div class="md:px-20">
            <div class="grid grid-flow-row grid-cols-12 gap-6">
                <div class="md:col-span-8 col-span-12">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="justify-between flex border p-2 md:p-4 rounded-lg w-full relative mb-6">
                            <div class="flex ">
                                <img src="https://img.freepik.com/premium-psd/cosmetic-tube-packaging-mockups_144389-269.jpg?w=900" class="rounded-lg w-28" alt="">
                                <div class="my-auto ml-4">
                                    <div class="text-xs md:text-sm ">
                                        WhiteCellDNA™ Night Cream
                                    </div>
                                    <div class="text-xs md:text-sm font-semibold">
                                        Rp400,0000
                                    </div>
                                </div>
                            </div>

                            <div class="z-20  items-center justify-between">
                                <div class="absolute top-0 right-0 p-2 md:p-4">
                                    <label>
                                    <input type="checkbox" class="form-checkbox rounded text-primary border-2 border-gray-500 md:w-5 md:h-5 w-4 h-4" >
                                    </label>
                                </div>
                                <div class=" absolute bottom-0 right-0 z-10 p-4 hidden md:block">
                                    <div class="flex relative justify-between items-center p-1 border rounded-full w-full">
                                        <img src="{{ asset('gambar/icon/min-circle.png') }}" alt="" class="opacity-60 w-4 z-10 mr-6 cursor-pointer">

                                        <div class="font-bold text-sm">
                                            1
                                        </div>
                                        <div class="">
                                            <img src="{{ asset('gambar/icon/plus-circle.png') }}" alt="" class="w-4 z-10 ml-6 relative cursor-pointer">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="absolute bottom-0 right-0 p-2 md:hidden">
                                <div class="flex relative justify-between items-center p-1 border rounded-full w-full">
                                    <img src="{{ asset('gambar/icon/min-circle.png') }}" alt="" class="opacity-60 w-4 z-10 mr-3 cursor-pointer">

                                    <div class="font-bold text-sm">
                                        1
                                    </div>
                                    <div class="">
                                        <img src="{{ asset('gambar/icon/plus-circle.png') }}" alt="" class="w-4 z-10 ml-3 relative cursor-pointer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="col-span-4 md:block hidden">
                    <div class="border rounded-xl p-4 md:sticky md:top-20 ">
                        <div class="font-bold text-gray-800">
                            Ringkasan Belanja
                        </div>
                        <div class="text-gray-600 mt-3 flex justify-between">
                            <div class="">
                                Total Harga
                            </div>
                            <div class="">Rp800,0000</div>
                        </div>
                        <div class="text-gray-600 mt-3 flex justify-between">
                            <div class="">
                                Diskon Barang
                            </div>
                            <div class="">Rp400,0000</div>
                        </div>
                        <hr class="my-4">
                        <div class="font-bold text-gray-800 flex justify-between">
                            <div class="">Subtotal</div>
                            <div class="">Rp400,000</div>
                        </div>
                        <div class="">
                            <a href="{{ route('proses-transaksi') }}">
                                <div class="mt-8 bg-primary py-2 rounded-xl text-center text-white">
                                    Beli
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="border w-full p-4 fixed bg-white bottom-0 z-40 text-xs md:hidden">
        <div class="text-gray-600  flex justify-between">
            <div class="">
                Total Harga
            </div>
            <div class="">Rp800,0000</div>
        </div>
        <div class="text-gray-600 mt-3 flex justify-between">
            <div class="">
                Diskon Barang
            </div>
            <div class="">Rp400,0000</div>
        </div>
        <hr class="my-4">
        <div class="font-bold text-gray-800 flex justify-between text-sm">
            <div class="">Subtotal</div>
            <div class="">Rp400,000</div>
        </div>
        <div class="mt-6 bg-primary py-2 rounded-xl text-center text-white text-sm">
            Beli
        </div>
    </div>
@endsection
