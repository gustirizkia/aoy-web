@extends('layouts.frontend')

@section('title')
    Keranjang Produk Saya
@endsection

@push('addStyle')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
@endpush

@section('content')
<div class="" x-data="funData">
    <section class="md:px-32 px-6 mt-6 md:mt-12" >
        <div class="md:px-20">
            <div class="grid grid-flow-row grid-cols-12 gap-6">
                <div class="md:col-span-8 col-span-12">
                    @foreach ($produks as $key => $item)
                        @foreach ($item as $cart)
                            <div class="justify-between flex border p-2 md:p-4 rounded-lg w-full relative mb-6">
                                <div class="flex ">

                                    <img src="{{ url($cart->produk->thumbnail->photo) }}" class="rounded-lg w-28" alt="">
                                    <div class="my-auto ml-4">
                                        <div class="text-xs md:text-sm ">
                                        {{ $cart->produk->nama }}
                                        </div>
                                        <div class="text-xs md:text-sm font-semibold">
                                            Rp{{ number_format($cart->produk->harga) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="z-20  items-center justify-between">
                                    <div class="absolute top-0 right-0 p-2 md:p-4">
                                        <label>
                                        <input type="checkbox"
                                            value="{{ $cart->id }}" x-model="pilihan"
                                            class="form-checkbox rounded text-primary border-2 border-gray-500 md:w-5 md:h-5 w-4 h-4"
                                             >
                                        </label>
                                    </div>
                                    <div class=" absolute bottom-0 right-0 z-10 p-4 hidden md:block">
                                        <div class="flex relative justify-between items-center p-1 border rounded-full w-full">
                                            <img src="{{ asset('gambar/icon/min-circle.png') }}" alt="" class="opacity-60 w-4 z-10 mr-6 cursor-pointer">

                                            <div class="font-bold text-sm">
                                                 {{ $cart->qty }}
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
                                            {{ $cart->qty }}
                                        </div>
                                        <div class="">
                                            <img src="{{ asset('gambar/icon/plus-circle.png') }}" alt="" class="w-4 z-10 ml-3 relative cursor-pointer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
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
                            <div class="" x-text="totalHarga"></div>
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
            <div class="">Rp<span x-text="totalHarga"></span></div>
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
        <a href="{{ route('proses-transaksi') }}" class="block w-full mt-6 bg-primary py-2 rounded-xl text-center text-white text-sm">
            Beli
        </a>
    </div>
</div>
@endsection

@push('addScript')
    <script>
        function funData(){
            return{
                totalHarga: 0,
                pilihan:[],
                produks:[
                    @foreach ($produks as $key => $item)
                        @foreach ($item as $cart)
                            {
                                id: {{ $cart->id }},
                                photo: "{{ url($cart->produk->thumbnail->photo) }}",
                                nama: "{{ $cart->nama }}",
                                harga: {{ $cart->produk->harga }},
                                qty: {{ $cart->qty }},
                            },
                        @endforeach
                    @endforeach
                ],

                init(){
                    this.$watch('pilihan', (value, oldValue) => {
                        console.log('value', value.length);
                        for (let index = 0; index < value.length; index++) {
                            const element = parseInt(value[index]);

                            // this.totalHarga += element;
                            this.produks.forEach(item => {
                                if(item.id === element){
                                    this.totalHarga += item.harga;
                                }
                            });
                        }
                    })
                },

                handleChekced(){

                },
            }
        }
    </script>
@endpush
