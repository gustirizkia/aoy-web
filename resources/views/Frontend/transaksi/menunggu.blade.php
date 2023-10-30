@extends('layouts.frontend')

@section('title')
    Menunggu Pembayaran
@endsection

@section('content')
    <div class="md:px-32 px-6 md:mt-8 mt-6">
        <div class="md:px-20">
            <div class="grid grid-flow-row grid-cols-12 gap-6">
                <div class="col-span-6 hidden md:flex justify-center items-center">
                    <img src="{{ asset('gambar/detail-transaksi.png') }}" class="w-1/2" alt="">
                </div>
                <div class="md:col-span-6 col-span-12">
                    <div class="bg-white p-6 rounded-lg text-gray-800">
                        <div class="md:flex justify-between items-center">
                            <div class="font-bold text-lg">
                                Batas akhir pembayaran
                            </div>
                            <div class="text-red-600 text-sm font-medium">
                                {{ \Carbon\Carbon::createFromTimestamp($item->expired_time)->formatLocalized('%d %B %Y') }} {{ \Carbon\Carbon::createFromTimestamp($item->expired_time)->format('H:i') }} WIB
                            </div>
                        </div>

                        <div class="text-lg mt-4">
                            Rincian pembayaran
                        </div>

                        <div class=" mt-6">
                            {{-- <img src="{{ $item-> }}" alt="" class=""> --}}
                            <div class="text-gray-500 text-sm">
                                No Invoice
                            </div>
                            <div class="font-semibold">
                                {{ $transaksi->no_inv }}
                            </div>
                        </div>
                        <div class=" mt-6">
                            {{-- <img src="{{ $item-> }}" alt="" class=""> --}}
                            <div class="text-gray-500 text-sm">
                                Metode pembayaran
                            </div>
                            <div class="font-semibold">
                                {{ $item->payment_name }}
                            </div>
                        </div>

                        <div class="md:flex justify-between text-sm">
                            <div class="mt-8">
                                <div class="text-gray-500">
                                    @if ($item->payment_method === 'ALFAMART')
                                        Kode Bayar
                                    @endif

                                    @if ($item->payment_method !== 'ALFAMART' && $item->payment_method !== 'QRIS')
                                        Nomor Virtual Account
                                    @endif

                                    @if ($item->payment_method === 'QRIS')
                                        Klik untuk memperbesar kode QR
                                    @endif
                                </div>
                                @if ($item->payment_method === 'QRIS')
                                    <img src="{{ $item->qr_url }}" alt="" class="w-32">
                                @endif
                                @if ($item->payment_method !== 'QRIS')
                                    <div class="flex mt-2">
                                        <div class="font-medium">
                                            {{ $item->pay_code }}
                                        </div>
                                        <div class="text-primary font-semibold ml-2 salin_va" style="cursor: pointer">
                                            Salin
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-8">
                                <div class="text-gray-500">
                                    Total pembayaran
                                </div>

                                <div class="flex mt-2">
                                    <div class="font-medium">
                                        Rp{{ number_format($item->amount) }}
                                    </div>
                                    <div class="">
                                        <a href="{{ route('transaksi-detail') }}?inv={{ request()->inv }}">
                                            <div class="text-primary font-semibold ml-2">
                                                Lihat rincian
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="bg-white p-6 rounded-lg text-gray-800 mt-6">

                        @if ($item->payment_method === 'ALFAMART')
                              <div class="text-lg font-medium mb-3">
                                Cara {{ $item->instructions[0]->title }}
                              </div>
                              <ol>
                                  @foreach ($item->instructions[0]->steps as $index => $itemAlfa)
                                    <li class="">
                                       {{ $index+1 }}. {!! $itemAlfa !!}
                                    </li>
                                  @endforeach
                              </ol>
                        @endif

                        @if ($item->payment_method !== 'ALFAMART')
                            <div class="text-lg font-medium mb-3">
                                Cara Pembayaran
                              </div>
                            <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">

                            @foreach ($item->instructions as $index => $itemI)
                                <h2 id="accordion-flush-heading-{{ $index+1 }}">
                                    <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-{{ $index+1 }}" aria-expanded="true" aria-controls="accordion-flush-body-1">
                                    <span>{{ $itemI->title }}</span>
                                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </h2>
                                <div id="accordion-flush-body-{{ $index+1 }}" class="hidden" aria-labelledby="accordion-flush-heading-{{ $index+1 }}">
                                    <div class="py-5 font-light border-b border-gray-200 dark:border-gray-700">
                                        @foreach ($itemI->steps as $stepIndex => $step)
                                            <div class="grid grid-flow-row grid-cols-12 gap-3 text-black">
                                                <div class="col-span-1 text-center">
                                                {{ $stepIndex+1 }}.
                                                </div>
                                                <div class="col-span-11">
                                                    {!! $step !!}
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addScript')
    <script>
        let text = "{{ $item->pay_code }}";
        $(".salin_va").on("click", function(){
            navigator.clipboard.writeText(text);
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-center',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Berhasil salin'
            })
        })
    </script>
@endpush
