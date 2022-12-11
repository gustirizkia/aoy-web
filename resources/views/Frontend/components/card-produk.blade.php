<div class="bg-white p-8 rounded-lg shadow h-full flex flex-col justify-start">

    <div class="">
            <img src="{{ $image_url }}" alt="" class="rounded-lg w-full ">
            <div class="">
                <div class="mt-4 mb-2 font-semibold text-xl">
                    {{ $nama }}
                </div>
                <div class="flex items-center align-middle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-yellow-400 mr-2">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-yellow-400 mr-2">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-gray-500 text-xs my-auto">(4.5)</div>
                </div>
            </div>
    </div>
    <div class="mt-4 flex justify-between items-end h-full">
        <a href="{{ $url_detail }}" class="rounded-full px-10 py-2 font-medium border-2 border-primary text-sm text-primary  hover:bg-primary hover:text-white">Detail</a>
        <div onclick="addCart({{ $idProduk }})" class="cursor-pointer">
            <img src="{{ asset('gambar/icon/cart-produk.png') }}" class="w-10" alt="Skincare image">
        </div>
    </div>
</div>

@push('addScript')
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
