@extends('layouts.frontend')

@section('title')
    Rincian Transaksi
@endsection

@section('content')
    <div class="md:px-32 md:mt-8 mt-6" x-data="funcData">
        <div class="md:px-20">
            <div class="grid grid-flow-row grid-cols-12 gap-6">
                <div class="col-span-4 hidden md:block">
                    <div class="bg-white p-4 rounded-lg">
                        <div class="font-semibold">
                            Rincian Transaksi
                        </div>


                        <ol class="ml-4 mt-4 pl-2 relative text-gray-500 border-l border-gray-200 dark:border-gray-700 dark:text-gray-400">
                            <li class="mb-10 ml-6">
                                <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -left-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                    <svg aria-hidden="true" class="w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </span>
                                <h3 class="font-medium leading-tight text-gray-900 ">Pembayaran</h3>
                                <p class="text-xs">{{ \carbon\Carbon::parse($item->payment_at)->translatedFormat('l, d F Y')}}</p>
                            </li>
                            <li class="mb-10 ml-6">
                                <span class="absolute flex items-center justify-center w-8 h-8 {{ $transaksi->status !== 'UNPAID' ? 'bg-green-200 dark:bg-green-900' : 'bg-gray-100 dark:ring-gray-900 dark:bg-gray-700' }} rounded-full -left-4 ring-4 ring-white ">
                                    @if ($transaksi->status !== 'UNPAID')
                                        <svg aria-hidden="true" class="w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 {{ $transaksi->status !== 'UNPAID' ? 'text-green-500 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }} ">
                                            <path d="M12.378 1.602a.75.75 0 00-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03zM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 00.372-.648V7.93zM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 00.372.648l8.628 5.033z" />
                                        </svg>
                                    @endif
                                </span>
                                <h3 class="font-medium leading-tight text-gray-900">Pesanan diproses</h3>
                                <p class="text-xs">Pesanan anda dalam pengemasan</p>
                            </li>
                            <li class="mb-10 ml-6">
                                @if ($transaksi->status === 'konfirmasi')
                                    <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -left-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                        <svg aria-hidden="true" class="w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    </span>
                                @else
                                    <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -left-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-500 dark:text-gray-400">
                                            <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 116 0h3a.75.75 0 00.75-.75V15z" />
                                            <path d="M8.25 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0zM15.75 6.75a.75.75 0 00-.75.75v11.25c0 .087.015.17.042.248a3 3 0 015.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 00-3.732-10.104 1.837 1.837 0 00-1.47-.725H15.75z" />
                                            <path d="M19.5 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                        </svg>
                                    </span>
                                @endif
                                <h3 class="font-medium leading-tight text-gray-900">Pengiriman</h3>
                                <p class="text-xs">Sedang dalam perjalanan</p>
                            </li>
                            <li class="ml-6">
                                <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -left-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </span>
                                <h3 class="font-medium leading-tight text-gray-900">Pesanan sudah diterima</h3>
                                <p class="text-xs">Barang sudah sampai</p>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-8">
                    <div class="rounded-lg bg-white p-4 md:p-8">
                        <div class="font-bold">
                            Rincian Pesanan
                        </div>
                        <div class="mt-6 md:flex justify-between">
                            <div class="">
                                <div class="text-gray-500">
                                    No. Invoice
                                </div>
                                <div class="mt-2 font-medium">
                                    {{ $transaksi->no_inv }}
                                </div>
                            </div>

                            <div class="md:mt-0 mt-4">
                                <div class="text-gray-500">
                                    Metode pembayaran
                                </div>
                                <div class="mt-2 font-medium">
                                    {{ $transaksi->payment_name }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="text-gray-500">
                                Lokai tujuan
                            </div>
                            <div class=" font-medium">
                                {{ $transaksi->kecamatan->subdistrict_name }}, {{ $transaksi->kota->name }}, {{ $transaksi->provinsi->name }}
                            </div>
                            <div class="text-gray-500 text-sm">
                                {{ $transaksi->alamat_lengkap }}
                            </div>
                        </div>

                        {{-- list produk desktop --}}
                        @foreach ($detail_transaksi as $detail)
                            <div class="mt-6 md:block hidden">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <img src="{{ asset($detail->produk->thumbnail->photo) }}" alt="" class="w-20 rounded-lg">
                                        <div class="mx-6">
                                            {{ $detail->qty }}x
                                        </div>
                                        <div class="">
                                          {{ $detail->produk->nama }}
                                        </div>
                                    </div>
                                    <div class="font-semibold">
                                        Rp{{ number_format($detail->harga) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-6 md:hidden">
                            @foreach ($detail_transaksi as $detailMobile)
                                <div class="grid grid-flow-row grid-cols-12 gap-3 mb-7">
                                    <div class="col-span-3 my-auto">
                                    <img src="{{ asset($detailMobile->produk->thumbnail->photo) }}" class="w-full rounded-lg" alt="">
                                    </div>
                                    <div class="text-xs col-span-9">
                                        <div class="font-semibold ">
                                            WhiteCellDNA™ Night Cream
                                        </div>
                                        <div class="text-gray-600">
                                            {{ $detailMobile->qty }}x
                                            <div class="text-gray-800 font-medium">
                                                Rp{{ number_format($detailMobile->harga)  }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="my-6">
                            <hr>
                        </div>

                        <div class="flex justify-end w-full text-sm">
                            <div class="">
                                <div class=" flex justify-between w-72 text-gray-500 mb-3">
                                    <div class="">
                                        Harga barang
                                    </div>
                                    <div class="text-gray-900 font-medium">Rp{{ number_format($transaksi->total_harga_barang) }}</div>
                                </div>
                                <div class=" flex justify-between w-72 text-gray-500 mb-3">
                                    <div class="">
                                        Biaya Pengiriman
                                    </div>
                                    <div class="text-gray-900 font-medium">Rp{{ number_format($transaksi->biaya_pengiriman) }}</div>
                                </div>
                                <div class=" flex justify-between w-72 text-gray-500 mb-3">
                                    <div class="">
                                        Potongan
                                    </div>
                                    <div class="text-gray-900 font-medium">Rp{{ number_format($transaksi->diskon) }}</div>
                                </div>
                                <div class=" flex justify-between w-72 text-gray-900 mb-3">
                                    <div class="">
                                        Sub Total
                                    </div>
                                    <div class="text-gray-900 font-medium">Rp{{ number_format($transaksi->sub_total) }}</div>
                                </div>
                            </div>
                        </div>
                        @if ($transaksi->status === 'konfirmasi')
                            <div class="mt-6 flex justify-end">
                                <div data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="bg-primary px-4 py-3 rounded-xl inline-block text-white cursor-pointer">Konfirmasi Penerima</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div id="popup-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-md md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-6 text-center">
                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Beri penilaian </h3>

                        <div class="flex text-yellow-300">
                            <template x-for="item in 5">
                                <div class="">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                    </svg>

                                </div>
                            </template>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        </div>
                        <button data-modal-hide="popup-modal" type="button" class="text-white bg-primary hover:bg-opacity-90 focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Yes, I'm sure
                        </button>
                        <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('addScript')
    <script>
        function funcData(){
            return{

                init(){
                    console.log("Hello world");
                }
            }
        }
    </script>
@endpush
