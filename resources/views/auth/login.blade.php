<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- link awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Link file CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/login.css') }}">
</head>
<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<body>
    <div class="contanier">

        <div class="text">

            <img src="{{ asset('frontend/assets/img/Logo.png') }}" alt="">
        </div>

        <div class="box-login">
            <div class="login">
                <div class="header">
                    <h2>Selamat Datang Kembali</h2>
                    <p>Mari mulai aktivitasmu kembali, selamat bekerja!</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="inp">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" required autocomplete="email"
                            oninvalid="this.setCustomValidity('Harap lengkapi username anda')"
                            oninput="this.setCustomValidity('')" placeholder="example@gmail.com"
                            value="{{ old('email') }}" />

                        
                    </div>

                    <!-- Password -->
                    <div class="inp">
                        <x-input-label for="password" :value="__('Password')" placeholder="Password Berisi 8 Karakter" />

                        <input id="password" class="block mt-1 w-full" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required
                            autocomplete="password"
                            oninvalid="this.setCustomValidity('Harap mengisi password terlebih dahulu')"
                            oninput="this.setCustomValidity('')" placeholder="Password Berisi 8 Karakter" />

                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <button class="btn btn-google btn-login text-uppercase fw-bold" id="afdnfbdsfui"
                                type="submit">
                                <i class="fab fa-google me-2"></i> Sign in with Google
                            </button>
                        @endif
                        <div class="inp"> @error('email')
                                <div class="invalid-feedback">
                                    {{ 'USERNAME ATAU PASSWORD YANG ANDA MASUKAN SALAH!' }}
                                </div>
                            @enderror
                        </div>

                        <x-primary-button class="ml-3">
                            {{ __('Masuk') }}
                        </x-primary-button>
                    </div>
                </form>

</html>
