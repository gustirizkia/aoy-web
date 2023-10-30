<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login AOY</title>
    <link href="/style/main.css" rel="stylesheet" />

    <style>
        .form__login {
            height: 100vh;
        }

        .form-control {
            background: #F4F4F4;
            /* border: unset; */
            padding: 30px 20px;
            border-radius: 80px;
            font-weight: 600;
        }

        .btn__primary {
            padding: 16px 20px;
            border-radius: 80px;
            font-weight: 500;
            background: #A349A3;
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

        body {
            height: 100vh;
            overflow-y: hidden;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center">
        </div>
        <form method="POST" action="{{ route('login') }}" class="form__login">
            @csrf
            <div class="row justify-content-center form__login align-items-center">
                <div class="col-md-6">
                    <div class="d-flex justify-content-center mb-2">
                        <img src="{{ asset('gambar/logo.png') }}" alt="AOY" class="img-fluid text-center"
                            style="width: 200px">
                    </div>
                    <h6 class="text-center mb-4" style="color: #5C5C5C">Masukan akun anda untuk lanjut</h6>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $error === 'The selected username is invalid.' ? 'Username atau Email salah' : $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach
                    @endif
                    <!-- Email Address -->
                    <div>
                        <input type="text"
                            class="form-control w-full @error('username')
                            is-invalid
                        @enderror"
                            name="input_type" value="{{ old('input_type') }}" placeholder="Email atau ID" />
                    </div>
                    <div class="mt-3">
                        <input type="password" name="password" autocomplete="current-password" class="form-control"
                            placeholder="Password">
                    </div>
                    <button class="btn btn__primary mt-4 w-100 ">
                        Login/Masuk
                    </button>
                    <a href="/register" class="btn btn__outline__primary mt-3 w-100 ">
                        Daftar/Register
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
