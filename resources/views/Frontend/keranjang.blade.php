@extends('layouts.frontend')

@section('title')
    Keranjang Produk Saya
@endsection

@push('addStyle')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
@endpush

@section('content')

<div class="" x-data="funData">
    <form  @submit.prevent="handleSubmit()" method="POST">
        @csrf
        <section class="md:px-32 px-6 mt-6 md:mt-12" >
            <div class="md:px-20">
                <div class="grid grid-flow-row grid-cols-12 gap-6">
                    <div class="md:col-span-8 col-span-12">

                        <template x-for="produk in produks" :key="produk.id">
                            <div class="justify-between flex border p-2 md:p-4 rounded-lg w-full relative mb-6">
                                    <div class="flex ">

                                        <img :src="produk.photo" class="rounded-lg w-28" alt="">
                                        <div class="my-auto ml-4">
                                            <div class="text-xs md:text-sm ">
                                            <span x-text="produk.nama"></span>
                                            </div>
                                            <div class="text-xs md:text-sm font-semibold">
                                                Rp
                                                <span x-text="numberWithCommas(produk.harga)"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="z-20  items-center justify-between">
                                        <div class="absolute top-0 right-0 p-2 md:p-4">
                                            <label>
                                            <input type="checkbox"
                                                :value="produk.id" x-model="pilihan"
                                                class="form-checkbox rounded text-primary border-2 border-gray-500 md:w-5 md:h-5 w-4 h-4"
                                                 >
                                            </label>
                                        </div>
                                        <div class=" absolute bottom-0 right-0 z-10 p-4 hidden md:block">
                                            <div class="flex relative justify-between items-center p-1 border rounded-full w-full">
                                                <img src="{{ asset('gambar/icon/min-circle.png') }}" alt="" class="opacity-60 w-4 z-10 mr-6 cursor-pointer" @click="handleAddCart(produk.produk_id, 'minus')">

                                                <div class="font-bold text-sm">
                                                     <span x-text="produk.qty"></span>
                                                </div>
                                                <div class="">
                                                    <img src="{{ asset('gambar/icon/plus-circle.png') }}" alt="" class="w-4 z-10 ml-6 relative cursor-pointer" @click="handleAddCart(produk.produk_id)">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="absolute bottom-0 right-0 p-2 md:hidden">
                                        <div class="flex relative justify-between items-center p-1 border rounded-full w-full">
                                            <img src="{{ asset('gambar/icon/min-circle.png') }}" alt="" class="opacity-60 w-4 z-10 mr-3 cursor-pointer" @click="handleAddCart(produk.produk_id, 'minus')">

                                            <div class="font-bold text-sm">
                                                <span x-text="produk.qty"></span>
                                            </div>
                                            <div class="">
                                                <img src="{{ asset('gambar/icon/plus-circle.png') }}" alt="" class="w-4 z-10 ml-3 relative cursor-pointer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </template>

                    </div>
                    @if (count($produks) > 0)
                        <div class="col-span-4 md:block hidden">
                            <div class="border rounded-xl p-4 md:sticky md:top-20 ">
                                <div class="font-bold text-gray-800">
                                    Ringkasan Belanja
                                </div>
                                <div class="text-gray-600 mt-3 flex justify-between">
                                    <div class="">
                                        Total Harga
                                    </div>
                                    <div class="" x-text="'Rp'+numberWithCommas(totalHarga)"></div>
                                </div>
                                <div class="text-gray-600 mt-3 flex justify-between">
                                    <div class="">
                                        Diskon Barang
                                    </div>
                                    <div class="" x-text="'Rp'+numberWithCommas(potongan.diskon)">Rp400,0000</div>
                                </div>
                                <hr class="my-4">
                                <div class="font-bold text-gray-800 flex justify-between">
                                    <div class="">Subtotal</div>
                                    <div x-text="'Rp'+numberWithCommas(potongan.total_potongan)" class="">Rp400,000</div>
                                </div>
                                <div class="">
                                    <button type="submit" class="block w-full" :disabled="pilihan.length <= 0">
                                        <div class="mt-8 bg-primary py-2 rounded-xl text-center text-white">
                                            Beli
                                        </div>
                                    </button>
                                    {{-- <a href="{{ route('proses-transaksi') }}">
                                        <div class="mt-8 bg-primary py-2 rounded-xl text-center text-white">
                                            Beli
                                        </div>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </section>
        @if (count($produks) > 0)
            <div class="border w-full p-4 fixed bg-white bottom-0 z-40 text-xs md:hidden">
                <div class="text-gray-600  flex justify-between">
                    <div class="">
                        Total Harga
                    </div>
                    <div class=""><span x-text="'Rp'+numberWithCommas(totalHarga)"></span></div>
                </div>
                <div class="text-gray-600 mt-3 flex justify-between">
                    <div class="">
                        Diskon Barang
                    </div>
                    <div class="" x-text="'Rp'+numberWithCommas(potongan.diskon)">Rp400,0000</div>
                </div>
                <hr class="my-4">
                <div class="font-bold text-gray-800 flex justify-between text-sm">
                    <div class="">Subtotal</div>
                    <div x-text="'Rp'+numberWithCommas(potongan.total_potongan)" class="">Rp400,000</div>
                </div>
                <a href="#" class="block w-full mt-6 bg-primary py-2 rounded-xl text-center text-white text-sm">
                    Beli
                </a>
            </div>
        @else
        <div class=" text-center mb-3">Keranjang kosong</div>
        <div class="w-full text-center">
            <a href="/produk" class="text-center bg-primary text-white px-4 py-2 rounded-lg mt-3">Cari produk</a>
        </div>
        @endif
    </form>
</div>
@endsection

@push('addScript')
    <script>
        function funData(){
            return{
                potongan: {
                    harga: {{ $level->potongan_harga }},
                    tipe_potongan: "{{ $level->tipe_potongan }}",
                    total_potongan: 0,
                    diskon: 0,
                },
                totalHarga: 0,
                pilihan:[],
                produks:[
                    @foreach ($produks as $key => $item)
                        @foreach ($item as $cart)
                            {
                                id: {{ $cart->id }},
                                photo: "{{ url($cart->produk->thumbnail->photo) }}",
                                nama: "{{ $cart->produk->nama }}",
                                harga: {{ $cart->produk->harga }},
                                qty: {{ $cart->qty }},
                                produk_id: {{ $cart->produk_id }}
                            },
                        @endforeach
                    @endforeach
                ],

                init(){
                    this.$watch('pilihan', (value, oldValue) => {
                        this.totalHarga= 0;
                        this.potongan.diskon = 0;
                        this.potongan.total_potongan = 0;
                        for (let index = 0; index < value.length; index++) {
                            const element = parseInt(value[index]);

                            this.produks.forEach(item => {
                                if(item.id === element){
                                    this.totalHarga += item.harga*item.qty;

                                    if(this.potongan.tipe_potongan === 'fix'){
                                        // potong tiap satuan produk
                                        let potonganProduk = this.potongan.harga*item.qty;

                                        this.potongan.diskon  += potonganProduk;
                                        this.potongan.total_potongan = this.totalHarga - this.potongan.diskon;
                                    }else{
                                        let nilai = (this.potongan.harga/100)*item.harga;
                                        let potonganProduk = nilai*item.qty;

                                        this.potongan.diskon += potonganProduk;
                                        this.potongan.total_potongan += this.totalHarga - potonganProduk;
                                    }
                                }
                            });
                        }
                    });
                },

                numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },

                handleSubmit(){
                    axios.post("{{ route('createInv') }}", {
                        carts: this.pilihan,
                    }, {
                        csrfToken: "{{ csrf_token() }}",
                    }).then(ress =>{
                        console.log(ress);
                        console.log('ress.data.no_inv', ress.data.inv.no_inv)
                        // return;
                        window.location.replace("{{ route('proses-transaksi') }}?inv="+ress.data.inv.no_inv);
                    });
                },

                handleAddCart(produk_id, minus = null){

                    @if(Auth::user())
                        formData = {
                            user_id: {{ Auth::user()->id }},
                            produk_id: produk_id,
                            qty: 1
                        }
                        if(minus){
                            formData.status = 'minus';
                        }

                        axios.post("{{ route('add-cart') }}", formData).then(res =>{

                                if(minus){
                                    this.$store.global.addCart(1, 'minus')
                                }else{
                                    this.$store.global.addCart(1)
                                }

                                this.produks.forEach((element, index) => {
                                    if(produk_id === element.produk_id)
                                    {
                                        if(minus){
                                            cekQty = this.produks[index].qty - 1;
                                            if(cekQty < 1){
                                                this.produks.splice(index,1);
                                                this.produks[index].qty -= 1;
                                            }else{
                                                this.produks[index].qty -= 1;
                                            }
                                        }else{
                                            this.produks[index].qty += 1;
                                        }
                                    }
                            });

                        }).catch(err =>{
                            console.log('err', err)
                        })
                    @endif

                        return 1;
                },
            }
        }
    </script>
@endpush
