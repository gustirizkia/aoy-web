<div class="bg-white md:p-8 p-3 rounded-lg shadow h-full flex flex-col justify-start" x-data="cardProduk" >

    <div class="">
            <img src="{{ $image_url }}" alt="" class="rounded-lg w-full ">
            <div class="">
                <div class="mt-4 mb-2 font-semibold md:text-xl text-xs">
                    {{ $nama }}
                </div>
                <div class="flex items-center align-middle">

                    <div class="text-gray-500 text-xs md:text-base my-auto">Rp.{{ $harga }}</div>
                </div>
            </div>
    </div>
    <div class="mt-4 flex justify-between items-end h-full">
        <a href="{{ $url_detail }}" class="md:rounded-full rounded-lg px-3 py-1 md:px-10 md:py-2 font-medium border-2 border-primary text-sm text-primary  hover:bg-primary hover:text-white">Detail</a>
        <div @click="handleAddCart(`{{ $idProduk }}`, `{{ $param_nama }}`, `{{ $image_url }}`)" class="cursor-pointer ">
            <img src="{{ asset('gambar/icon/cart-produk.png') }}" class="md:w-10 w-8" alt="Skincare image">
        </div>
    </div>
</div>

@push('addScript')

    <script>
        function cardProduk(){
            return{
                handleAddCart(produk_id, nama, image){
                    @if(Auth::user())
                        axios.post("{{ route('add-cart') }}", {
                            user_id: {{ Auth::user()->id }},
                            produk_id: produk_id,
                            qty: 1
                        }).then(res =>{
                            this.$store.global.addCart(1);
                            Swal.fire({
                                html: `
                                    <div class="">
                                        <div class="font-bold text-xl text-center text-gray-800">
                                        Produk Berhasil Ditambahkan
                                        </div>
                                        <div class="md:flex items-center justify-between text-left mt-3">
                                            <div class="flex items-center text-left">
                                                <img src="${image}" class="rounded-xl px-3 w-28" alt="">
                                                <div class=" text-sm text-gray-700">
                                                    <div>${nama}</div>
                                                    <div class="">
                                                        Jumlah : 1
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
                        }).catch(err =>{
                            console.log('err', err)
                        })
                    @else
                        window.location.href = "{{ route('login') }}";
                    @endif

                    return;
                },
            }
        }
    </script>

    <script>
        function addCart(idProduk){
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
@endpush
