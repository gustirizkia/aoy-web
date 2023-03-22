@extends('layouts.frontend')

@section('title')
    Explore Produk
@endsection

@section('content')
{{-- banner --}}
<section>

<div id="default-carousel" class="relative w-full" data-carousel="slide">

    @if ($banner)
        <img src="{{ asset($banner->photo) }}" class="w-full" alt="">
    @endif

</section>
<section class="md:px-32 px-6 mt-4 md:mt-12">
    <div class="grid grid-flow-row grid-cols-12 gap-6">
        <div class="col-span-12 md:col-span-3">
            <div class="md:hidden">
                <div class="font-semibold mb-2">Kategori</div>
                <div class="flex overflow-x-auto">
                    <a href="/produk{{ Request::has('search') ? '?search='.Request::get('search') : '' }}" class="border rounded-xl px-4 py-2 text-sm mr-2 {{ !Request::has('q') ? 'bg-primary bg-opacity-50' : '' }}">Semua</a>
                    @foreach ($kategori as $item)
                        <a href="?q={{ $item->slug }}{{ Request::has('search') ? '&search='.Request::get('search') : '' }}" class="border rounded-xl px-4 py-2 text-sm mr-2 {{ Request::get('q') === $item->slug ? 'bg-primary bg-opacity-50' : '' }}">{{ $item->nama }}</a>
                    @endforeach
                </div>
            </div>
            <div class="border pl-4 py-4 shadow rounded-lg md:block hidden">
                <div class="font-semibold">Kategori</div>
                <div class="mt-6">
                    @if (!Request::has('q'))
                        <div class=" cursor-pointer bg-gradient-to-r from-white to-purple-300 py-2 font-semibold text-neutral-800 relative">
                            Semua Produk
                            <div class="bg-primary h-full absolute right-0 w-2 top-0"></div>
                        </div>

                    @else
                        <a href="/produk{{ Request::has('search') ? '?search='.Request::get('search') : '' }}" class="text-gray-500 cursor-pointer  block">Semua Produk</a>
                    @endif
                </div>
                @foreach ($kategori as $item)
                    <div class="mt-6">

                        @if (Request::has('q'))
                            @if (Request::get('q') === $item->slug)
                                <div class=" cursor-pointer bg-gradient-to-r from-white to-purple-300 py-2 font-semibold text-neutral-800 relative">
                                    {{ $item->nama }}
                                    <div class="bg-primary h-full absolute right-0 w-2 top-0"></div>
                                </div>
                            @else
                            <a href="?q={{ $item->slug }}{{ Request::has('search') ? '&search='.Request::get('search') : '' }}" class="text-gray-500 cursor-pointer  block">{{ $item->nama }}</a>
                            @endif
                        @else
                            <a href="?q={{ $item->slug }}{{ Request::has('search') ? '&search='.Request::get('search') : '' }}" class="text-gray-500 cursor-pointer  block">{{ $item->nama }}</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="md:col-span-9 col-span-12">
            <div class="grid grid-flow-row grid-cols-12 gap-4">
                @forelse ($items as $item)
                    <div class="md:col-span-3 col-span-6">
                        @component('Frontend.components.card-produk')
                            @slot('image_url')
                                {{ url($item->thumbnail->photo) }}
                            @endslot
                            @slot('nama')
                                <div class="text-xs md:text-base">
                                    {{ $item->nama }}
                                </div>
                            @endslot
                            @slot('url_detail')
                                {{ route('detail-produk', $item->slug) }}
                            @endslot
                            @slot('url_add')
                                1
                            @endslot
                            @slot('harga')
                                {{ number_format($item->harga) }}
                            @endslot
                        @endcomponent
                    </div>
                @empty
                <div class="col-span-12">
                    <div class="text-xl text-center">
                        Produk tidak ditemukan
                    </div>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</section>
@endsection

@push('addScript')

@endpush
