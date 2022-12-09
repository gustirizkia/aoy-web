@extends('layouts.frontend')

@section('title')
    AY'S ON YOU
@endsection

@push('addStyle')
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />
@endpush

@section('content')
     {{-- Header section --}}
    <section class="md:px-32 px-6 py-14 bg-hero-pattern relative overflow-y-hidden" >
        <div class="grid grid-flow-row grid-cols-12 gap-6">
            <div class="md:col-span-6 col-span-12 items-center md:hidden flex justify-center">
                <img src="{{ asset('gambar/produk-hero.png') }}" class="w-2/3 z-10" alt="">
            </div>
            <div class="md:col-span-6 col-span-12 flex items-center text-center md:text-left">
                <div class="">
                    <div class="md:text-6xl text-3xl font-medium text-gray-800 ">
                        Feel <br>
                        Comfortable in  <br>
                        Flawless Skin
                    </div>
                    <div class="text-gray-500 my-4 md:my-6 mb-6 md:mb-12 text-lg md:w-2/3">
                        Let's create a unique abstract minimalism in website design. The most fashionable and calm style
                    </div>
                        <a href="#" class="bg-primary px-8 hover:bg-purple-500 mt-4 md:mt-8 py-3 rounded-full text-white">Lihat Produk</a>
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
             <div class="md:col-span-4 col-span-12">
                @component('Frontend.components.card-produk')
                    @slot('image_url')
                        https://img.freepik.com/premium-psd/logo-mockup-stand-face-hand-cream_145275-462.jpg?w=900
                    @endslot
                    @slot('nama')
                        Lorem ipsum dolor sit amet.
                    @endslot
                    @slot('url_detail')
                         {{ route('detail-produk') }}
                    @endslot
                    @slot('url_add')
                        1
                    @endslot
                @endcomponent
            </div>
            <div class="md:col-span-4 col-span-12">
                @component('Frontend.components.card-produk')
                    @slot('image_url')
                        https://img.freepik.com/premium-psd/cosmetic-tube-packaging-mockups_144389-269.jpg?w=900
                    @endslot
                    @slot('nama')
                        Lorem ipsum dolor sit amet.
                    @endslot
                    @slot('url_detail')
                         {{ route('detail-produk') }}
                    @endslot
                    @slot('url_add')
                        1
                    @endslot
                @endcomponent
            </div>
            <div class="md:col-span-4 col-span-12">
                @component('Frontend.components.card-produk')
                    @slot('image_url')
                       https://img.freepik.com/premium-psd/minimal-cream-tube-mockup_590726-56.jpg
                    @endslot
                    @slot('nama')
                        Lorem ipsum dolor sit amet.
                    @endslot
                    @slot('url_detail')
                         {{ route('detail-produk') }}
                    @endslot
                    @slot('url_add')
                        1
                    @endslot
                @endcomponent
            </div>
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
                        Phore Soft Matte Liquid <br>
                        Foundation
                    </div>
                    <div class="text-gray-600 text-xl mt-6 text-center md:text-left">
                        Let's create a unique abstract minimalism in website design. The most fashionable and calm style
                    </div>

                    <div class="mt-6">
                        <div class="grid grid-flow-row grid-cols-12 gap-6">
                            <div class="md:col-span-6 col-span-6 border p-6 rounded-xl bg-white">
                                <img src="{{ asset('gambar/icon/face.png') }}" class="mx-auto" alt="Face AOY">
                                <div class="text-gray-500 text-center mt-6 font-medium">
                                    Cocok untuk semua jenis wajah
                                </div>
                            </div>
                            <div class="md:col-span-6 col-span-6 border p-6 rounded-xl bg-white">
                                <img src="{{ asset('gambar/icon/face.png') }}" class="mx-auto" alt="Face AOY">
                                <div class="text-gray-500 text-center mt-6 font-medium">
                                    Cocok untuk semua jenis wajah
                                </div>
                            </div>
                            <div class="md:col-span-6 col-span-6 border p-6 rounded-xl bg-white">
                                <img src="{{ asset('gambar/icon/face.png') }}" class="mx-auto" alt="Face AOY">
                                <div class="text-gray-500 text-center mt-6 font-medium">
                                    Cocok untuk semua jenis wajah
                                </div>
                            </div>
                            <div class="md:col-span-6 col-span-6 border p-6 rounded-xl bg-white">
                                <img src="{{ asset('gambar/icon/face.png') }}" class="mx-auto" alt="Face AOY">
                                <div class="text-gray-500 text-center mt-6 font-medium">
                                    Cocok untuk semua jenis wajah
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
            <div class="md:col-span-4 col-span-12">
                @component('Frontend.components.card-produk')
                    @slot('image_url')
                        https://img.freepik.com/premium-psd/logo-mockup-stand-face-hand-cream_145275-462.jpg?w=900
                    @endslot
                    @slot('nama')
                        Lorem ipsum dolor sit amet.
                    @endslot
                    @slot('url_detail')
                         {{ route('detail-produk') }}
                    @endslot
                    @slot('url_add')
                        1
                    @endslot
                @endcomponent
            </div>
            <div class="md:col-span-4 col-span-12">
                @component('Frontend.components.card-produk')
                    @slot('image_url')
                        https://img.freepik.com/premium-psd/cosmetic-tube-packaging-mockups_144389-269.jpg?w=900
                    @endslot
                    @slot('nama')
                        Lorem ipsum dolor sit amet.
                    @endslot
                    @slot('url_detail')
                         {{ route('detail-produk') }}
                    @endslot
                    @slot('url_add')
                        1
                    @endslot
                @endcomponent
            </div>
            <div class="md:col-span-4 col-span-12">
                @component('Frontend.components.card-produk')
                    @slot('image_url')
                       https://img.freepik.com/premium-psd/minimal-cream-tube-mockup_590726-56.jpg
                    @endslot
                    @slot('nama')
                        Lorem ipsum dolor sit amet.
                    @endslot
                    @slot('url_detail')
                        {{ route('detail-produk') }}
                    @endslot
                    @slot('url_add')
                        1
                    @endslot
                @endcomponent
            </div>
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
                        <option value="">Aceh</option>
                        <option value="">Banten</option>
                    </select>
                </div>
                <div class="flex group group-focus::border-primary bg-white mt-4 md:mt-0 md:ml-8 group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full md:w-60 items-center px-3">
                    <img src="{{ asset('gambar/icon/serach.png') }}" class="h-6" alt="">
                    <input type="text" class="w-full text-sm text-gray-900 bg-gray-50 focus:ring-0 border-0 placeholder-gray-400" placeholder="Cari Nama atau ID">
                </div>
            </div>
        </div>

        <div class="my-10 grid grid-flow-row grid-cols-12 gap-6 md:gap-10">
            <div class="md:col-span-6 col-span-12 bg-white md:flex rounded-tl-56px overflow-hidden rounded-bl-xl rounded-xl relative rounded-br-56px">
                <img src="{{ asset('gambar/download.jpg') }}" class="rounded-br-56px rounded-tr-xl h-56 w-full md:w-48 object-cover" />
                <div class="p-8">
                    <div class="text-2xl font-medium text-gray-800">Rani Putri</div>
                    <div class="flex items-center mt-3">
                        <img src="{{ asset('gambar/icon/id_member.png') }}" class="" alt="">
                        <div class="text-gray-400 ml-4">AOY.009012</div>
                    </div>
                    <div class="flex items-center mt-3">
                        <img src="{{ asset('gambar/icon/location.png') }}" class="" alt="">
                        <div class="text-gray-400 ml-4">Summarecon Mall Serpong</div>
                    </div>
                    <div class="flex justify-center mt-5 mb-8 md:mb-0">
                        <a href="">
                            <img class="mx-2" src="{{ asset('gambar/icon/wa.png') }}" alt="">
                        </a>
                        <a href="">
                            <img class="mx-2" src="{{ asset('gambar/icon/ig.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 z-20">
                    <div class="bg-primary text-white font-medium inline-block md:w-56 rounded-tl-56px w-40 py-2 text-center">
                        Distributor
                    </div>
                </div>
            </div>
            <div class="md:col-span-6 col-span-12 bg-white md:flex rounded-tl-56px overflow-hidden rounded-bl-xl rounded-xl relative rounded-br-56px">
                <img src="data:image/jpeg;base64,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"
                    class="rounded-br-56px rounded-tr-xl h-56 w-full md:w-48 object-cover" />
                <div class="p-8">
                    <div class="text-2xl font-medium text-gray-800">Soya</div>
                    <div class="flex items-center mt-3">
                        <img src="{{ asset('gambar/icon/id_member.png') }}" class="" alt="">
                        <div class="text-gray-400 ml-4">AOY.009012</div>
                    </div>
                    <div class="flex items-center mt-3">
                        <img src="{{ asset('gambar/icon/location.png') }}" class="" alt="">
                        <div class="text-gray-400 ml-4">Summarecon Mall Serpong</div>
                    </div>
                    <div class="flex justify-center mt-5 mb-8 md:mb-0">
                        <a href="">
                            <img class="mx-2" src="{{ asset('gambar/icon/wa.png') }}" alt="">
                        </a>
                        <a href="">
                            <img class="mx-2" src="{{ asset('gambar/icon/ig.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 z-20">
                    <div class="bg-primary text-white font-medium inline-block md:w-56 rounded-tl-56px w-40 py-2 text-center">
                        Distributor
                    </div>
                </div>
            </div>
            <div class="col-span-12">
                <div class="flex justify-center">
                    <div class="border-2 border-primary px-6 py-3 text-primary font-medium rounded-full cursor-pointer hover:bg-primary hover:text-white">
                        Lebih Banyak
                    </div>
                </div>
            </div>
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
                    saya menggunakan ini dan menyukainya. memiliki warna kulit yang sangat tidak serasi
                    jadi butuh coverage yang bagus. saya sangat pucat jadi gunakan warna yang paling terang, juga baik-baik saja
                    satu pump udah cukup buat full face. untuk harganya luar biasa
                </div>

                <div class="my-8 text-gray-400 text-lg">
                    Shintia finance at GOTO
                </div>
            </div>
        </div>
    </section>

<div x-data="{ open: false }">
  <button @click="open = true">Open Dropdown</button>
  <ul x-show="open" @click.away="open = false">
    Dropdown Body
  </ul>
</div>

<div class="" x-data="{
    activeSlide: 1,
    slides: [
        {
            id: 1,
            title: 'Hello World'
        },
        {
            id: 2,
            title: 'Hello World'
        },
        {
            id: 3,
            title: 'Hello World'
        },
    ]
}">

    <template class="" x-for="item in slides" :key="item.id">
        <div class="">

        </div>
        <div class="" x-text="item.title"></div>
    </template>

</div>

<div class="relative" x-data="{
    activeSlide: 1,
    slides: [
        {
            id: 1,
            title: 'Hello World'
        },
        {
            id: 2,
            title: 'Hello World'
        },
        {
            id: 3,
            title: 'Hello World'
        },
    ],
        images: [
            'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80',
            'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80',
            'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&q=80',
            'https://images.unsplash.com/photo-1486870591958-9b9d0d1dda99?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80',
            'https://images.unsplash.com/photo-1485160497022-3e09382fb310?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80',
            'https://images.unsplash.com/photo-1472791108553-c9405341e398?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2137&q=80'
        ]
}">
    <img class="h-64 w-full object-cover object-center"
        :src="images[activeSlide]"
        alt="mountains" />
{{-- <template x-for="item in slides" :key="item.id">

</template> --}}


<div class="absolute bottom-0 w-full p-4 flex justify-center space-x-2">
    <template x-for="(image,index) in images" :key="index">
        <button @click="activeSlide = index" :class="{'bg-gray-300': activeSlide == index, 'bg-gray-500': activeSlide != index}"
            class="h-2 w-2 rounded-full hover:bg-gray-300 ring-2 ring-gray-300"></button>
    </template>
</div>
</div>

@endsection


@push('addScript')

@endpush
