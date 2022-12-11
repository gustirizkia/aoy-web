@extends('layouts.frontend')

@section('title')
    Explore Produk
@endsection

@section('content')
{{-- banner --}}
<section>
    <img src="https://admin.filterpedia.co.id/storage/banner-images/T2V68j64qSc543KMpItpuQASmoM8isQ4aY2NYs4H.jpg" class="w-full" alt="">
</section>
<section class="md:px-32 px-6 mt-12">
    <div class="grid grid-flow-row grid-cols-12 gap-6">
        <div class="col-span-12 md:col-span-3">
            <div class="border pl-4 py-4 shadow rounded-lg">
                <div class="font-semibold">Filter</div>
                <div class="mt-6">
                    <div class=" cursor-pointer bg-gradient-to-r from-white to-purple-300 py-2 font-semibold text-neutral-800 relative">
                        Semua Produk
                        <div class="bg-primary h-full absolute right-0 w-2 top-0"></div>
                    </div>
                </div>
                @for ($i = 0; $i < 4; $i++)
                    <div class="mt-6">
                        <div class="text-gray-500 cursor-pointer">Kategori - {{ $i }}</div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="md:col-span-9 col-span-12">
            <div class="grid grid-flow-row grid-cols-12 gap-4">
                @foreach ($items as $item)
                    <div class="md:col-span-4 col-span-12">
                        @component('Frontend.components.card-produk')
                            @slot('image_url')
                                {{ url($item->thumbnail->photo) }}
                            @endslot
                            @slot('nama')
                                <div class="text-base">
                                    {{ $item->nama }}
                                </div>
                            @endslot
                            @slot('url_detail')
                                {{ route('detail-produk', $item->slug) }}
                            @endslot
                            @slot('url_add')
                                1
                            @endslot
                        @endcomponent
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
@endsection

@push('addScript')

@endpush
