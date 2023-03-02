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
            <div class="md:col-span-4 col-span-12 md:block hidden">
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
            <div class="col-span-12 md:hidden">
                <div id="indicators-carousel" class="relative h-80" data-carousel="static">
                    <!-- Carousel wrapper -->
                    <div class="relative h-80 overflow-hidden rounded-lg md:h-96">
                        <!-- Item -->
                        @foreach ($images as $index => $item)
                            <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ url($item->photo) }}" class="absolute block w-full h-80 object-cover object-center -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                            </div>
                        @endforeach
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                        @foreach($images as $key => $value)
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide {{ $key+1 }}" data-carousel-slide-to="{{ $key }}"></button>
                        @endforeach
                    </div>
                    <!-- Slider controls -->
                    <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
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
