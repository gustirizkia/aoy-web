@extends('layouts.frontend')

@section('title')
    {{ $member->level_nama }} {{ $member->name }}
@endsection

@push('addStyle')

@endpush

@section('content')
<div class="md:px-32 px-6">
    <div class="md:text-3xl text-xl text-center mt-6">
        {{ $member->level_nama }} {{ $member->name }}
    </div>
    <div class="md:text-2xl text-lg text-center mt-2">
        {{ $member->provinsi }}, {{ $member->kota }}, {{ $member->subdistrict_name }}
    </div>
    <div class="flex justify-center">
        <div class=" text-center md:w-1/2">
            <div class="my-4 text-gray-600">
                {{ $member->deskripsi }}
            </div>
            <div class="text-2xl mb-2">Gallery</div>
            <div class="grid grid-flow-row grid-cols-12 gap-4">
                @foreach ($member_galleries as $item)
                    <div class="col-span-6 md:col-span-4">
                        <img src="{{ url('storage/'.$item->image) }}" class="h-full w-full object-cover" alt="Member AOY {{ $member->name }}">
                    </div>
                @endforeach
            </div>
            <div class="text-2xl mt-4">
                Kontak
            </div>
            <div class="flex justify-center mt-5 mb-8 md:mb-0">
                <a href="https://wa.me/{{ $member->nomor_wa }}" target="_blank">
                    <img class="mx-2" src="{{ asset('gambar/icon/wa.png') }}" alt="" class="w-44 h-auto">
                </a>
                <a href="https://www.instagram.com/{{ $member->akun_ig }}/" target="_blank">
                    <img class="mx-2" src="{{ asset('gambar/icon/ig.png') }}" alt="" class="w-44 h-auto">
                </a>
            </div>
        </div>
    </div>
</div>

<div class="absolute -top-12 right-0 hidden md:block">
            <img src="{{ asset('gambar/shaepe-r.png') }}" alt="AysOnYou" class="h-auto w-96">
</div>
@endsection


@push('addScript')

@endpush
