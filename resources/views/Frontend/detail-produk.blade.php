@extends('layouts.frontend')

@section('title')
    AOY | {{ $produk->nama }}
@endsection

@push('addStyle')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
@endpush

@section('content')
<div class="" x-data="funData">
    <div class="md:hidden fixed bottom-0 bg-white w-full border-t px-6">
        <div class="my-4 flex ">
            <div @click="handleAddCart()" class="border-2 w-1/2 border-primary px-4 py-2 rounded-xl font-medium text-primary cursor-pointer hover:bg-primary hover:text-white  text-center">
                + Keranjang
            </div>
            <div class="border-2 border-primary px-4 py-2 rounded-xl font-medium cursor-pointer bg-primary text-white ml-2 w-1/2  text-center" @click="handleOrderLangsung">
                Order
            </div>
        </div>
    </div>
    <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative  max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 p-2 md:p-6">
                <div class="flex items-center">
                    <img src="{{ url($produk->thumbnail->photo) }}" class="w-16 md:w-28 rounded-lg" alt="">
                    <div class="ml-2">
                        <div class="font-semibold text-sm md:text-base text-gray-800 ">
                            Produk Berhasil Ditambahkan
                        </div>
                        <div class="mt-1 md:text-base text-sm" x-text="'Jumlah '+qty"></div>
                        <a href="{{ route('keranjang') }}" class="bg-primary px-2 py-1 text-white text-xs md:text-base rounded-lg text-center mt-2 inline-block">Lihat Keranjang</a>
                    </div>

                    </div>
            </div>
        </div>
    </div>
    <section class="md:px-32 mt-6 px-6" >
        <div class="grid grid-flow-row grid-cols-12 gap-4 md:gap-10">
            <div class="md:col-span-4 col-span-12 ">
                <img :src="thumbnailActive.url" class="rounded-xl w-auto" alt="">
                <div class="mt-4">
                    <div class="">
                        {{-- <div class="" x-for="image in images" :key="image.id">
                            <img :src="image.url" class="rounded-xl px-3" alt="">
                        </div> --}}
                        <div class="w-full overflow-x-auto flex">
                            @foreach ($images as $item)
                                <div class="px-2">
                                    <img src="{{ url($item->photo) }}" class="rounded cursor-pointer border h-16 w-auto " @click="changeActiveThumbnail('{{ url($item->photo) }}', {{ $item->id }})" :class="{{ $item->id }} === thumbnailActive.id ? 'border-primary' : 'border-white' " alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-5 col-span-12">
                <div class="md:text-2xl text-xl font-semibold">
                    {{ $produk->nama }}
                </div>
                <div class="text-xl font-medium mt-3">Rp.{{ number_format($produk->harga) }}</div>
                @if (Auth::user())
                    <div class="mb-6 mt-4 md:block hidden">
                        <div class="font-medium mb-2">
                            Jumlah
                        </div>
                        <div class="p-2  rounded-full border inline-block">
                            <div class="flex justify-between items-center">
                                <div class="mr-6 cursor-pointer" @click="counterQty('minus')">
                                    <img src="{{ asset('gambar/icon/min-circle.png') }}" alt="" class="opacity-60">
                                </div>
                                <div class="font-bold text-lg">
                                    <span x-text="qty"></span>
                                </div>
                                <div class="ml-6 cursor-pointer" @click="counterQty('plus')">
                                    <img src="{{ asset('gambar/icon/plus-circle.png') }}" alt="" >
                                </div>
                            </div>
                        </div>
                        <div class="my-4 flex">
                            <div @click="handleAddCart()" class="border-2 border-primary px-4 py-2 rounded-xl font-medium text-primary cursor-pointer hover:bg-primary hover:text-white w-full text-center">
                                + Keranjang
                            </div>
                            <div class="border-2 border-primary px-4 py-2 rounded-xl font-medium cursor-pointer bg-primary text-white ml-4 w-full text-center" @click="handleOrderLangsung">
                                Order
                            </div>
                        </div>
                    </div>
                @endif

                <div class="" >
                    <div class="mt-4 border-y relative">
                        <div class="" >
                            <div class="flex my-3 ">
                                <div class="text-center w-32  font-semibold cursor-pointer " :class="isDeskripsi ? 'text-primary' : ''" @click="showData('deskripsi')">
                                    Deskripsi
                                </div>
                                <div class="text-center w-32 cursor-pointer " :class="!isDeskripsi ? 'text-primary' : ''" @click="showData('Khasiat')">Khasiat</div>
                            </div>
                            {{-- hr active deskripsi --}}
                            <div class="w-32 relative " id="r-deskripsi" x-show="isDeskripsi">
                                <hr class="absolute w-full h-1 rounded-full bottom-0 left-0 bg-primary">
                            </div>
                            {{-- hr active Khasiat --}}
                            <div class="w-32 relative ml-32" id="hr-khasiat" x-show="!isDeskripsi">
                                <hr class="absolute w-full h-1 rounded-full bottom-0 left-0 bg-primary">
                            </div>

                        </div>

                    </div>

                    <div class="mt-4 text-gray-600 text-sm prose" x-show="isDeskripsi">
                        {!! $produk->deskripsi !!}
                    </div>
                    <div class="mt-4 text-gray-600 text-sm prose" x-show="!isDeskripsi">
                        {!! $produk->khasiat !!}
                    </div>
                </div>
            </div>


            <div class="md:col-span-3 col-span-12 ">
                <div class="md:sticky top-20">
                    <div class="bg-white p-4 rounded-xl border">
                        <div class="text-sm font-semibold mb-3">
                            Cari Pemakaian
                        </div>
                        <div class="text-sm text-gray-600 prose">
                            {!! $produk->cara_pakai !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

</div>




@endsection

@push('addScript')
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('vendor/axios.min.js') }}"></script>

    <script>

        function funData(params) {
            return{
                init(){
                    this.$watch('select_kota_id', (value) => {
                        axios.get(`{{ route('kecamatan') }}?city_id=${value}`).then(ress => {
                            this.kecamatan = ress.data.data;
                        })
                    });

                    this.$watch('select_provinsi_id', (value, oldValue) => {
                        console.log("select prov watch");
                        console.log('value', value)
                    });


                },

                kecamatan: [],
                select_provinsi_id: '1',
                select_kota_id: '0',
                tambah_address: "",
                select_kecamatan_id: '0',
                modalTambahAlamat: false,

                handleTambahAlamat() {

                    if(this.select_kecamatan_id === '0' || this.select_kota_id === '0' || this.tambah_address === ""){
                        Swal.fire({
                            icon: 'info',
                            title: "Alamat belum lengkap"
                        });

                        return;
                    }

                    axios.post("{{ route('tambah-alamat') }}", {
                        province_id: this.select_provinsi_id,
                        city_id: this.select_kota_id,
                        address: this.tambah_address,
                        subdistrict_id: this.select_kecamatan_id
                    }, {
                        csrfToken: "{{ csrf_token() }}",
                    }).then(ress => {
                        window.location.reload();
                        this.modalTambahAlamat = false;
                    }).catch(err => {

                        this.modalTambahAlamat = false;
                        console.log("ada error");
                        console.log('err', err)
                    });

                },

                modalTambahAlamatBaru() {
                    // this.modalPilihAlamat = false;
                    if (this.modalTambahAlamat) {
                        this.modalTambahAlamat = false;
                    } else {
                        this.modalTambahAlamat = true;
                    }
                },



               isDeskripsi: "OK",
               produk_id: {{ $produk->id }},
               qty: 1,
                thumbnailActive: {
                    url: "{{ url($produk->thumbnail->photo) }}",
                    id: {{ $produk->thumbnail->id }},
                },
               images: [
                    @foreach($images as $item)
                        {
                            id: {{ $item->id }},
                            url: "{{ url($item->photo) }}"
                        },
                    @endforeach
               ],
               handleAddCart(){
                @if(Auth::user())
                    axios.post("{{ route('add-cart') }}", {
                        user_id: {{ Auth::user()->id }},
                        produk_id: {{ $produk->id }},
                        qty: this.qty
                    }).then(res =>{
                        this.$store.global.addCart(this.qty)

                        // set the modal menu element
                        const $targetEl = document.getElementById('modalEl');

                        // options with default values
                        const options = {
                            placement: 'center',
                            backdrop: 'dynamic',
                            backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
                            closable: true,
                            onHide: () => {
                                console.log('modal is hidden');
                            },
                            onShow: () => {
                                console.log('modal is shown');
                            },
                            onToggle: () => {
                                console.log('modal has been toggled');
                            }
                        };

                        const modal = new Modal($targetEl, options);
                        modal.toggle();

                    }).catch(err =>{
                        console.log('err', err)
                    })
                @else
                    window.location.href = "{{ route('login') }}";
                @endif

                    return 1;
               },
                showData(param){
                    if(param === 'deskripsi'){
                        this.isDeskripsi = 1;
                    }else{
                        this.isDeskripsi = 0;
                    }

                },

                handleOrderLangsung(){

                    @if(!$alamat)
                        this.modalTambahAlamat = true;

                        return;
                    @endif

                    @if(Auth::user())
                        axios.post("{{ route('orderLangsung') }}", {
                            produk_id: this.produk_id,
                            qty: this.qty
                        }, {
                            csrfToken: "{{ csrf_token() }}",
                        }).then(ress => {
                            console.log('ress.data.inv.no_inv', ress.data)
                            window.location.replace("{{ route('proses-transaksi') }}?inv="+ress.data.inv.no_inv);
                        }).catch(err =>{
                            console.log('err', err)
                        });
                    @else
                        window.location.href = "{{ route('login') }}";
                    @endif
                },


                counterQty(param)
                {
                    if(param === 'plus'){
                        this.qty += 1;
                    }else{
                        if(this.qty <= 1){
                            this.qty = 1;
                        }else{
                            this.qty -= 1;
                        }
                    }
                },
                changeActiveThumbnail(url,id){
                    this.thumbnailActive.url = url;
                    this.thumbnailActive.id = id;
                },
                showModal(param){
                    // set the modal menu element
                    const $targetEl = document.getElementById('modalEl');

                    // options with default values
                    const options = {
                        placement: 'center',
                        backdrop: 'dynamic',
                        backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
                        closable: true,
                        onHide: () => {
                            console.log('modal is hidden');
                        },
                        onShow: () => {
                            console.log('modal is shown');
                        },
                        onToggle: () => {
                            console.log('modal has been toggled');
                        }
                    };

                    const modal = new Modal($targetEl, options);
                    if(param){
                        modal.hide();
                        // modal.toggle();
                    }else{
                        modal.toggle();
                    }
                }

            }
        }
    </script>
@endpush
