<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('dist/output.css') }}" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="w-11/12 m-auto mt-20 md:w-1/2">

            {{-- heading --}}
            <p class="mb-6 text-2xl md:text-3xl text-emerald-500">Reset your password</p>

            <div class="flex flex-col">
                <label for="email" class="pb-4">Email</label>
                {{-- <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email', $request->email)"
                    required autofocus /> --}}
                <input placeholder="Your Email"
                    class="w-full mt-2 border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500 md:w-11/12"
                    name="email" id="email" type="email" name="email" value="{{ old('email') }}" required
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="flex flex-col mt-4">
                {{-- <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required /> --}}
                <label for="password" class="pb-4">Password</label>
                <input placeholder="Enter your new password"
                    class="w-full mt-2 border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500 md:w-11/12"
                    id="password" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="flex flex-col mt-4">
                {{-- <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block w-full mt-1" type="password"
                    name="password_confirmation" required /> --}}

                <label for="password_confirmation" class="pb-4">Repeat your password</label>
                <input placeholder="Enter your password again"
                    class="w-full mt-2 border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500 md:w-11/12"
                    id="password_confirmation" type="password" name="password_confirmation" required />
                {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                <div class="flex justify-end w-full md:w-11/12 ">
                    <button type="submit"
                        class="mt-6 w-fit btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700">
                        Reset Password
                    </button>
                </div>
            </div>

            {{-- button --}}
            <div class="flex justify-end w-full mt-4">

            </div>

        </div>



    </form>
</body>

</html>
