<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    <link
      rel="icon"
      href="/images/logo.svg"
      sizes="32x32"
    />

    @stack('prepend-style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="/style/main.css" rel="stylesheet" />
    @stack('addStyle')

    <style>
        .main__dashboard{
            margin-top: 100px;
        }
    </style>
  </head>

  <body>
    <div class="page-dashboard">
      <div class="d-flex" id="wrapper" data-aos="fade-right">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
          <div class="sidebar-heading text-center">
            <img src="/images/dashboard-store-logo.svg" alt="" class="my-4" />
          </div>
          <div class="list-group list-group-flush">
            <a
              href=""
              class="list-group-item list-group-item-action active {{ (request()->is('dashboard')) ? 'active' : '' }}"
            >
              Dashboard
            </a>
            <a
              href=""
              class="list-group-item list-group-item-action {{ (request()->is('dashboard/products*')) ? 'active' : '' }}"
            >
              My Products
            </a>
            <a
              href=""
              class="list-group-item list-group-item-action {{ (request()->is('dashboard/transactions*')) ? 'active' : '' }}"
            >
              Transactions
            </a>
            <a
              href=""
              class="list-group-item list-group-item-action {{ (request()->is('dashboard/settings*')) ? 'active' : '' }}"
            >
              Store Settings
            </a>
            <a
              href=""
              class="list-group-item list-group-item-action {{ (request()->is('dashboard/account*')) ? 'active' : '' }}"
            >
              My Account
            </a>
            <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action">
              Sign Out
            </a>
            {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form> --}}
          </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
          <nav
            class="navbar navbar-expand-lg navbar-light navbar-store fixed-top"
            data-aos="fade-down"
          >
            <div class="container-fluid">
              <button
                class="btn btn-secondary d-md-none mr-auto mr-2"
                id="menu-toggle"
              >
                &laquo; Menu
              </button>
              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
              >
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Desktop Menu -->
                <ul class="navbar-nav d-none d-lg-flex ml-auto">
                  <li class="nav-item dropdown">
                    <a
                      href="#"
                      class="nav-link"
                      id="navbarDropdown"
                      role="button"
                      data-toggle="dropdown"
                    >
                      <img
                        src="/images/icon-user.png"
                        alt="Icon User"
                        class="rounded-circle mr-2 profile-picture"
                      />
                      Hi,
                    </a>
                    <div class="dropdown-menu">
                      <a href="" class="dropdown-item">Dashboard</a>
                      <a href="" class="dropdown-item"
                        >Settings</a
                      >
                      <div class="dropdown-divider"></div>
                      <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">Logout</a>
                      <form id="logout-form" action="" method="POST" style="display: none;">
                          @csrf
                      </form>
                    </div>
                  </li>
                 <li class="nav-item">
                    <a href="#" class="nav-link d-inline-block mt-2">
                        {{-- @php
                            $carts = \App\Cart::where('users_id', Auth::user()->id)->count();
                        @endphp --}}

                        {{-- @if ($carts > 0)
                            <img src="/images/icon-cart-filled.svg" alt="" />
                            <div class="card-badge">{{ $carts }}</div>
                        @else
                            <img src="/images/icon-cart-empty.svg" alt="" />
                            @endif --}}
                        <img src="/images/icon-cart-empty.svg" alt="" />
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
         <div class="section-content section-dashboard-home"
            data-aos="fade-up">
            <div class="container-fluid">
                <div class="dashboard-heading">
                    <h2 class="dashboard-title mb-5">@yield('title')</h2>
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
    <script>
      AOS.init();
    </script>
    <script>
      $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
      });
    </script>
    @stack('addScript')
  </body>
</html>
