@extends('layouts.frontend')

@section('title')
    Proses Order
@endsection

@section('content')
<div class="md:px-64 mt-2 md:mt-8">
    <div class="grid grid-flow-row grid-cols-12 gap-6">
        <div class="col-span-12 md:col-span-8">
            <div class="bg-white rounded-xl py-4">
                <div class="flex justify-between px-6 items-center">
                    <div class="text-lg ">Alamat Pengiriman</div>
                    <div class="bg-[#F258FF] px-3 py-1 text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer">Pilih alamat lain</div>
                </div>


                <hr class="my-4">
                <div class="text-sm px-4">
                    <div class="font-medium">Rumah</div>
                    <div class="text-gray-600 text-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat quo et eos in hic, quasi necessitatibus, amet autem, asperiores a dolores ea distinctio similique corrupti libero labore nulla velit reiciendis!</div>
                </div>
            </div>
            <div class="my-2">
                @for ($i = 0; $i < 2; $i++)
                        <div class="justify-between flex p-2 md:p-4 rounded-lg w-full relative mb-2 bg-white">
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
                        </div>
                @endfor
            </div>
            <div class="mb-2">
                <div class="bg-white rounded-xl p-4 md:flex justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('gambar/icon/delivery.png') }}" class="w-12" alt="">
                        <div class="ml-6">
                            <div class="text-base font-medium">
                                Metode Pengiriman
                            </div>
                            <div class="text-base font-medium mt-1">
                                SiCepat Reg (Rp. 8.000)
                            </div>
                            <div class="text-xs">
                                Estimasi tiba 12-14 Desember
                            </div>
                        </div>
                    </div>

                    <div class="flex items-end mt-3 md:mt-0 justify-end">
                        <div class="bg-[#F258FF] px-3 py-1 text-xs md:text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer inline" onclick="modalKurir()">Pilih kurir</div>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <div class="bg-white rounded-xl p-4 md:flex justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('gambar/icon/bca.png') }}" class="w-12" alt="">
                        <div class="ml-6">
                            <div class="text-base font-medium">
                                Metode Pembayaran
                            </div>
                            <div class="text-base font-medium mt-1">
                                VA - BCA
                            </div>
                        </div>
                    </div>

                    <div class="flex items-end mt-3 md:mt-0 justify-end">
                        <div class="bg-[#F258FF] px-3 py-1 text-xs md:text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer inline" onclick="modalPayment()">Pilih pembayaran</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-4">
            <div class="bg-white p-4">
                <div class="font-semibold mb-4">Ringkasan belanja</div>
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
                <a href="{{ route('transaksi-pending') }}">
                    <div class="mt-6 bg-primary py-2 rounded-xl text-center text-white text-sm">
                        Beli
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- modal alamat --}}
<div class="hidden" id="modal_pembayaran">
    <div class="">
        <div class="flex justify-between items-center">
            <div class="font-bold mb-7">Pilih metode pembayaran</div>
        </div>
        <div class="absolute top-0 right-0 p-2 cursor-pointer" onclick="hiddenModal('modal_alamat')">
            <img src="{{ asset('gambar/icon/close.png') }}" alt="" class="w-8 ">
        </div>
        <div class="">
            <div class="flex justify-between">
                <div class="">
                    <div class="flex ">
                        <img src="{{ asset('gambar/icon/bca.png') }}" alt="" class="w-16">
                        <div class="ml-4 font-semibold">
                            BCA Virtual Account
                        </div>
                    </div>
                </div>
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
            <div class="">
                <hr class="my-5 bg-gray-300">
            </div>
        </div>
        <div class="">
            <div class="flex justify-between">
                <div class="">
                    <div class="flex ">
                        <img src="{{ asset('gambar/icon/bri.png') }}" alt="" class="w-16">
                        <div class="ml-4 font-semibold">
                            BRI Virtual Account
                        </div>
                    </div>
                </div>
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
            <div class="">
                <hr class="my-5 bg-gray-300">
            </div>
        </div>
        <div class="">
            <div class="flex justify-between">
                <div class="">
                    <div class="flex ">
                        <img src="{{ asset('gambar/icon/indomaret.png') }}" alt="" class="w-16">
                        <div class="ml-4 font-semibold">
                            Indomaret
                        </div>
                    </div>
                </div>
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
            <div class="">
                <hr class="my-5 bg-gray-300">
            </div>
        </div>
    </div>
    <div class=" h-screen w-full bg-gray-800 bg-opacity-20 top-0 fixed flex items-center justify-center"  onclick="hiddenModal('modal_alamat')">
    </div>
</div>


@endsection

@push('addScript')
    <script>
        function hiddenModal(id){
            $('#'+id).addClass('hidden');
        }

        function modalPayment(){
            Swal.fire({
                html: `
                    <div class="">
                        <div class="flex justify-between items-center">
                            <div class="font-bold mb-7">Pilih metode pembayaran</div>
                        </div>

                        <div class="">
                            <div class="flex justify-between">
                                <div class="">
                                    <div class="flex ">
                                        <img src="{{ asset('gambar/icon/bca.png') }}" alt="" class="w-16">
                                        <div class="ml-4 font-semibold">
                                            BCA Virtual Account
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="">
                                <hr class="my-5 bg-gray-300">
                            </div>
                        </div>
                        <div class="">
                            <div class="flex justify-between">
                                <div class="">
                                    <div class="flex ">
                                        <img src="{{ asset('gambar/icon/bri.png') }}" alt="" class="w-16">
                                        <div class="ml-4 font-semibold">
                                            BRI Virtual Account
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="">
                                <hr class="my-5 bg-gray-300">
                            </div>
                        </div>
                        <div class="">
                            <div class="flex justify-between">
                                <div class="">
                                    <div class="flex ">
                                        <img src="{{ asset('gambar/icon/indomaret.png') }}" alt="" class="w-16">
                                        <div class="ml-4 font-semibold">
                                            Indomaret
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="">
                                <hr class="my-5 bg-gray-300">
                            </div>
                        </div>
                    </div>
                `,
                showConfirmButton : false,
                width: "800px"
            })
        }
        function modalKurir(){
            Swal.fire({
                html: `
                    <div class="">
                        <div class="flex justify-between items-center">
                            <div class="font-bold mb-7">Pilih metode pengiriman</div>
                        </div>

                        <div class="">
                            <div class="flex justify-between items-center">
                                <div class="">
                                    <div class="flex items-center">
                                        <img src="{{ asset('gambar/icon/sicepat.png') }}" alt="" class="w-16">
                                        <div class="ml-4 font-semibold">
                                            SiCepat (Rp9.000)
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="">
                                <hr class="my-5 bg-gray-300">
                            </div>
                        </div>
                        <div class="">
                            <div class="flex justify-between">
                                <div class="">
                                    <div class="flex ">
                                        <img src="{{ asset('gambar/icon/jne.png') }}" alt="" class="w-16">
                                        <div class="ml-4 font-semibold">
                                            JNE (Rp8.000)
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="">
                                <hr class="my-5 bg-gray-300">
                            </div>
                        </div>

                    </div>
                `,
                showConfirmButton : false,
                width: "800px"
            })
        }

        function showModal(id){
            $('#'+id).removeClass('hidden');
        }
    </script>
@endpush
