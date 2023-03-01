@extends('layouts.frontend')

@section('title')
    Seller AOY
@endsection

@section('content')
<div class="md:px-32 px-6">
    <div class="md:flex mt-4 md:mt-8 justify-end">
        <div class="flex justify-end group group-focus::border-primary bg-white group-focus:ring-primary py-1 focus-within:ring-primary focus-within:border-primary border-2 rounded-full w-full md:w-60 items-center px-3">
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
    <div class="my-10 grid grid-flow-row grid-cols-12 gap-6 md:gap-10" id="row_member">
            @foreach ($member as $item)
                <div class="md:col-span-6 col-span-12 bg-white border md:flex rounded-tl-56px overflow-hidden rounded-bl-xl rounded-xl relative rounded-br-56px">
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

        </div>

        @if ($member->currentPage() < $member->lastPage())
            <div class="col-span-12">
                <div class="flex justify-center">
                    <div onclick="loadMore()" class="border-2 border-primary px-6 py-3 text-primary font-medium rounded-full cursor-pointer hover:bg-primary hover:text-white">
                        Lebih Banyak
                    </div>
                </div>
            </div>
        @endif
</div>
@endsection

@push('addScript')
    <script>
        let currentPage = {{ $member->currentPage() }};
        let lastPage = {{ $member->lastPage() }};

        function loadMore(){
            currentPage += 1;
            axios.get('{{ route('getMember') }}?page='+currentPage).then(res => {
                let items = res.data.data;
                let htmlTag = '';
                items.forEach(element => {
                    htmlTag += `
                        <div class="md:col-span-6 col-span-12 bg-white border md:flex rounded-tl-56px overflow-hidden rounded-bl-xl rounded-xl relative rounded-br-56px">
                            <a href="/member/${element.username}">
                                <img src="{{ url('storage') }}/${element.image}" class="rounded-br-56px rounded-tr-xl h-60 w-full md:w-48 object-cover" />
                            </a>
                            <a href="/member/${element.username}">

                                <div class="p-8">
                                    <div class="text-xl font-medium text-gray-800">${element.name}</div>
                                    <div class="flex items-center mt-3">
                                        <img src="{{ asset('gambar/icon/id_member.png') }}" class="" alt="">
                                        <div class="text-gray-400 ml-4 text-sm">${element.username}</div>
                                    </div>
                                    <div class="flex items-center mt-3">
                                        <img src="{{ asset('gambar/icon/location.png') }}" class="" alt="">
                                        <div class="text-gray-400 ml-4 text-sm">${element.kota}, ${element.subdistrict_name}</div>
                                    </div>
                                    <div class="flex justify-center mt-5 mb-8 md:mb-0">
                                        <a href="https://wa.me/${element.nomor_wa}" target="_blank">
                                            <img class="mx-2" src="{{ asset('gambar/icon/wa.png') }}" alt="">
                                        </a>
                                        <a href="https://www.instagram.com/${element.akun_ig}/" target="_blank">
                                            <img class="mx-2" src="{{ asset('gambar/icon/ig.png') }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </a>
                            <div class="absolute bottom-0 right-0 z-20">
                                <div class="bg-primary text-white font-medium inline-block md:w-56 rounded-tl-56px w-40 py-2 text-center">
                                    ${element.level_nama}
                                </div>
                            </div>
                        </div>
                    `;
                });

                $("#row_member").append(htmlTag);
            });
        }
    </script>
@endpush
