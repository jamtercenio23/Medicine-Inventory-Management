@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-header text-center" style="border-bottom: none; margin-bottom: 0;">
                        <img src="{{ asset('images/logo.png') }}" alt="Mabini Health Center Logo"
                            style="max-width: 200px; margin-top: 20px; border-radius: 50%;">
                        <h2>{{ __('Mabini Health Center') }}</h2>
                    </div>

                    <div class="card-body">

                        @include('_message')

                        @if ($errors->has('email'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('email') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    <span class="input-group-text" id="password-toggle" style="cursor: pointer;">
                                        <i class="fa fa-eye-slash" id="password-icon" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                                    {{ __('Login') }}
                                </button>
                            </div>

                            <div class="mb-3 text-center">
                                <a href="/forgot-password" type="submit" class=" text-primary" style="width: 100%;">
                                Forgot Password
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>

        .card {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
        }

        .card-header {
            text-align: center;
            padding: 20px;
            border-bottom: none;
            margin-bottom: 0;
        }

        .card-header h2 {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 30px;
        }

        .card-header img {
            max-width: 200px;
            border-radius: 50%;
        }

        .card-body {
            border-radius: 10px;
            padding: 40px;
        }
    </style>


    <script>
        const passwordField = document.getElementById('password');
        const passwordToggle = document.getElementById('password-toggle');
        const passwordIcon = document.getElementById('password-icon');
        passwordField.type = 'password';
        passwordIcon.classList.add('fa-eye-slash');
        passwordToggle.addEventListener('click', () => {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            }
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

@endsection
