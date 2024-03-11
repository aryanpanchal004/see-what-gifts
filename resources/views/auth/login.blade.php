{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0 row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
{{-- <!DOCTYPE html>
<html> --}}

{{-- 
    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0 row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
    --}}

{{-- <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dist/output.css" rel="stylesheet" />
</head>

<body>


    <main class="p-5">
        <form action="{{ route('login') }}" method="POST" class="w-[400px] mx-auto p-6 my-16">
            @csrf
            <h2 class="mb-5 text-2xl font-semibold text-center">
                Login to your account
            </h2>
            <p class="mb-6 text-center text-gray-500">
                or
                <a href="{{ route('register') }}" class="text-sm text-purple-700 hover:text-purple-600">create new
                    account</a>
            </p>

            <div class="mb-4">
                <input id="email" value="{{ old('email') }}" type="email" name="email"
                    placeholder="Your email address"
                    class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500"
                    autofocus />
                @error('email')
                    <span class="text-gray-600 invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="mb-4">
                <input id="loginPassword" type="password" name="password" placeholder="Your password"
                    class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500" />
                @error('password')
                    <span class="text-gray-600 invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>



            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="mr-3 text-purple-500 border-gray-300 rounded focus:ring-purple-500"
                        {{ old('remember') ? 'checked' : '' }} />
                    <label for="remember">Remember Me</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-sm text-purple-700 hover:text-purple-600">Forgot
                    Password?</a>
            </div>

            <button class="w-full btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700">
                Login
            </button>
        </form>
    </main>
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Gift Store</title>
    <link href="{{ asset('dist/output.css') }}" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <h1 class="absolute left-0 right-0 text-5xl text-center text-indigo-600 top-10">Login Page</h1>
    <form class="mt-10" action="{{ route('login') }}" method="POST">
        @csrf
        <section class="h-screen text-sm">
            <div class="h-full px-6 text-gray-800">
                <div class="flex flex-wrap items-center justify-center h-full xl:justify-center lg:justify-between g-6">
                    <div class="mb-12 grow-0 shrink-1 md:shrink-0 basis-auto xl:w-6/12 lg:w-6/12 md:w-9/12 md:mb-0">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                            class="w-full" alt="Sample image" />
                    </div>
                    <div class="mb-12 xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 md:mb-0">
                        <!-- Email input -->
                        <div class="mb-6">
                            <input placeholder="Email Address"
                                class="block w-full px-4 py-2 m-0 font-normal text-gray-700 transition ease-in-out bg-white border border-gray-300 border-solid rounded text-md form-control bg-clip-padding focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="email" value="{{ old('email') }}" type="email" name="email" />
                            @error('email')
                                <span class="text-gray-600 invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password input -->
                        <div class="mb-6">
                            <input type="password"
                                class="block w-full px-4 py-2 m-0 font-normal text-gray-700 transition ease-in-out bg-white border border-gray-300 border-solid rounded text-md form-control bg-clip-padding focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="loginPassword" type="password" name="password" placeholder="Your password" />
                            @error('password')
                                <span class="text-gray-600 invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mb-6">
                            <div class="form-group form-check">
                                <input type="checkbox"
                                    class="float-left w-4 h-4 mt-1 mr-2 align-top transition duration-200 bg-white bg-center bg-no-repeat bg-contain border border-gray-300 rounded-sm appearance-none cursor-pointer form-check-input checked:bg-blue-600 checked:border-blue-600 focus:outline-none"
                                    id="remeber_me" {{ old('remember') ? 'checked' : '' }} />
                                <label class="inline-block text-gray-800 form-check-label" for="exampleCheck2">Remember
                                    me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-gray-800">Forgot password?</a>
                        </div>

                        <div class="text-center lg:text-left">
                            <button type="submit"
                                class="inline-block py-3 text-sm font-medium leading-snug text-white uppercase transition duration-150 ease-in-out bg-blue-600 rounded shadow-md px-7 hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg">
                                Login
                            </button>
                            <p class="pt-1 mt-2 mb-0 text-sm font-semibold">
                                Don't have an account?
                                <a href="{{ route('register') }}"
                                    class="text-red-600 transition duration-200 ease-in-out hover:text-red-700 focus:text-red-700">Register</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</body>

</html>
