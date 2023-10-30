@extends('layouts.frontend')

@section('title')
    Proses Order
@endsection

@section('addStyle')
    <link href="{{ asset('style/main.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <section x-data="funcData">
        <template class="" x-if="loadingCO">
            <div  class="fixed top-0 flex items-center justify-center h-screen w-full bg-slate-600 bg-opacity-25 z-50">
                <div class="text-center">
                    <div role="status">
                        <svg aria-hidden="true" class="w-8 h-8 mx-auto text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="text-lg font-medium">Loading</div>
                </div>
            </div>
        </template>
        <div class="md:px-64 mt-2 md:mt-8">
            <div class="grid grid-flow-row grid-cols-12 gap-6">
                <div class="col-span-12 md:col-span-8">
                    <div class="bg-white rounded-xl py-4">
                        <div class="flex justify-between px-6 items-center">
                            <div class="text-lg ">Alamat Pengiriman</div>
                            @if ($address_active)
                                <div class="bg-[#F258FF] px-3 py-1 text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer"
                                    @click="handleModalPilihAlamat">Pilih alamat lain</div>
                            @else
                                <div class="bg-[#F258FF] px-3 py-1 text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer"
                                    @click="modalTambahAlamatBaru">Tambah alamat</div>
                            @endif
                        </div>

                        @if ($address_active)
                            <hr class="my-4">
                            <div class="text-sm px-4">
                                <div class="font-medium" x-text="alamat_active.city_name">Rumah</div>
                                <div class="text-gray-600 text-xs" x-text="alamat_active.address"></div>
                            </div>
                        @endif

                    </div>
                    <div class="my-2">
                        @foreach ($detail_transaksi as $item)
                            <div class="justify-between flex p-2 md:p-4 rounded-lg w-full relative mb-2 bg-white">
                                <div class="flex ">
                                    <img src="{{ url($item->produk->thumbnail->photo) }}" class="rounded-lg w-28"
                                        alt="">
                                    <div class="my-auto ml-4">
                                        <div class="text-xs md:text-sm ">
                                            {{ $item->produk->nama }}
                                        </div>

                                        <div class="text-xs md:text-sm font-semibold my-1">
                                            Rp{{ number_format($item->produk->harga) }}
                                        </div>
                                        <div class="text-xs md:text-xs text-gray-500">
                                            total : {{ $item->qty }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-2">
                        <div class="bg-white rounded-xl p-4 md:flex justify-between">
                            <div class="flex items-center w-full">
                                <img src="{{ asset('gambar/icon/delivery.png') }}" class="w-12" alt="">
                                <div class="ml-6 w-full">
                                    <div class="text-base font-medium">
                                        Metode Pengiriman
                                    </div>
                                    <select id="underline_select" x-model="selectCodeKurir"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 font-medium bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                        <option value="{{ $sicepat['code'] }}">Sicepat Reg </option>
                                        <option value="{{ $jne['code'] }}">JNE Reg</option>
                                        <option value="{{ $anteraja['code'] }}">AntarAja Reg</option>
                                    </select>
                                    <div class="text-sm font-medium mt-1">
                                        Rp<span x-text="selectKurir.cost.toLocaleString()"></span>
                                    </div>
                                    <div class="text-xs" x-text="'Estimasi '+selectKurir.estimasi+' hari'">

                                    </div>
                                </div>
                            </div>

                            {{-- <div class="flex items-end mt-3 md:mt-0 justify-end">
                                <div class="bg-[#F258FF] px-3 py-1 text-xs md:text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer inline"
                                    @click="handleModalPilihKurir">Pilih kurir</div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="bg-white rounded-xl p-4 md:flex justify-between">
                            <div class="flex items-center">
                                <img :src="selectPembayaran.icon_url" class="w-12" alt="">
                                <div class="ml-6">
                                    <div class="text-base font-medium">
                                        Metode Pembayaran
                                    </div>
                                    <div class="text-sm font-medium mt-1">
                                        <span
                                            x-text="selectPembayaran.name +' (Rp'+$store.global.numberWithCommas($store.global.biayaAdmin)+')'"></span>
                                    </div>
                                    <div class="" x-text=""></div>
                                </div>
                            </div>

                            <div class="flex items-end mt-3 md:mt-0 justify-end">
                                <div class="bg-[#F258FF] px-3 py-1 text-xs md:text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer inline"
                                    @click="handleModalPilihPayment">Pilih pembayaran</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4">
                    <div class="bg-white p-4">
                        <div class="font-semibold mb-4">Ringkasan belanja</div>
                        <div class="text-gray-600  flex justify-between">
                            <div class="">
                                Total Harga Produk
                            </div>
                            <div class="">Rp{{number_format($transaksi->total_harga_barang)}}
                            </div>
                        </div>
                        <div class="text-gray-600 mt-3 flex justify-between">
                            <div class="">
                                Diskon Barang
                            </div>
                            <div class="" x-text="'Rp'+$store.global.numberWithCommas($store.global.diskon)"></div>
                        </div>
                        <div class="text-gray-600 mt-3 flex justify-between">
                            <div class="">
                                Biaya Admin
                            </div>
                            <div class="" x-text="'Rp'+$store.global.numberWithCommas($store.global.biayaAdmin)">
                            </div>
                        </div>
                        <div class="text-gray-600 mt-3 flex justify-between">
                            <div class="">
                                Ongkos Kirim
                            </div>
                            <div class="" x-text="'Rp'+$store.global.numberWithCommas(selectKurir.cost)"></div>
                        </div>
                        <hr class="my-4">
                        <div class="font-bold text-gray-800 flex justify-between text-sm">
                            <div class="">Subtotal</div>
                            <div class="" x-text="'Rp'+$store.global.numberWithCommas((total_harga_barang+$store.global.biayaAdmin+selectKurir.cost)-diskon)"></div>
                        </div>
                        <div @click="handleProsesPayment">
                            <div class="mt-6 bg-primary py-2 rounded-xl text-center text-white text-sm cursor-pointer">
                                Beli
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal pilih alamat --}}
        <template x-if="modalPilihAlamat">
            <div class="fixed top-0 h-screen flex flex-col justify-center items-center w-full px-6 md:px-60">
                <div class="bg-gray-700 h-screen w-full absolute bg-opacity-30" @click="handleModalPilihAlamat"></div>
                <div class="bg-white relative z-40 rounded-xl  max-h-[70%] md:w-1/2 w-full">
                    {{-- loading --}}
                    <template x-if="loadingUp">
                        <div class="absolute bg-white rounded-xl h-full w-full flex-col  flex justify-center items-center">
                            <img src="{{ asset('gambar/animate/loading.svg') }}" alt="">
                            <div class="font-semibold text-primary text-xl">Loading</div>
                        </div>
                    </template>
                    {{-- loading --}}
                    <div class=" bg-white border-b mb-3  pb-4 md:pb-5 px-4 md:pt-8 pt-4 rounded-t-xl ">
                        <div class="text-base md:text-lg font-semibold">Pilih alamat pengiriman</div>
                    </div>
                    {{-- body --}}
                    <div class="max-h-80 overflow-auto p-4 md:pb-8 no-scrollbar">
                        <template x-for="item_alamat in list_alamat_user" :key="item_alamat.id">
                            <div :class="alamat_active.id === item_alamat.id ? 'border-primary' : ''"
                                class="border w-full card__pilih__alamat  p-2 rounded-lg mb-4 cursor-pointer"
                                @click="handlePilihAlamat(item_alamat)">
                                <div class="flex justify-between items-center">
                                    <div class="font-medium" x-text="item_alamat.province_name"></div>
                                    <div class="" x-show="alamat_active.id === item_alamat.id">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_79_4458)">
                                                <path
                                                    d="M10.0003 18.3334C5.39783 18.3334 1.66699 14.6026 1.66699 10.0001C1.66699 5.39758 5.39783 1.66675 10.0003 1.66675C14.6028 1.66675 18.3337 5.39758 18.3337 10.0001C18.3337 14.6026 14.6028 18.3334 10.0003 18.3334ZM9.16949 13.3334L15.0612 7.44092L13.8828 6.26258L9.16949 10.9767L6.81199 8.61925L5.63366 9.79758L9.16949 13.3334Z"
                                                    fill="#A349A3" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_79_4458">
                                                    <rect width="20" height="20" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-700"
                                    x-text="item_alamat.kota_name+', '+item_alamat.kecamatan_name">
                                    {{-- {{ $item->kota->name }},
                                    {{ $item->kecamatan->subdistrict_name }} --}}
                                </div>
                                <div class="text-sm text-gray-700" x-text="item_alamat.address"></div>
                            </div>
                        </template>
                    </div>
                    <div class=" bg-white   pb-6 px-4 md:pt-6 rounded-b-xl ">
                        <div class="border-primary border-2 text-primary p-3 cursor-pointer hover:text-gray-800 hover:bg-primary text-center rounded-xl"
                            @click="modalTambahAlamatBaru">Tambah alamat baru</div>
                    </div>
                </div>
            </div>
        </template>
        {{-- modal pilih alamat end --}}


        {{-- modal pilih kurir --}}
        <template x-if="modalPilihKurir">
            <div class="fixed top-0 h-screen flex flex-col justify-center items-center w-full px-6 md:px-60">
                <div class="bg-gray-700 h-screen w-full absolute bg-opacity-30" @click="handleModalPilihKurir"></div>
                <div class="bg-white relative z-40 rounded-xl  max-h-[70%] md:w-1/2 w-full">
                    <div class=" bg-white mb-3 md:mb-0  pb-4  px-4  pt-4 rounded-t-xl ">
                        <div class="text-base md:text-lg font-semibold">Pilih kurir</div>
                    </div>
                    {{-- body --}}
                    <div class="max-h-80 overflow-auto p-4 md:pb-8 no-scrollbar inline-block w-full">
                        <div class="">
                            <div class="flex justify-between items-center cursor-pointer"
                                @click="handleSelectKurir('sicepat')">
                                <div class="">
                                    <div class="flex items-center">
                                        <img src="{{ asset('gambar/icon/sicepat.png') }}" alt="" class="w-16">
                                        <div class="ml-4 font-semibold text-left">
                                            SiCepat Reg (Rp<span
                                                x-text="$store.global.numberWithCommas(sicepat.cost)"></span>)
                                            <p class="font-normal text-gray-500 text-sm">Estimasi pengiriman <span
                                                    x-text="sicepat.estimasi"></span> hari</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="">
                                <hr class="my-5 bg-gray-300">
                            </div>
                        </div>
                        <div class="">
                            <div class="flex justify-between items-center cursor-pointer"
                                @click="handleSelectKurir('jne')">
                                <div class="">
                                    <div class="flex items-center">
                                        <img src="{{ asset('gambar/icon/jne.png') }}" alt="" class="w-16">
                                        <div class="ml-4 font-semibold text-left">
                                            JNE Reg (Rp<span x-text="$store.global.numberWithCommas(jne.cost)"></span>)
                                            <p class="font-normal text-gray-500 text-sm">Estimasi pengiriman <span
                                                    x-text="jne.estimasi"></span> hari</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                            {{-- <div class="">
                            <hr class="my-5 bg-gray-300">
                        </div> --}}
                        </div>
                    </div>
                    {{-- body end --}}

                </div>
            </div>
        </template>
        {{-- modal pilih kurir end --}}

        {{-- modal tambah alamat --}}
        <template x-if="modalTambahAlamat">
            <div class="fixed top-0 h-screen flex flex-col justify-center items-center w-full px-6 md:px-60">
                <div class="bg-gray-700 h-screen w-full absolute bg-opacity-30" @click="modalTambahAlamatBaru"></div>
                <div class="bg-white relative z-40 rounded-xl  max-h-[90%] md:w-1/2">
                    <div class=" bg-white mb-3 md:mb-0  pb-4  px-4  pt-4 rounded-t-xl ">
                        <div class="text-base md:text-lg font-semibold">Tambah Alamat</div>
                    </div>
                    {{-- body --}}
                    <div class=" p-4 md:pb-8 no-scrollbar inline-block w-full">
                        <div class="modal-body relative py-4">
                            <label for="">Provinsi</label>
                            <div
                                class="mb-4 group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full items-center px-3">
                                <select name="" id=""
                                    class="w-full text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-400"
                                    x-model="select_provinsi_id">
                                    @foreach ($list_provinsi as $item)
                                        <option value="{{ $item->province_id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="" class="mt-4">Kota</label>
                            <div
                                class="mb-4 group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full items-center px-3">
                                <select name="" id=""
                                    class=" text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-400 w-full"
                                    x-model="select_kota_id">
                                    <option value="0" disabled>Pilih kota</option>
                                    @foreach ($list_kota as $item)
                                        <option value="{{ $item->city_id }}"
                                            x-show="'{{ $item->province_id }}' === select_provinsi_id">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="" class="mt-4">Kecamatan</label>
                            <div
                                class="mb-4 group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full items-center px-3">
                                <select name="" id=""
                                    class=" text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-400 w-full"
                                    x-model="select_kecamatan_id">
                                    <option value="0" disabled>Pilih kecamatan</option>
                                    <template x-for="(item, index) in kecamatan" :key="index">
                                        <option :value="item.subdistrict_id">
                                            <span x-text="item.subdistrict_name"></span>
                                        </option>
                                    </template>
                                </select>
                            </div>
                            <label for="" class="mt-4">Alamat lengkap</label>
                            <div
                                class=" group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full items-center px-3">
                                <input type="text" x-model="tambah_address"
                                    class="w-full text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-900"
                                    placeholder="Alamat lengkap">
                            </div>
                        </div>
                    </div>
                    {{-- body end --}}
                    <div class="p-4">
                        <button type="button"
                            class="px-6
                        py-2.5
                        bg-primary
                        text-white
                        font-medium
                        text-xs
                        leading-tight
                        uppercase
                        rounded
                        shadow-md
                        hover:bg-purple-700 hover:shadow-lg
                        focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0
                        active:bg-primary active:shadow-lg
                        transition
                        duration-150
                        ease-in-out
                        ml-1"
                            @click="handleTambahAlamat">
                            Simpan Alamat
                        </button>
                    </div>

                </div>
            </div>
        </template>
        {{-- modal tambah alamat end --}}

        {{-- modal tambah alamat --}}
        <template x-if="modalPilihPembayaran">
            <div class="fixed top-0 h-screen flex flex-col justify-center items-center w-full px-6 md:px-60">
                <div class="bg-gray-700 h-screen w-full absolute bg-opacity-30" @click="handleModalPilihPayment"></div>
                <div class="bg-white relative z-40 rounded-xl  max-h-[90%] md:w-1/2">
                    <div class=" bg-white mb-3 md:mb-0  pb-4  px-4  pt-4 rounded-t-xl ">
                        <div class="text-base md:text-lg font-semibold">Pilih Metode Pembayaran</div>
                    </div>
                    {{-- body --}}
                    <div class=" p-4 md:pb-8 max-h-80 overflow-auto  inline-block w-full">
                        @foreach ($channel_pembayaran as $index => $item)
                            <div class="cursor-pointer" @click="handleSelectPembayaran('{{ $item->code }}')">
                                <div class="flex justify-between">
                                    <div class="">
                                        <div class="flex ">
                                            <img src="{{ $item->icon_url }}" alt=""
                                                class="w-12 object-contain h-auto">
                                            <div class="ml-4 font-semibold text-sm">
                                                {{ $item->name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="">
                                    <hr class="my-5 bg-gray-300">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- body end --}}

                </div>
            </div>
        </template>
        {{-- modal tambah alamat end --}}


    </section>
@endsection

@push('addScript')
    <script src="/vendor/jquery/jquery.slim.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        function funcData() {
            return {
                loadingUp: false,
                loadingCO: false,
                modalPilihAlamat: false,
                modalPilihKurir: false,
                modalTambahAlamat: false,
                modalPilihPembayaran: false,
                channelPembayaran: [
                    @foreach ($channel_pembayaran as $item)
                        {
                            code: "{{ $item->code }}",
                            group: "{{ $item->group }}",
                            name: "{{ $item->name }}",
                            icon_url: "{{ $item->icon_url }}",
                            active: "{{ $item->active }}",
                            fee_customer_flat: {{ $item->fee_customer->flat }},
                            fee_customer_percent: {{ $item->fee_customer->percent }},
                        },
                    @endforeach
                ],
                selectPembayaran: {
                    code: "{{ $channel_pembayaran[0]->code }}",
                    group: "{{ $channel_pembayaran[0]->group }}",
                    name: "{{ $channel_pembayaran[0]->name }}",
                    icon_url: "{{ $channel_pembayaran[0]->icon_url }}",
                    active: "{{ $channel_pembayaran[0]->active }}",
                    fee_customer_flat: {{ $channel_pembayaran[0]->fee_customer->flat }},
                    fee_customer_percent: {{ $channel_pembayaran[0]->fee_customer->percent }},
                },
                sub_total: this.$store.global.sub_total,
                diskon: this.$store.global.diskon,
                total_harga_barang: {{$transaksi->total_harga_barang}},
                biayaAdmin: this.$store.global.biayaAdmin,
                list_kota: [
                    @foreach ($list_kota as $item)
                        {
                            id: {{ $item->id }},
                            name: "{{ $item->name }}"
                        },
                    @endforeach
                ],
                kecamatan: [],
                select_provinsi_id: '1',
                select_kota_id: '0',
                tambah_address: "",
                select_kecamatan_id: '0',
                list_alamat_user: [
                    @foreach ($address as $item)
                        {
                            id: {{ $item->id }},
                            address: "{{ $item->address }}",
                            city_id: {{ $item->city_id }},
                            province_id: {{ $item->province_id }},
                            subdistrict_id: {{ $item->subdistrict_id }},
                            kota_name: "{{ $item->kota->name }}",
                            province_name: "{{ $item->provinsi->name }}",
                            kecamatan_name: "{{ $item->kecamatan->subdistrict_name }}"
                        },
                    @endforeach
                ],

                alamat_active: {
                    id: {{ $address_active->id }},
                    address: "{{ $address_active->address }}",
                    city_name: "{{ $address_active->nama_kota }}",
                    province_name: "{{ $address_active->nama_provinsi }}",
                },
                selectKurir: {
                    code: "{{ $sicepat['code'] }}",
                    cost: {{ $sicepat['cost']->value }},
                    estimasi: "{{ $sicepat['cost']->etd }}",
                    name: "Sicepat Reg"
                },
                selectCodeKurir: "{{ $sicepat['code'] }}",
                jne: {
                    code: "{{ $jne['code'] }}",
                    cost: {{ $jne['cost']->value }},
                    estimasi: "{{ $jne['cost']->etd }}",
                    name: "JNE Reg"
                },
                sicepat: {
                    code: "{{ $sicepat['code'] }}",
                    cost: {{ $sicepat['cost']->value }},
                    estimasi: "{{ $sicepat['cost']->etd }}",
                    name: "Sicepat Reg"
                },
                antaraja: {
                    code: "{{ $anteraja['code'] }}",
                    cost: {{ $anteraja['cost']->value }},
                    estimasi: "{{ $anteraja['cost']->etd }}",
                    name: "AntarAja Reg"
                },

                handleModalPilihAlamat() {
                    if (this.modalPilihAlamat) {
                        this.modalPilihAlamat = false;
                    } else {
                        this.modalPilihAlamat = true;
                    }
                },
                handleModalPilihKurir() {

                    if (this.modalPilihKurir) {
                        this.modalPilihKurir = false;
                    } else {
                        this.modalPilihKurir = true;
                    }
                },

                handleSelectKurir(param) {
                    this.$store.global.sub_total -= this.selectKurir.cost;
                    if (param === 'jne') {
                        this.selectKurir = this.jne;
                    } else if (param === 'antaraja') {
                        this.selectKurir = this.antaraja;
                    } else {
                        this.selectKurir = this.sicepat;
                    }
                    this.$store.global.sub_total += this.selectKurir.cost;

                    this.modalPilihKurir = false;
                },

                handlePilihAlamat(param) {
                    console.log('param', param);
                    this.loadingUp = true;

                    axios.post("{{ route('viewOngkirProduct') }}", {
                        address_id: param.id
                    }, {
                        csrfToken: "{{ csrf_token() }}"
                    }).then(res => {
                        // console.log('res ongkir cek jne', res.data.data[0].costs[0].cost[0].value)
                        // console.log('res ongkir cek sicepet', res.data.data[1].costs[1].cost[0])
                        this.jne = {
                            code: "jne",
                            cost: res.data.data[0].costs[0].cost[0].value,
                            estimasi: res.data.data[0].costs[0].cost[0].etd,
                            name: "JNE Reg"
                        }
                        this.sicepat = {
                            code: "sicepat",
                            cost: res.data.data[1].costs[1].cost[0].value,
                            estimasi: res.data.data[1].costs[1].cost[0].etd,
                            name: "Sicepat Reg"
                        }

                        this.$store.global.sub_total -= this.selectKurir.cost;
                        if (this.selectKurir.code === 'jne') {
                            this.selectKurir = this.jne;
                        } else {
                            this.selectKurir = this.sicepat;
                        }
                        this.$store.global.sub_total += this.selectKurir.cost;

                        this.alamat_active = {
                            id: param.id,
                            address: param.address,
                            city_name: param.kota_name,
                            province_name: param.province_name,
                        };
                        this.loadingUp = false;
                    }).catch(err => {
                        this.loadingUp = false;
                    })


                },

                handleChannelPembayaran() {

                },

                cityById(id) {
                    @foreach ($list_kota as $item)
                        if (id === {{ $item->city_id }}) {
                            this.alamat_active.city_name = "{{ $item->name }}";
                        }
                    @endforeach
                },

                modalTambahAlamatBaru() {
                    this.modalPilihAlamat = false;
                    if (this.modalTambahAlamat) {
                        this.modalTambahAlamat = false;
                    } else {
                        this.modalTambahAlamat = true;
                    }
                },

                handleCloseModal() {
                    $('#exampleModal').modal('hide')
                },

                handleTambahAlamat() {
                    axios.post("{{ route('tambah-alamat') }}", {
                        province_id: this.select_provinsi_id,
                        city_id: this.select_kota_id,
                        address: this.tambah_address,
                        subdistrict_id: this.select_kecamatan_id
                    }, {
                        csrfToken: "{{ csrf_token() }}",
                    }).then(ress => {
                        let result = ress.data;
                        this.alamat_active.address = result.address;
                        this.alamat_active.city_name = result.nama_kota;
                        this.alamat_active.province_name = result.nama_provinsi;
                        $('#exampleModal').modal('hide')
                        this.modalTambahAlamat = false;
                    }).catch(err => {
                        $('#exampleModal').modal('hide')
                        this.modalTambahAlamat = false;
                        console.log("ada error");
                    });

                },

                handleBiayaAdmin() {
                    let channel_pembayaran = this.$store.global.channel_pembayaran[this.$store.global.selectPembayaran];
                    this.$store.global.sub_total = this.$store.global.sub_total + channel_pembayaran.fee_customer_flat;
                    this.$store.global.biayaAdmin = channel_pembayaran.fee_customer_flat;

                    if (channel_pembayaran.fee_customer_percent > 0) {
                        let nilai = (channel_pembayaran.fee_customer_percent / 100) * this.sub_total;
                        this.$store.global.biayaAdmin = nilai;
                        this.$store.global.sub_total = this.sub_total + biayaAdmin;

                    }

                },

                handleProsesPayment() {
                    let channel = this.$store.global.channel_pembayaran[this.$store.global.selectPembayaran];
                    this.loadingCO = true;
                    axios.post("{{ route('transaksi-pending') }}", {
                        no_inv: "{{ $transaksi->no_inv }}",
                        sub_total: this.total_harga_barang,
                        metode_pembayaran: this.selectPembayaran.code,
                        biaya_pengiriman: this.selectKurir.cost,
                        biaya_admin: this.$store.global.biayaAdmin,
                        address_id: this.alamat_active.id,
                        metode_pengiriman: this.selectKurir.code
                    }, {
                        csrfToken: "{{ csrf_token() }}",
                    }).then(ress => {
                        // console.log('ress proses', ress)
                        window.location.replace("{{ route('transaksi-unpaid') }}?inv={{ $transaksi->no_inv }}");
                        // this.loadingCO = false;
                        // console.log("DISINI");
                    }).catch(err => {
                        this.loadingCO = false;
                    });

                },

                handleModalPilihPayment() {
                    if (this.modalPilihPembayaran) {
                        this.modalPilihPembayaran = false;
                    } else {
                        this.modalPilihPembayaran = true;
                    }
                },

                handleSelectPembayaran(index) {
                    let channel_pembayaran = null;
                    this.channelPembayaran.forEach(element => {
                        if (element.code === index) {
                            channel_pembayaran = element;

                            this.selectPembayaran = element;
                        }
                    });


                    // let channel_pembayaran = this.$store.global.channel_pembayaran[this.$store.global.selectPembayaran];
                    this.$store.global.sub_total = this.$store.global.sub_total - this.$store.global.biayaAdmin;
                    this.$store.global.sub_total = this.$store.global.sub_total + channel_pembayaran.fee_customer_flat;
                    this.$store.global.biayaAdmin = channel_pembayaran.fee_customer_flat;

                    if (channel_pembayaran.fee_customer_percent > 0) {
                        let nilai = (channel_pembayaran.fee_customer_percent / 100) * this.$store.global.sub_total;
                        nilai = Math.ceil(nilai);

                        this.$store.global.biayaAdmin = nilai;
                        this.$store.global.sub_total = this.$store.global.sub_total + this.$store.global.biayaAdmin;
                        this.$store.global.sub_total = this.$store.global.sub_total;
                        this.$store.global.biayaAdmin = nilai;
                    }
                    // console.log('channel_pembayaran', channel_pembayaran, )

                    this.modalPilihPembayaran = false;
                },

                modalPayment() {
                    Swal.fire({
                        html: `
                        <div class="" x-data="funcData">
                            <div class="flex justify-between items-center">
                                <div class="font-bold mb-7">Pilih metode pembayaran</div>
                            </div>
                            @foreach ($channel_pembayaran as $index => $item)
                                <div class="cursor-pointer" @click="handleSelectPembayaran({{ $index }})">
                                    <div class="flex justify-between">
                                        <div class="">
                                            <div class="flex ">
                                                <img src="{{ $item->icon_url }}" alt="" class="w-16">
                                                <div class="ml-4 font-semibold">
                                                   {{ $item->name }}
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
                            @endforeach
                        </div>
                    `,
                        showConfirmButton: false,
                        width: "800px"
                    })
                },

                init() {

                    this.$store.global.sub_total = {{ $transaksi->sub_total }} + this.selectKurir.cost;
                    this.$store.global.diskon = {{ $transaksi->diskon }};
                    this.$store.global.total_harga_barang = {{ $transaksi->total_harga_barang }};

                    this.$store.global.channel_pembayaran = [
                        @foreach ($channel_pembayaran as $item)
                            {
                                code: "{{ $item->code }}",
                                group: "{{ $item->group }}",
                                name: "{{ $item->name }}",
                                icon_url: "{{ $item->icon_url }}",
                                active: "{{ $item->active }}",
                                fee_customer_flat: {{ $item->fee_customer->flat }},
                                fee_customer_percent: {{ $item->fee_customer->percent }},
                            },
                        @endforeach
                    ];

                    this.handleBiayaAdmin();
                    this.$watch('selectCodeKurir', (value, old) => {

                        this.$store.global.sub_total -= this.selectKurir.cost;
                        if (value === 'jne') {
                            this.selectKurir = this.jne;
                        } else if (value === 'antaraja') {
                            this.selectKurir = this.antaraja;
                        } else {
                            this.selectKurir = this.sicepat;
                        }
                        this.$store.global.sub_total += this.selectKurir.cost;

                        this.modalPilihKurir = false;
                    });
                    this.$watch('select_provinsi_id', (value, oldValue) => {
                        console.log("select prov watch");
                        console.log('value', value)
                    });
                    this.$watch('select_kota_id', (value) => {
                        axios.get(`{{ route('kecamatan') }}?city_id=${value}`).then(ress => {
                            this.kecamatan = ress.data.data;
                        })
                    });
                }


            }
        }
    </script>

    <script>
        function showModal(id) {
            $('#' + id).removeClass('hidden');
        }
    </script>
@endpush
