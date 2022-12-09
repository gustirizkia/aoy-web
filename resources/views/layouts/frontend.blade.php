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
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('addStyle')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,900&display=swap" rel="stylesheet">

</head>

<body class="font-popins bg-transaksi">
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
            <a href="" class="mx-10">Produk</a>
        </div>
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

    </nav>

    {{-- topbar mobile --}}
    <section class="md:hidden shadow p-2 flex items-center justify-between sticky top-0 bg-white z-40">
        <div class="relative w-64">
                <input type="text" id="search-dropdown" class="block p-2 w-full z-20 text-sm text-gray-900 bg-gray-50 pr-14 rounded-lg border border-gray-300 focus:ring-primary focus:border-primary placeholder-gray-400" placeholder="Cari barang " required>
                <div  class="absolute top-0 right-0 p-2 text-sm font-medium text-gray-400  rounded-r-lg border b  focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
        </div>

        <div class="text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
            </svg>

        </div>

        <div class="text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
        </div>
    </section>

    {{-- bottombar mobile --}}
    <section class="md:hidden shadow py-3 px-6 flex items-center justify-between fixed w-full border-t bottom-0 bg-white z-40 {{ (request()->is('keranjang')) ? 'hidden' : '' }}">
        <div class="text-primary text-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mx-auto">
            <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
            <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
            </svg>
            <div class="font-medium text-sm">
                Home
            </div>
        </div>
        <div class="text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-auto "><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <div class="font-medium text-sm">
                Explore
            </div>
        </div>
        <div class="text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-auto text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <div class="font-medium text-sm">
                Keranjang
            </div>
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
    @stack('addScript')
</body>
</html>
