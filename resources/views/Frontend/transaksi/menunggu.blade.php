@extends('layouts.frontend')

@section('title')
    Menunggu Pembayaran
@endsection

@section('content')
    <div class="md:px-32 px-6 md:mt-8 mt-6">
        <div class="md:px-20">
            <div class="grid grid-flow-row grid-cols-12 gap-6">
                <div class="col-span-6 hidden md:flex justify-center items-center">
                    <img src="{{ asset('gambar/detail-transaksi.png') }}" class="w-1/2" alt="">
                </div>
                <div class="md:col-span-6 col-span-12">
                    <div class="bg-white p-6 rounded-lg text-gray-800">
                        <div class="md:flex justify-between">
                            <div class="font-bold text-lg">
                                Batas akhir pembayaran
                            </div>
                            <div class="text-red-600">
                                59:00
                            </div>
                        </div>

                        <div class="text-lg mt-4">
                            Rincian pembayaran
                        </div>

                        <div class="flex mt-6">
                            <img src="{{ asset('gambar/icon/bri.png') }}" alt="" class="">
                            <div class="ml-6">
                                BRI Virtual Account
                            </div>
                        </div>

                        <div class="md:flex justify-between text-sm">
                            <div class="mt-8">
                                <div class="text-gray-500">
                                    Nomor Virtual Account
                                </div>

                                <div class="flex mt-2">
                                    <div class="font-medium">
                                        70071829471259461
                                    </div>
                                    <div class="text-primary font-semibold ml-2">
                                        Salin
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <div class="text-gray-500">
                                    Total pembayaran
                                </div>

                                <div class="flex mt-2">
                                    <div class="font-medium">
                                        Rp900,0000
                                    </div>
                                    <div class="">
                                        <a href="{{ route('transaksi-detail') }}">
                                            <div class="text-primary font-semibold ml-2">
                                                Lihat rincian
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="bg-white p-6 rounded-lg text-gray-800 mt-6">
                        <div class="text-lg font-semibold">
                            Intruksi pembayaran
                        </div>

                        <div class="mt-6">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    Melalui Mobile Banking
                                </div>
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <hr>
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    Melalui ATM
                                </div>
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
