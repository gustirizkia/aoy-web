{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun</title>
    <link href="/style/main.css" rel="stylesheet" />

    <style>
        .form__login {
            min-height: 100vh;
        }

        .form-control {
            background: #F4F4F4;
            /* border: unset; */
            padding: 25px 20px;
            border-radius: 80px;
            font-weight: 600;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e);
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .btn__primary {
            padding: 16px 20px;
            border-radius: 80px;
            font-weight: 500;
            background: #A349A3;
            color: white;
        }

        .btn__outline__primary {
            padding: 16px 20px;
            border-radius: 80px;
            font-weight: 500;
            border-color: #A349A3;
            color: #A349A3;
        }

        .btn__outline__primary:hover {
            background-color: #A349A3;
            color: white;
        }

        .shape__r {
            top: 0;
            /* height: 200px; */
            width: 466px;
            right: 0;
            top: 50%;
            /* left: 50%; */
            transform: translate(0%, -50%);
        }

        /* // Small devices (landscape phones, less than 768px) */
        @media (max-width: 767.98px) {
            .shape__r {
                display: none;
            }
        }


        label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center">
        </div>
        <form method="POST" action="{{ route('register') }}" class="form__login">
            @csrf
            <div class="row justify-content-center form__login align-items-center">
                <div class="col-md-6">
                    <div class="d-flex justify-content-center mb-2">
                        <img src="{{ asset('gambar/logo.png') }}" alt="AOY" class="img-fluid text-center"
                            style="width: 200px">
                    </div>
                    <h4 class="text-center mb-4" style="color: #5C5C5C">Buat akun </h4>

                    <!-- Email Address -->
                    <div>
                        <label for="email">Nama</label>
                        <input type="text" class="form-control w-full @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" placeholder="Nama lengkap" />
                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="email">Email</label>
                        <input type="text" class="form-control w-full @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Email " />
                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" autocomplete="current-password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                        @error('password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="password">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" autocomplete="current-password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Konfirmasi password">
                        @error('password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <button class="btn btn__primary mt-4 w-100 ">
                        Daftar/Register
                    </button>
                    <a href="/login" class="btn btn__outline__primary mt-3 w-100 ">
                        Login/Masuk
                    </a>
                </div>
            </div>

            <div class="position-absolute shape__r">
                <img src="{{ asset('gambar/shaepe-r.png') }}" alt="AysOnYou" class="img-fluid">
            </div>
        </form>
    </div>
</body>

</html>
