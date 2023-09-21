@extends('layouts.frontend')

@section('title')
    {{ $produk->nama }} | AY'S ON YOU
@endsection

@push('addStyle')

<!-- Primary Meta Tags -->

<meta name="title" content="{{ $produk->nama }} | AY'S ON YOU
" />
<meta name="description" content="AY'S ON YOU Penuhi kebutuhan kulitmu agar kecantikanmu terpancar." />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ route('detail-produk', $produk->slug) }}" />
<meta property="og:title" content="{{ $produk->nama }} | AY'S ON YOU
" />
<meta property="og:description" content="AY'S ON YOU Penuhi kebutuhan kulitmu agar kecantikanmu terpancar." />
<meta property="og:image" content="{{ url($produk->thumbnail->photo) }}" />

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="{{ route('detail-produk', $produk->slug) }}" />
<meta property="twitter:title" content="{{ $produk->nama }} | AY'S ON YOU
" />
<meta property="twitter:description" content="AY'S ON YOU Penuhi kebutuhan kulitmu agar kecantikanmu terpancar." />
<meta property="twitter:image" content="{{ url($produk->thumbnail->photo) }}" />

<!-- Meta Tags Generated with https://metatags.io -->

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

    {{-- loading --}}
    <template x-if="isLoading">
        <div class="fixed bg-gray-500 h-screen w-full top-0 z-50 bg-opacity-30 flex flex-col items-center justify-center">
            <div class="text-center">
                <div role="status">
                    <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-purple-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 font-medium">Loading</div>
        </div>
    </template>
    {{-- loading end --}}

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
                isLoading: false,

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
                    this.isLoading = true;
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
                        this.isLoading = false;

                    }).catch(err =>{
                        console.log('err', err)
                        this.isLoading = false;
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
                        this.isLoading = true;
                        console.log("Hallo");
                        axios.post("{{ route('orderLangsung') }}", {
                            produk_id: this.produk_id,
                            qty: this.qty
                        }, {
                            csrfToken: "{{ csrf_token() }}",
                        }).then(ress => {
                            // this.isLoading = false;
                            window.location.replace("{{ route('proses-transaksi') }}?inv="+ress.data.inv.no_inv);
                        }).catch(err =>{
                            console.log('err', err)
                            this.isLoading = false;
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
