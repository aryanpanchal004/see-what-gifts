{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mb-0 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dist/output.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body>


    {{-- <main>
        <form action="{{ route('password.email') }}" method="post"
            class="container flex flex-col justify-center w-full px-12 py-20 mx-auto my-16 bg-white md:w-1/2">

            @csrf


            <p class="text-2xl text-center md:text-3xl text-emerald-500">Forgot Password</p>

            @if (session('status'))
                <p class="mt-10 mb-4 text-sm font-semibold text-center md:text-base">We will email you a password reset
                    link
                    that
                    will
                    allow you to choose a new one.</p>
            @else
                <p class="mt-10 mb-4 text-sm font-semibold text-center md:text-base"> We sent link to your mail address
                    please reset your password</p>
            @endif


            <div class="flex flex-col items-center justify-center mb-4">
                <input placeholder="Your Email"
                    class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500 md:w-11/12"
                    type="email" name="email" value="{{ old('email') }}" required autofocus />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>



            <button type="submit"
                class="w-full m-auto btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 md:w-11/12">
                Send Password Reset Link
            </button>

        </form>
    </main> --}}
    
    <main class="p-5">
        <form action="{{ route('password.email') }}" method="post" class="w-[400px] mx-auto p-6 my-16">
            @csrf
            <h2 class="mb-5 text-2xl font-semibold text-center">
                Forgot Password
            </h2>

            @if (session('status'))
                <p class="mt-4 mb-4 text-sm font-semibold text-center md:text-base">  We have sent link to your mail address</p>
            @else
                <p class="mt-4 mb-4 text-sm font-semibold text-center md:text-base">We will email you a password reset link.</p>
            @endif
{{-- 
            <p class="mb-6 text-center text-gray-500">
                or
                <a href="{{ route('register') }}" class="text-sm text-purple-700 hover:text-purple-600">create new
                    account</a>
            </p> --}}

            <div class="mb-4">
                <input id="email" value="{{ old('email') }}" type="email" name="email"
                    placeholder="Your email address"
                    class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500"
                    type="email" name="email" value="{{ old('email') }}" required autofocus />
                @error('email')
                    <span class="text-gray-600 invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <button type="submit"
                class="w-full px-3 py-2 m-auto text-white rounded-sm bg-emerald-500 hover:bg-emerald-600 ">
                Send Password Reset Link
            </button>
            
        </form>
    </main>


    </div>
</body>

</html>


{{-- <div>
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required
    autofocus />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    
    <div class="flex items-center justify-end mt-4">
        <x-primary-button>
            {{ __('Email Password Reset Link') }}
        </x-primary-button>
    </div> --}}
