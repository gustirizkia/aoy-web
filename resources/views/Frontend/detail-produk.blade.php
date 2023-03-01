@extends('layouts.frontend')

@section('title')
    AOY | {{ $produk->nama }}
@endsection

@push('addStyle')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
@endpush

@section('content')

<section class="md:px-32 mt-8 px-6" x-data="funData">
    <div class="grid grid-flow-row grid-cols-12 gap-6">
        <div class="md:col-span-5 col-span-12">
            <img :src="thumbnailActive.url" class="rounded-xl" alt="">
            <div class="mt-4">
                <div class="your-class">
                    {{-- <div class="" x-for="image in images" :key="image.id">
                        <img :src="image.url" class="rounded-xl px-3" alt="">
                    </div> --}}
                    @foreach ($images as $item)
                        <div class="px-2">
                            <img src="{{ url($item->photo) }}" class="rounded cursor-pointer border  " @click="changeActiveThumbnail('{{ url($item->photo) }}', {{ $item->id }})" :class="{{ $item->id }} === thumbnailActive.id ? 'border-primary' : 'border-white' " alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="md:col-span-4 col-span-12">
            <div class="md:text-2xl text-xl font-semibold">
                {{ $produk->nama }}
            </div>
            @if (Auth::user())
                <div class="my-6 md:block hidden">
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




@endsection

@push('addScript')
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('vendor/axios.min.js') }}"></script>

    <script>
         $('.your-class').slick({
                slidesToShow: 3,
                arrows: false,
                centerMode: true,
                // dots: true

                responsive: [
                    {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                    },
                    {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
        });
    </script>

    <script>
        function addAcrt(){
            Swal.fire({
                html: `
                    <div class="">
                        <div class="font-bold text-xl text-center text-gray-800">
                        Produk Berhasil Ditambahkan
                        </div>
                        <div class="md:flex items-center justify-between text-left mt-3">
                            <div class="flex items-center text-left">
                                <img src="https://img.freepik.com/premium-psd/cosmetic-tube-packaging-mockups_144389-269.jpg?w=900" class="rounded-xl px-3 w-28" alt="">
                                <div class=" text-sm text-gray-700">
                                    <div>White CellDNA Night Cream</div>
                                    <div class="">
                                        Jumlah : 3
                                    </div>
                                </div>
                            </div>
                            <div class="bg-primary px-6 py-2 text-white text-sm rounded-lg inline-block mt-6">
                                <a href="{{ route('keranjang') }}" class="border-0">
                                    Lihat keranjang
                                </a>
                            </div>
                        </div>



                    </div>
                `,
                showConfirmButton : false,
                width: "800px"
            })
        }
    </script>

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
                        console.log('res', res)
                        this.$store.global.addCart(this.qty)
                    }).catch(err =>{
                        console.log('err', err)
                    })
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
                }

            }
        }
    </script>
@endpush
