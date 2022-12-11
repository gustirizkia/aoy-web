<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    {{-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" /> --}}
    <link href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>

    @stack('addStyle')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,900&display=swap" rel="stylesheet">

</head>

<body class="font-popins  {{ (request()->is('transaksi*')) ? 'bg-transaksi' : '' }}">
    <nav class="md:flex justify-between py-3 px-4 md:px-32 items-center shadow hidden sticky top-0 bg-white z-30">
        <div class="w-20">
            <a href="/">
                <img src="{{ asset('gambar/logo.png') }}" alt="">
            </a>
        </div>
        {{-- Menu --}}
        <div class="text-gray-700 font-medium">
            <a href="{{ route('produk') }}" class="mx-10">Produk</a>
            <a href="" class="mx-10">Tentang</a>
            <a href="" class="mx-10">Media</a>
            <a href="" class="mx-10">Kontak</a>
        </div>
        @if (Auth::user())
            {{-- search --}}
            <div class="flex items-center">
                <div class="relative w-64">
                    <input type="text" id="search-dropdown" class="block p-2 w-full z-20 text-sm text-gray-900 bg-gray-50 pr-14 rounded-lg border border-gray-300 focus:ring-primary focus:border-primary placeholder-gray-400" placeholder="Cari barang " required>
                    <div  class="absolute top-0 right-0 p-2 text-sm font-medium text-white bg-primary rounded-r-lg border border-primary hover:bg-purple-300 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <div class="mx-5 relative">
                    @php
                       $countCart = \App\Models\Cart::where('user_id', Auth::user()->id)->count();
                    @endphp
                    <a href="{{ route('keranjang') }}">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 14.8052V10.0134H21.0326L14.0085 3.52308C14.0873 3.30075 14.1307 3.06174 14.1307 2.81266C14.1307 1.6378 13.1749 0.681976 12 0.681976C10.8251 0.681976 9.86932 1.6378 9.86932 2.81266C9.86932 3.06171 9.91267 3.30075 9.99155 3.52308L2.96739 10.0134H0V14.8052H0.838911L3.75375 23.3181H20.2462L23.161 14.8052H24V14.8052ZM15.903 17.3536H12.8412V14.8284H16.1524L15.903 17.3536ZM11.1588 21.6356H8.5198L8.2631 19.0361H11.1588V21.6356ZM8.09698 17.3536L7.84763 14.8284H11.1588V17.3536H8.09698ZM12.4482 2.81266C12.4482 2.94258 12.3923 3.05941 12.3037 3.14133C12.2238 3.21526 12.1172 3.26086 12 3.26086C11.8828 3.26086 11.7763 3.21526 11.6963 3.14133C11.6077 3.05939 11.5518 2.94258 11.5518 2.81266C11.5518 2.68274 11.6077 2.5659 11.6963 2.48398C11.7762 2.41005 11.8828 2.36445 12 2.36445C12.1172 2.36445 12.2237 2.41005 12.3037 2.48398C12.3923 2.56593 12.4482 2.68274 12.4482 2.81266ZM11.1336 4.75854C11.3985 4.87695 11.6916 4.94336 12 4.94336C12.3084 4.94336 12.6015 4.87695 12.8664 4.75854L18.5535 10.0134H5.44657L11.1336 4.75854ZM1.68247 11.6959H22.3175V13.1227H1.68247V11.6959ZM6.15699 14.8284L6.40634 17.3536H3.4899L2.62525 14.8284H6.15699ZM4.95605 21.6356L4.06597 19.0361H6.57249L6.82916 21.6356H4.95605ZM12.8412 19.0361H15.7369L15.4802 21.6356H12.8412V19.0361ZM19.044 21.6356H17.1708L17.4275 19.0361H19.934L19.044 21.6356ZM20.5101 17.3536H17.5937L17.843 14.8284H21.3748L20.5101 17.3536Z"
                                fill="#A349A3" />
                        </svg>
                        @if ($countCart > 0)
                            <span class="absolute top-0 -right-2 bg-gray-800 px-2 py-1 rounded-full text-xs text-white leading-none">{{ $countCart }}</span>
                        @endif
                    </a>
                </div>
                <a href="/login" class=" text-gray-600 rounded-lg ">{{ Auth::user()->name }}</a>
            </div>

        @else
            {{-- search --}}
            <div class="flex">
                <div class="relative w-64">
                    <input type="text" id="search-dropdown" class="block p-2 w-full z-20 text-sm text-gray-900 bg-gray-50 pr-14 rounded-lg border border-gray-300 focus:ring-primary focus:border-primary placeholder-gray-400" placeholder="Cari barang " required>
                    <div  class="absolute top-0 right-0 p-2 text-sm font-medium text-white bg-primary rounded-r-lg border border-primary hover:bg-purple-300 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <a href="/login" class="bg-primary py-2 px-3 text-white rounded-lg ml-6">Masuk</a>
            </div>
        @endif

    </nav>

    {{-- topbar mobile --}}
    @include('includes.front.topbar')


    {{-- bottombar mobile --}}
    <section class="md:hidden shadow py-3 px-6 flex items-center justify-between fixed w-full border-t bottom-0 bg-white z-40 {{ (request()->is('keranjang')) ? 'hidden' : '' }}">
        <div class="{{ (request()->is('/')) ? 'text-primary' : 'text-gray-600' }} text-center">
            <a href="/">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mx-auto">
                <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                </svg>
                <div class="font-medium text-sm">
                    Home
                </div>
            </a>
        </div>
        <div class=" {{ (request()->is('produk*')) ? 'text-primary' : 'text-gray-600' }}">
            <a href="{{ route('produk') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-auto "><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <div class="font-medium text-sm">
                    Explore
                </div>
            </a>
        </div>
        <div class="text-gray-600">
            <a href="{{ route('keranjang') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-auto text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <div class="font-medium text-sm">
                    Keranjang
                </div>
            </a>
        </div>
        <div class="text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-auto text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <div class="font-medium text-sm">
                Profile
            </div>
        </div>
    </section>


    <div class="min-h-screen">
        @yield('content')
    </div>

    <footer class="border-t-2 mt-12 md:mt-44 md:px-32 px-6 py-8 bg-white">
        <div class="md:flex justify-between">
            <div class="">
                <img src="{{ asset('gambar/logo.png') }}" alt="AOY" class="w-32">
                <div class="text-gray-400 mt-4">
                    merasa
                    nyaman di <br>
                    kulit mulus
                </div>
            </div>
            <div class="py-6">
                <div class="font-bold text-gray-700 text-lg">
                    For Beginners
                </div>
                <div class="text-gray-400 text-lg my-2">
                    <a href="">
                        Akun Baru
                    </a>
                </div>
                <div class="text-gray-400 text-lg my-2">
                    <a href="">
                        Cara Pembayaran
                    </a>
                </div>
            </div>
            <div class="py-6">
                <div class="font-bold text-gray-700 text-lg">
                    Explore Us
                </div>
                <div class="text-gray-400 text-lg my-2">
                    <a href="">
                        Career
                    </a>
                </div>
                <div class="text-gray-400 text-lg my-2">
                    <a href="">
                        Privacy
                    </a>
                </div>
                <div class="text-gray-400 text-lg my-2">
                    <a href="">
                        Syarat & Ketentuan
                    </a>
                </div>
            </div>
            <div class="py-6">
                <div class="font-bold text-gray-700 text-lg">
                    Connect Us
                </div>
                <div class="text-gray-400 text-lg my-2">
                    <a href="">
                        support@aysonyou.com
                    </a>
                </div>
                <div class="text-gray-400 text-lg my-2">
                    <a href="">
                        021 - 2208 - 1996
                    </a>
                </div>
                <div class="text-gray-400 text-lg my-2">
                    <a href="">
                        BSD, Tangerang Selatan, Banten
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    @stack('addScript')
</body>
</html>
