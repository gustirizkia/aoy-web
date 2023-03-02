@extends('layouts.frontend')

@section('title')
    AY'S ON YOU 2022
@endsection

@push('addStyle')
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />
@endpush

@section('content')
<div class="" x-data="funcData">

     {{-- Header section --}}
    <section class="md:px-32 px-6 py-14 bg-hero-pattern relative overflow-y-hidden" >
        <div class="grid grid-flow-row grid-cols-12 gap-6">
            <div class="md:col-span-6 col-span-12 items-center md:hidden flex justify-center">
                <img src="{{ asset('gambar/produk-hero.png') }}" class="w-2/3 z-10" alt="">
            </div>
            <div class="md:col-span-6 col-span-12 flex items-center text-center md:text-left">
                <div class="">
                    <div class="md:text-6xl text-3xl font-medium text-gray-800 ">
                        {{-- Dapatkan <br> Kulit Sehat dan Sempurna --}}
                        {{-- Feel <br>
                        Comfortable in  <br>
                        Flawless Skin --}}
                        Get Health and Perfect Skin
                    </div>
                    <div class="text-gray-500 my-4 md:my-6 mb-6 md:mb-12 text-lg md:w-2/3">
                        Memiliki kulit sehat dan cantik sudah menjadi idaman para Wanita. Berbagai varian dari serum somethinc ini menjadi solusinya. Penuhi kebutuhan kulitmu agar kecantikanmu terpancar.
                    </div>
                        <a href="{{ route('produk') }}" class="bg-primary px-8 hover:bg-purple-500 mt-4 md:mt-8 py-3 rounded-full text-white">Lihat Produk</a>
                </div>

            </div>
            <div class="md:col-span-6 col-span-12 items-center hidden md:flex justify-center">
                <img src="{{ asset('gambar/produk-hero.png') }}" class="w-2/3 z-10" alt="">
            </div>
        </div>
        <div class="absolute -top-24 right-0 hidden md:block">
            <img src="{{ asset('gambar/shaepe-r.png') }}" class="w-80 -z-10" alt="">
        </div>
    </section>

    {{-- section produk  rekomendasi--}}
    <section class="my-8 md:px-32 px-6">
        <div class="grid grid-flow-row grid-cols-12 gap-6">
            <div class="col-span-12">
                <div class="md:text-4xl text-2xl text-center text-gray-800 font-medium">
                    Produk Rekomendasi
                </div>
            </div>
            @foreach ($rekomendasi as $item)
                <div class="md:col-span-3 col-span-6">
                    @component('Frontend.components.card-produk')
                        @slot('param_nama')
                            {{ $item->nama }}
                        @endslot
                        @slot('idProduk')
                            {{ $item->id }}
                        @endslot
                        @slot('image_url')
                            {{ url($item->thumbnail->photo) }}
                        @endslot
                        @slot('nama')
                            {{ $item->nama }}
                        @endslot
                        @slot('url_detail')
                                {{ route('detail-produk', $item->slug) }}
                        @endslot
                        @slot('url_add')
                            {{ $item->id }}
                        @endslot
                        @slot('harga')
                            {{ number_format($item->harga) }}
                        @endslot
                    @endcomponent
                </div>
            @endforeach

        </div>
    </section>

    <section class="my-8 md:px-32 px-6 relative py-16">
        <div class="">
            <img src="{{ asset('gambar/icon/shape-tl.png') }}" alt="" class="absolute top-0 left-0">
        </div>
        <div class="">
            <img src="{{ asset('gambar/icon/shape-br.png') }}" alt="" class="absolute bottom-0 right-0">
        </div>
        <div class="grid grid-flow-row grid-cols-12 gap-6 md:gap-16 relative items-center">
            <div class="col-span-12 md:col-span-7">
                <img src="{{ asset('gambar/icon/image-video.png') }}" class="w-full" alt="">
            </div>
            <div class="md:col-span-5 col-span-12">
                <div class="py-6 md:py-14">
                    <div class="text-4xl text-gray-800 font-semibold text-center md:text-left">
                        Liquid Foundation With a Matte Finish
                    </div>
                    <div class="text-gray-600 text-xl mt-6 text-center md:text-left">
                        Foundation cair mudah untuk di blend, cocok untuk semua jenis kulit. Dengan hasil akhir matte, tidak mudah luntur atau crack.
                    </div>

                    <div class="mt-6">
                        <div class="grid grid-flow-row grid-cols-12 gap-6">
                            <div class="md:col-span-6 col-span-6 border p-4 rounded-xl bg-white">
                                <img src="{{ asset('gambar/icon/face.png') }}" class="mx-auto" alt="Face AOY">
                                <div class="text-gray-500 text-center mt-6 font-medium">
                                    Cocok untuk kulit normal
                                </div>
                            </div>
                            <div class="md:col-span-6 col-span-6 border p-4 rounded-xl bg-white">
                                <img src="{{ asset('gambar/icon/face.png') }}" class="mx-auto" alt="Face AOY">
                                <div class="text-gray-500 text-center mt-6 font-medium">
                                    Cocok untuk kulit berminyak
                                </div>
                            </div>
                            <div class="md:col-span-6 col-span-6 border p-4 rounded-xl bg-white">
                                <img src="{{ asset('gambar/icon/face.png') }}" class="mx-auto" alt="Face AOY">
                                <div class="text-gray-500 text-center mt-6 font-medium">
                                    Cocok untuk kulit berminyak area T-zone
                                </div>
                            </div>
                            <div class="md:col-span-6 col-span-6 border p-4 rounded-xl bg-white">
                                <img src="{{ asset('gambar/icon/face.png') }}" class="mx-auto" alt="Face AOY">
                                <div class="text-gray-500 text-center mt-6 font-medium">
                                    Cocok untuk kulit berjerawat
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- section produk terbaru --}}
    <section class="my-8 md:px-32 px-6">
        <div class="grid grid-flow-row grid-cols-12 gap-6">
            <div class="col-span-12">
                <div class="text-2xl md:text-4xl text-center text-gray-800 font-medium">
                    Produk Terbaru
                </div>
            </div>
            @foreach ($terbaru as $item)
                <div class="md:col-span-3 col-span-6">
                    @component('Frontend.components.card-produk')
                        @slot('param_nama')
                            {{ $item->nama }}
                        @endslot
                        @slot('idProduk')
                            {{ $item->id }}
                        @endslot
                        @slot('image_url')
                            {{ asset($item->thumbnail->photo) }}
                        @endslot
                        @slot('nama')
                            <div class="md:text-lg text-xs">
                                {{ $item->nama }}
                            </div>
                        @endslot
                        @slot('url_detail')
                                {{ route('detail-produk', $item->slug) }}
                        @endslot
                        @slot('url_add')
                            {{ $item->id }}
                        @endslot
                        @slot('harga')
                            {{ number_format($item->harga) }}
                        @endslot
                    @endcomponent
                </div>
            @endforeach
        </div>
    </section>

    {{--  member --}}
    <section class="my-8 md:px-32 px-6 bg-purple-50 py-8 md:py-14">
        <div class="md:flex justify-between items-center">
            <div class="text-2xl font-medium text-center md:text-left">
                Temui kami <br>
                di sekitar anda
            </div>
            <div class="md:flex mt-4 md:mt-0">
                <div class="flex group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full md:w-60 items-center px-3">
                    <img src="{{ asset('gambar/icon/serach.png') }}" class="h-6" alt="">
                    <select name="" id="" class="w-full text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-400">
                        <option value="" class="text-gray-400">Semua Provinsi</option>
                        @foreach ($provinsi as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex group group-focus::border-primary bg-white mt-4 md:mt-0 md:ml-8 group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full md:w-60 items-center px-3">
                    <img src="{{ asset('gambar/icon/serach.png') }}" class="h-6" alt="">
                    <input type="text" class="w-full text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-400" placeholder="Cari Nama atau ID">
                </div>
            </div>
        </div>

        <div class="my-10 grid grid-flow-row grid-cols-12 gap-6 md:gap-10">
            @foreach ($member as $item)
                <div class="md:col-span-6 col-span-12 bg-white md:flex rounded-tl-56px overflow-hidden rounded-bl-xl rounded-xl relative rounded-br-56px">
                    <a href="{{ route('detailMember', $item->username) }}">
                        <img src="{{ url('storage/'.$item->image) }}" class="rounded-br-56px rounded-tr-xl h-60 w-full md:w-48 object-cover" />
                    </a>
                    <a href="{{ route('detailMember', $item->username) }}">

                        <div class="p-8">
                            <div class="text-xl font-medium text-gray-800">{{ $item->name }}</div>
                            <div class="flex items-center mt-3">
                                <img src="{{ asset('gambar/icon/id_member.png') }}" class="" alt="">
                                <div class="text-gray-400 ml-4 text-sm">{{ $item->username }}</div>
                            </div>
                            <div class="flex items-center mt-3">
                                <img src="{{ asset('gambar/icon/location.png') }}" class="" alt="">
                                <div class="text-gray-400 ml-4 text-sm">{{ $item->kota }}, {{ $item->subdistrict_name }}</div>
                            </div>
                            <div class="flex justify-center mt-5 mb-8 md:mb-0">
                                <a href="https://wa.me/{{ $item->nomor_wa }}" target="_blank">
                                    <img class="mx-2" src="{{ asset('gambar/icon/wa.png') }}" alt="">
                                </a>
                                <a href="https://www.instagram.com/{{ $item->akun_ig }}/" target="_blank">
                                    <img class="mx-2" src="{{ asset('gambar/icon/ig.png') }}" alt="">
                                </a>
                            </div>
                        </div>
                    </a>
                    <div class="absolute bottom-0 right-0 z-20">
                        <div class="bg-primary text-white font-medium inline-block md:w-56 rounded-tl-56px w-40 py-2 text-center">
                            {{ $item->level_nama }}
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($member->currentPage() < $member->lastPage())
                <div class="col-span-12">
                    <a href="/member" class="flex justify-center">
                        <div class="border-2 border-primary px-6 py-3 text-primary font-medium rounded-full cursor-pointer hover:bg-primary hover:text-white">
                            Lebih Banyak
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- section testimoni --}}
    <section class="md:px-32 px-6 mt-12">
        <div class="grid grid-flow-row grid-cols-12 gap-6">
            <div class="md:col-span-6 col-span-12 flex justify-center items-center">
                <img src="{{ asset('gambar/foto_keluarga.png') }}" class="w-2/3" alt="AOY">
            </div>

            <div class="col-span-12 md:col-span-6 py-8">
                <div class="font-semibold text-3xl text-gray-800 ">
                    Cakupannya luar biasa
                </div>
                <div class="my-4 md:my-8">
                    <img src="{{ asset('gambar/stars.png') }}" alt="" class="w-32 md:w-1/3">
                </div>
                <div class="text-gray-700 leading-8 md:leading-10 text-lg md:text-xl">
                    Saya memakai produk ini sudah lama, hasilnya pun terlihat jelas membuat wajah saya lebih cerah dan jerawat pun terhempas. Saya recommend untuk beli produk ditoko ini. Dijamin tidak akan menyesal, pasti akan ketagihan.
                </div>

                <div class="my-8 text-gray-400 text-lg">
                    Shintia finance at GOTO
                </div>
            </div>
        </div>
    </section>

</div>

@endsection


@push('addScript')
<script>
    function funcData(){
        return{
            handleFilterMember(provinsi){

            }
        }
    }
</script>
@endpush
