<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    @php
        $storeImage = \DB::table('members')
            ->where('user_uuid', auth()->user()->uuid)
            ->first();
    @endphp

    @if ($storeImage)
        <link rel="icon" href="{{ url('storage/' . $storeImage->image) }}" sizes="32x32" />
    @else
        <link rel="icon" href="{{ asset('gambar/no-image.png') }}" sizes="32x32" />
    @endif


    @stack('prepend-style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="/style/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('style/layout.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('addStyle')

    <style>
        .main__dashboard {
            margin-top: 100px;
        }

        .sidebar-heading .image__store {
            width: 132px;
            border-radius: 4px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        label {
            font-weight: 500;
            font-size: 16px;
            color: #0C0D36;
        }

        .form-control {
            font-weight: 400;
            font-size: 16px;
            color: #0C0D36;
        }

        .profile-picture-topbar {
            border-radius: 50%;
            width: 45px;
            height: 45px;
            object-fit: cover;
        }

        .page-dashboard .list-group-item.active {
            background: linear-gradient(270deg, rgba(242, 88, 255, 0.32) 2%, rgba(255, 255, 255, 0) 100%);
            ;
            border-right: 4px solid #A349A3;
            color: #0c0d36;
        }

        @media (min-width: 576px) and (max-width: 767.98px) {
            .page-dashboard .section-content {
                margin-top: 60px;
            }
         }
    </style>
</head>

<body>
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper" data-aos="fade-right">
            <!-- Sidebar -->
            <div class="border-right" id="sidebar-wrapper">
                <div class="sidebar-heading text-center">

                    @if ($storeImage)
                        <img src="{{ url('storage/' . $storeImage->image) }}" alt=""
                            class="my-4 image__store" />
                    @else
                        <img src="{{ asset('gambar/no-image.png') }}" alt="" class="my-4 image__store" />
                    @endif
                    <h4 class="text__primary">
                        {{ \App\Models\Level::where('id', auth()->user()->id)->first() ? \App\Models\Level::where('id', auth()->user()->id)->first()->nama : '' }}
                    </h4>
                </div>
                <div class="list-group list-group-flush">
                    <a href="/dashboard"
                        class="list-group-item list-group-item-action  {{ request()->is('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    @if (auth()->user()->level)
                        <a href="{{ route('store-setting') }}"
                            class="list-group-item list-group-item-action {{ request()->is('dashboard/store*') ? 'active' : '' }}">
                            Pengaturan Toko
                        </a>
                        <a href="{{ route('produk-saya') }}"
                            class="list-group-item list-group-item-action {{ request()->is('dashboard/produk*') ? 'active' : '' }}">
                            Produk Saya
                        </a>
                    @endif
                    <a href="{{ route('dashboard-transaksi') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/transaksi*') ? 'active' : '' }}">
                        Transaksi
                    </a>
                    <a href="{{ route('akun-saya') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/akun-saya*') ? 'active' : '' }}">
                        Akun Saya
                    </a>
                    <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="list-group-item list-group-item-action">
                        Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down">
                    <div class="container-fluid">
                        <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">
                            &laquo; Menu
                        </button>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Desktop Menu -->
                            <ul class="navbar-nav d-none d-lg-flex ml-auto">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link" id="navbarDropdown" role="button"
                                        data-toggle="dropdown">
                                        <img src="{{ Auth::user()->photo ? url('storage/' . Auth::user()->photo) : asset('gambar/user.png') }}"
                                            alt="Icon User" class=" mr-2 profile-picture profile-picture-topbar" />
                                        Hi, {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-divider"></div>
                                        <a href=""
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="dropdown-item">Logout</a>
                                        <form id="logout-form" action="" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('keranjang') }}" class="nav-link d-inline-block mt-2">
                                        @php
                                            $carts = \App\Models\Cart::where('user_id', Auth::user()->id)->sum('qty');
                                        @endphp

                                        @if ($carts > 0)
                                            <img src="/images/icon-cart-filled.svg" alt="" />
                                            <div class="card-badge">{{ $carts }}</div>
                                        @else
                                            <img src="/images/icon-cart-empty.svg" alt="" />
                                        @endif
                                    </a>
                                </li>
                            </ul>

                            <!-- Mobile Menu -->
                            <ul class="navbar-nav d-block d-lg-none">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Hi,
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link d-inline-block">
                                        Cart
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                {{-- Content --}}
                <div class="section-content section-dashboard-home" data-aos="fade-up">
                    <div class="container-fluid">
                        <div class="dashboard-heading">
                            <h2 class="dashboard-title mb-md-5 mb-2">@yield('title')</h2>
                        </div>
                        <div class="dashboard-content">
                            @yield('content')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.slim.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init();
    </script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    @stack('addScript')

    @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ Session::get('success') }}"
            })
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ Session::get('error') }}"
            })
        </script>
    @endif
    @if (Session::has('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Info!',
                text: "{{ Session::get('info') }}"
            })
        </script>
    @endif
</body>

</html>
