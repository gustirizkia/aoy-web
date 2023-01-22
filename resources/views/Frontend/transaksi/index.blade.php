@extends('layouts.frontend')

@section('title')
    Proses Order
@endsection

@section('addStyle')
    <link href="{{ asset('style/main.css') }}" rel="stylesheet" />
@endsection

@section('content')
<section x-data="funcData">
    <div class="md:px-64 mt-2 md:mt-8">
        <div class="grid grid-flow-row grid-cols-12 gap-6">
            <div class="col-span-12 md:col-span-8">
                <div class="bg-white rounded-xl py-4">
                    <div class="flex justify-between px-6 items-center">
                        <div class="text-lg ">Alamat Pengiriman</div>
                        @if ($address_active)
                            <div class="bg-[#F258FF] px-3 py-1 text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer" data-bs-toggle="modal" data-bs-target="#pilih_alamat">Pilih alamat lain</div>

                        @else
                            <div class="bg-[#F258FF] px-3 py-1 text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah alamat</div>

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
                                <img src="{{ url($item->produk->thumbnail->photo) }}" class="rounded-lg w-28" alt="">
                                <div class="my-auto ml-4">
                                    <div class="text-xs md:text-sm ">
                                        {{ $item->produk->nama }}
                                    </div>
                                    <div class="text-xs md:text-sm font-semibold">
                                        {{ number_format($item->produk->harga) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-2">
                    <div class="bg-white rounded-xl p-4 md:flex justify-between">
                        <div class="flex items-center">
                            <img src="{{ asset('gambar/icon/delivery.png') }}" class="w-12" alt="">
                            <div class="ml-6">
                                <div class="text-base font-medium">
                                    Metode Pengiriman
                                </div>
                                <div class="text-sm font-medium mt-1">
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
                            <img :src="channelPembayaran[$store.global.selectPembayaran].icon_url" class="w-12" alt="">
                            <div class="ml-6">
                                <div class="text-base font-medium">
                                    Metode Pembayaran
                                </div>
                                <div class="text-sm font-medium mt-1">
                                    <span x-text="channelPembayaran[$store.global.selectPembayaran].name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-end mt-3 md:mt-0 justify-end">
                            <div class="bg-[#F258FF] px-3 py-1 text-xs md:text-sm  bg-opacity-25 text-[#B916B9] font-semibold rounded cursor-pointer inline" @click="modalPayment">Pilih pembayaran</div>
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
                        <div class="" x-text="'Rp'+$store.global.numberWithCommas($store.global.total_harga_barang)">Rp800,0000</div>
                    </div>
                    <div class="text-gray-600 mt-3 flex justify-between">
                        <div class="">
                            Diskon Barang
                        </div>
                        <div class="" x-text="'Rp'+$store.global.numberWithCommas($store.global.diskon)">Rp400,0000</div>
                    </div>
                    <div class="text-gray-600 mt-3 flex justify-between">
                        <div class="">
                            Biaya Admin
                        </div>
                        <div class="" x-text="'Rp'+$store.global.numberWithCommas($store.global.biayaAdmin)">Rp400,0000</div>
                    </div>
                    <hr class="my-4">
                    <div class="font-bold text-gray-800 flex justify-between text-sm">
                        <div class="">Subtotal</div>
                        <div class="" x-text="'Rp'+$store.global.numberWithCommas($store.global.sub_total)">Rp400,000</div>
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

    {{-- modal tambah alamat --}}
    {{-- <div class="hidden" id="modal_pembayaran" >
        <div class="">
            <div class="flex justify-between items-center">
                <div class="font-bold mb-7">Pilih metode pembayaran</div>
            </div>
            <div class="absolute top-0 right-0 p-2 cursor-pointer" onclick="hiddenModal('modal_alamat')">
                <img src="{{ asset('gambar/icon/close.png') }}" alt="" class="w-8 ">
            </div>
            <template class="" x-for="(item, index) in channelPembayaran" :key="index">
                <div class="flex justify-between">
                    <div class="">
                        <div class="flex ">
                            <img :src="item.icon_url" alt="" class="w-16">
                            <div class="ml-4 font-semibold">
                                <span x-text="item.group"></span> - <span x-text="item.name"></span>
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
            </template>

        </div>
        <div class=" h-screen w-full bg-gray-800 bg-opacity-20 top-0 fixed flex items-center justify-center"  onclick="hiddenModal('modal_alamat')">
        </div>
    </div> --}}

    {{-- component Modal Alamat --}}

<!-- Modal tambah alamat -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
        <div
        class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div
            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Tambah Alamat</h5>
            <button type="button"
            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
            data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body relative p-4">
            <label for="">Provinsi</label>
            <div class="mb-4 group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full items-center px-3">
                    <select name="" id="" class="w-full text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-400 w-full" x-model="select_provinsi_id">
                        @foreach ($list_provinsi as $item)
                            <option value="{{ $item->province_id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
            </div>
            <label for="" class="mt-4">Kota</label>
            <div class="mb-4 group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full items-center px-3">
                    <select name="" id="" class=" text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-400 w-full" x-model="select_kota_id">
                        <option value="0" disabled>Pilih kota</option>
                        @foreach ($list_kota as $item)
                            <option value="{{ $item->city_id }}" x-show="'{{ $item->province_id }}' === select_provinsi_id">{{ $item->name }}</option>
                        @endforeach
                    </select>
            </div>
            <label for="" class="mt-4">Kecamatan</label>
            <div class="mb-4 group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full items-center px-3">
                    <select name="" id="" class=" text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-400 w-full" x-model="select_kecamatan_id">
                        <option value="0" disabled>Pilih kecamatan</option>
                        <template x-for="(item, index) in kecamatan" :key="index">
                            <option :value="item.subdistrict_id">
                                <span x-text="item.subdistrict_name"></span>
                            </option>
                        </template>
                    </select>
            </div>
            <label for="" class="mt-4">Alamat lengkap</label>
            <div class=" group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full items-center px-3">
                    <input type="text" x-model="tambah_address" class="w-full text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-900" placeholder="Alamat lengkap">
            </div>
        </div>
        <div
            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">

        <button type="button" class="px-6
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
</div>
{{-- endmodal tambah alamat --}}

<!-- Modal pilih alamat -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="pilih_alamat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
        <div
        class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div
            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Tambah Alamat</h5>
            <button type="button"
            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
            data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body relative p-4">

        </div>
        <div
            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">

        <button type="button" class="px-6
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
</div>
{{-- endmodal pilih alamat --}}

</section>


@endsection

@push('addScript')

<script src="/vendor/jquery/jquery.slim.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    function funcData(){
        return{
            channelPembayaran: [
                                @foreach($channel_pembayaran as $item)
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
            selectPembayaran: this.$store.global.selectPembayaran,
            sub_total: this.$store.global.sub_total,
            diskon: this.$store.global.diskon,
            total_harga_barang: this.$store.global.total_harga_barang,
            biayaAdmin: this.$store.global.biayaAdmin,
            list_kota: [
                @foreach($list_kota as $item)
                    {
                        id: {{ $item->id }},
                        name: "{{ $item->name }}"
                    },
                @endforeach
            ],
            kecamatan: [],
            select_provinsi_id:'1',
            select_kota_id:'0',
            tambah_address: "",
            select_kecamatan_id: '0',

            alamat_active:{
                address: "{{ $address_active->address  }}",
                city_name: "{{ $address_active->nama_kota }}",
                province_name: "{{ $address_active->nama_provinsi }}",
            },

            handleChannelPembayaran(){

            },

            cityById(id){
                @foreach($list_kota as $item)
                   if(id === {{ $item->city_id }}){
                    this.alamat_active.city_name = "{{ $item->name }}";
                   }
                @endforeach
            },

            handleCloseModal(){
                $('#exampleModal').modal('hide')
            },

            handleTambahAlamat(){
                axios.post("{{ route('tambah-alamat') }}", {
                        province_id: this.select_provinsi_id,
                        city_id: this.select_kota_id,
                        address: this.tambah_address,
                        subdistrict_id: this.select_kecamatan_id
                    }, {
                        csrfToken: "{{ csrf_token() }}",
                    }).then(ress =>{
                        let result= ress.data;
                        this.alamat_active.address = result.address;
                        this.alamat_active.city_name = result.nama_kota;
                        this.alamat_active.province_name = result.nama_provinsi;
                        $('#exampleModal').modal('hide')
                    }).catch(err =>{
                        $('#exampleModal').modal('hide')
                        console.log("ada error");
                    });

            },

            handleBiayaAdmin(){
               let channel_pembayaran = this.$store.global.channel_pembayaran[this.$store.global.selectPembayaran];
                this.$store.global.sub_total = this.$store.global.sub_total + channel_pembayaran.fee_customer_flat;
                this.$store.global.biayaAdmin = channel_pembayaran.fee_customer_flat;

                if(channel_pembayaran.fee_customer_percent > 0){
                    let nilai= (channel_pembayaran.fee_customer_percent/100)*this.sub_total;
                    this.$store.global.biayaAdmin = nilai;
                    this.$store.global.sub_total = this.sub_total + biayaAdmin;

                }

            },

            handleProsesPayment(){
                let channel = this.$store.global.channel_pembayaran[this.$store.global.selectPembayaran];

                axios.post("{{ route('transaksi-pending') }}", {
                        no_inv: "{{ $transaksi->no_inv }}",
                        sub_total: this.$store.global.sub_total,
                        metode_pembayaran: channel.code,
                    }, {
                        csrfToken: "{{ csrf_token() }}",
                    }).then(ress =>{
                        console.log('ress proses', ress)
                    }).catch(err =>{
                    });

            },

            handleSelectPembayaran(index){
                this.selectPembayaran = index;
                this.$store.global.selectPembayaran = index;


                let channel_pembayaran = this.$store.global.channel_pembayaran[this.$store.global.selectPembayaran];
                this.$store.global.sub_total = this.$store.global.sub_total + channel_pembayaran.fee_customer_flat;
                this.$store.global.biayaAdmin = channel_pembayaran.fee_customer_flat;

                if(channel_pembayaran.fee_customer_percent > 0){
                    let nilai= (channel_pembayaran.fee_customer_percent/100)*this.sub_total;
                    this.$store.global.biayaAdmin = nilai;
                    this.$store.global.sub_total = this.$store.global.sub_total + this.$store.global.biayaAdmin;
                    this.$store.global.sub_total = this.$store.global.sub_total.toFixed(2);
                    this.$store.global.biayaAdmin = nilai.toFixed(2);


                }


                swal.close();
            },

            modalPayment(){
                Swal.fire({
                    html: `
                        <div class="" x-data="funcData">
                            <div class="flex justify-between items-center">
                                <div class="font-bold mb-7">Pilih metode pembayaran</div>
                            </div>
                            @foreach($channel_pembayaran as $index => $item)
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
                    showConfirmButton : false,
                    width: "800px"
                })
            },

            init(){

                console.log('this.select_provinsi_id', this.select_provinsi_id)

                this.$store.global.sub_total= {{ $transaksi->sub_total }};
                this.$store.global.diskon= {{ $transaksi->diskon }};
                this.$store.global.total_harga_barang= {{ $transaksi->total_harga_barang }};

                    this.$store.global.channel_pembayaran = [
                        @foreach($channel_pembayaran as $item)
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

                    this.$watch('select_provinsi_id', (value, oldValue) => {
                        console.log("select prov watch");
                        console.log('value', value)
                    });
                    this.$watch('select_kota_id', (value) => {
                        axios.get(`{{ route('kecamatan') }}?city_id=${value}`).then(ress=>{
                            this.kecamatan = ress.data.data;
                        })
                    });
            }


        }
    }
</script>

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
