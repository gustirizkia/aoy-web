<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login AOY</title>
    <link href="/style/main.css" rel="stylesheet" />

    <style>
        .form__login{
            height: 100vh;
        }
        .form-control{
            background: #F4F4F4;
            border: unset;
            padding: 30px 20px;
            border-radius: 80px;
            font-weight: 600;
        }
        .btn__primary{
            padding: 16px 20px;
            border-radius: 80px;
            font-weight: 500;
        }
        .shape__r{
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
            .shape__r{
                display: none;
            }
         }

        body{
                height: 100vh;
                overflow-y: hidden;
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
                        <img src="{{ asset('gambar/logo.png') }}" alt="AOY" class="img-fluid text-center" style="width: 200px">
                    </div>
                    <h6 class="text-center mb-4" style="color: #5C5C5C">Masukan akun anda untuk lanjut</h6>
                    @if ($errors->any())
                        <div class="alert alert-danger my-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Email Address -->
                    <div>
                        <input type="text" class="form-control w-full" name="username" value="{{ old('username') }}"  placeholder="Email atau ID" />
                    </div>
                    <div class="mt-3">
                        <input type="password"
                                name="password"
                                 autocomplete="current-password" class="form-control" placeholder="Password">
                    </div>
                    <button class="btn btn__primary mt-4 w-100 ">
                        Login
                    </button>
                </div>
            </div>

            <div class="position-absolute shape__r">
                <img src="{{ asset('gambar/shaepe-r.png') }}" alt="AysOnYou" class="img-fluid">
            </div>
        </form>
    </div>
</body>
</html>

