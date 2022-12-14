<div class="justify-between flex border p-2 md:p-4 rounded-lg w-full relative mb-6" x-data="funKeranjang">
        <div class="flex ">

            <img src="{{ url($image) }}" class="rounded-lg w-28" alt="">
            <div class="my-auto ml-4">
                <div class="text-xs md:text-sm ">
                {{ $nama }}
                </div>
                <div class="text-xs md:text-sm font-semibold">
                    Rp{{ $harga }}
                </div>
            </div>
        </div>

        <div class="z-20  items-center justify-between">
            <div class="absolute top-0 right-0 p-2 md:p-4">
                <label>
                <input type="checkbox"
                    value="{{ $cart_id }}" x-model="pilihan"
                    class="form-checkbox rounded text-primary border-2 border-gray-500 md:w-5 md:h-5 w-4 h-4"
                        >
                </label>
            </div>
            <div class=" absolute bottom-0 right-0 z-10 p-4 hidden md:block">
                <div class="flex relative justify-between items-center p-1 border rounded-full w-full">
                    <img src="{{ asset('gambar/icon/min-circle.png') }}" alt="" class="opacity-60 w-4 z-10 mr-6 cursor-pointer">

                    <div class="font-bold text-sm">
                        <span x-text="qty"></span>
                    </div>
                    <div class="">
                        <img src="{{ asset('gambar/icon/plus-circle.png') }}" alt="" class="w-4 z-10 ml-6 relative cursor-pointer" @click="handleAddCart({{ $cart->produk_id }})">
                    </div>
                </div>

            </div>
        </div>
        <div class="absolute bottom-0 right-0 p-2 md:hidden">
            <div class="flex relative justify-between items-center p-1 border rounded-full w-full">
                <img src="{{ asset('gambar/icon/min-circle.png') }}" alt="" class="opacity-60 w-4 z-10 mr-3 cursor-pointer">

                <div class="font-bold text-sm">
                    {{ $qty }}
                </div>
                <div class="">
                    <img src="{{ asset('gambar/icon/plus-circle.png') }}" alt="" class="w-4 z-10 ml-3 relative cursor-pointer">
                </div>
            </div>
        </div>
    </div>

    @push('addScript')
        <script>
            function funKeranjang(){
                return{
                    qty: {{ $qty }},
                    harga: {{ $harga_original }},
                    handleAddCart(produk_id){
                        this.$store.global.addCart(1)
                                this.qty += 1;
                                return;
                        @if(Auth::user())
                            axios.post("{{ route('add-cart') }}", {
                                user_id: {{ Auth::user()->id }},
                                produk_id: produk_id,
                                qty: 1
                            }).then(res =>{

                                this.$store.global.addCart(1)
                                this.qty += 1;

                            }).catch(err =>{
                                console.log('err', err)
                            })
                        @endif

                            return 1;
                    },

                    init(){
                        this.$watch(`pilihan{{ $cart_id }}`, (value, oldValue) => {
                            console.log('value', value)
                            console.log('oldValue', oldValue)
                            this.$store.global.total_harga += this.harga;
                        })
                    },

                }
            }
        </script>
    @endpush
