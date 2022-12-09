@extends('layouts.frontend')

@section('title')
    Rincian Transaksi
@endsection

@section('content')
    <div class="md:px-32 md:mt-8 mt-6">
        <div class="md:px-20">
            <div class="grid grid-flow-row grid-cols-12 gap-6">
                <div class="col-span-4 hidden md:block">
                    <div class="bg-white p-4 rounded-lg">
                        <div class="font-semibold">
                            Rincian Transaksi
                        </div>
                        <div class="mt-6 text-gray-800 relative">

                            <div class="flex items-center relative ">
                                <div class="relative ">
                                    <img src="{{ asset('gambar/icon/checked.png') }}" class="w-6 z-20 relative" alt="">
                                </div>
                                <div class="ml-5">
                                    Menunggu pembayaran
                                </div>
                            </div>
                            <div class="relative w-6 h-24">
                                <div class="h-full bg-primary w-1 rounded-full absolute -top-2 left-1/2 transform -translate-x-1/2"></div>
                            </div>

                            <div class=" -mt-6">
                                <div class="flex items-center relative ">
                                    <div class="relative">
                                        <div class="bg-purple-100 z-20 relative w-6 h-6 rounded-full">

                                        </div>
                                    </div>
                                    <div class="ml-5">
                                        Sedang dikemas
                                    </div>
                                </div>
                                 <div class="relative w-6 h-24">
                                    <div class="h-full bg-purple-100 bg-opacity-50 w-1 rounded-full absolute -top-1 left-1/2 transform -translate-x-1/2"></div>
                                </div>
                            </div>
                        </div>
                            <div class=" -mt-6">
                                <div class="flex items-center relative ">
                                    <div class="relative">
                                        <div class="bg-purple-100 z-20 relative w-6 h-6 rounded-full">

                                        </div>
                                    </div>
                                    <div class="ml-5">
                                        Pesanan sedang dikirim
                                    </div>
                                </div>
                                 <div class="relative w-6 h-24">
                                    <div class="h-full bg-purple-100 bg-opacity-50 w-1 rounded-full absolute -top-1 left-1/2 transform -translate-x-1/2"></div>
                                </div>
                            </div>
                            <div class=" -mt-6">
                                <div class="flex items-center relative ">
                                    <div class="relative">
                                        <div class="bg-purple-100 z-20 relative w-6 h-6 rounded-full">

                                        </div>
                                    </div>
                                    <div class="ml-5">
                                        Pesanan sudah diterima
                                    </div>
                                </div>

                            </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-8">
                    <div class="rounded-lg bg-white p-4 md:p-8">
                        <div class="font-bold">
                            Rincian Pesanan
                        </div>
                        <div class="mt-6 md:flex justify-between">
                            <div class="">
                                <div class="text-gray-500">
                                    No. Invoice
                                </div>
                                <div class="mt-2 font-medium">
                                    INV/AS/129412/1925615912581
                                </div>
                            </div>

                            <div class="md:mt-0 mt-4">
                                <div class="text-gray-500">
                                    Metode pembayaran
                                </div>
                                <div class="mt-2 font-medium">
                                    BCA Virtual Account
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="text-gray-500">
                                Lokai tujuan
                            </div>
                            <div class=" font-medium">
                                Apartemen Yukata Suite
                            </div>
                            <div class="text-gray-500 text-sm">
                                Jl. Alam Sutera Boulevard No. 22, Pakualam, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15320, Indonesia
                            </div>
                        </div>

                        {{-- list produk desktop --}}
                        <div class="mt-6 md:block hidden">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <img src="https://img.freepik.com/premium-psd/logo-mockup-stand-face-hand-cream_145275-462.jpg?w=900" alt="" class="w-28 rounded-lg">
                                    <div class="mx-6">
                                        2x
                                    </div>
                                    <div class="">
                                        WhiteCellDNA™ Night Cream
                                    </div>
                                </div>
                                <div class="font-semibold">
                                    Rp 3.000.000
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 md:hidden">
                            <div class="grid grid-flow-row grid-cols-12 gap-3">
                                <div class="col-span-3 my-auto">
                                <img src="https://img.freepik.com/premium-psd/logo-mockup-stand-face-hand-cream_145275-462.jpg?w=900" class="w-full rounded-lg" alt="">
                                </div>
                                <div class="text-xs col-span-9">
                                    <div class="font-semibold ">
                                        WhiteCellDNA™ Night Cream
                                    </div>
                                    <div class="text-gray-600">
                                        2x
                                        <div class="text-gray-800 font-medium">
                                            Rp 3.000.000
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-6">
                            <hr>
                        </div>

                        <div class="flex justify-end w-full">
                            <div class="">
                                <div class=" flex justify-between w-72 text-gray-500 mb-3">
                                    <div class="">
                                        Harga barang
                                    </div>
                                    <div class="text-gray-900">Rp7000,000</div>
                                </div>
                                <div class=" flex justify-between w-72 text-gray-500 mb-3">
                                    <div class="">
                                        Biaya Pengiriman
                                    </div>
                                    <div class="text-gray-900">Rp7000,000</div>
                                </div>
                                <div class=" flex justify-between w-72 text-gray-500 mb-3">
                                    <div class="">
                                        Potongan
                                    </div>
                                    <div class="text-gray-900">Rp400,000</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <div class="bg-primary px-4 py-3 rounded-xl inline-block text-white cursor-pointer">Konfirmasi Penerima</div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div>
@endsection
