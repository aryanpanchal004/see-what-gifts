<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('dist/output.css') }}" rel="stylesheet" />
    {{-- jquery --}}
    <title>Single product listing | N.M. Gifts & Fashion</title>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body>
    @include('partials.header')

    {{-- product --}}
    <section class="overflow-hidden text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-wrap mx-auto lg:w-4/5">
                <img alt="ecommerce" class="object-contain object-center rounded w-54 md:w-1/3 lg:h-auto"
                    src="{{ asset('storage/' . $product->image) }}">
                <div class="w-full mt-6 lg:w-1/2 lg:pl-10 lg:py-6 lg:mt-0">
                    <h1 class="mb-1 text-3xl font-medium text-gray-900 title-font">{{ $product->name }}</h1>
                    <p class="mt-3 leading-relaxed">{{ $product->desc }}</p>
                    <div class="flex items-center pb-5 mt-6 mb-5 border-b-2 border-gray-100">
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xl font-medium text-gray-900 title-font">₹ {{ $product->price }}.00</span>

                        @if (Auth::check())
                            @if ($product->inCart)
                                <form method="GET" action="/cart">
                                    <button
                                        class="px-4 py-2 text-white rounded-md bg-sky-500 hover:bg-sky-600">Checkout</button>
                                </form>
                            @else
                                <form method="POST" action="/addToCart">
                                    @csrf
                                    @method('post')
                                    <input type="hidden" name="product_id" value={{ $product->id }}>
                                    <button type="submit"
                                        class="flex px-6 py-2 mb-2 ml-auto text-white bg-blue-600 border-0 rounded text-md focus:outline-none hover:bg-blue-700">Add
                                        to cart</button>
                                </form>
                            @endif
                        @else
                            <form method="POST" action="/addToCart">
                                @csrf
                                @method('post')
                                <input type="hidden" name="product_id" value={{ $product->id }}>
                                <button type="submit"
                                    class="flex px-6 py-2 mb-2 ml-auto text-white bg-indigo-500 border-0 rounded text-md focus:outline-none hover:bg-indigo-600">Add
                                    to cart</button>
                            </form>
                        @endif

                    </div>

                    @if (Auth::check())
                        @if ($reviewAllowed)
                            <form action="/feedback" method="POST" class="flex flex-col justify-center mt-3"
                                id="rating-div">
                                @csrf
                                @method('post')
                                <input type="text" name="product_id" value={{ $product->id }} hidden>
                                <label for="feedback">Submit your review</label>
                                <textarea id="feedback" name="feedback"
                                    class="h-32 px-3 py-3 text-base leading-6 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none resize-none focus:border-indigo-500 focus:bg-yellow focus:ring-2 focus:ring-indigo-200"
                                    placeholder="write your review"></textarea>
                                @error('feedback')
                                    <p class="pt-1 pl-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <button id="feedbackBtn"
                                    class="flex px-6 py-2 mt-6 mb-2 ml-auto text-white bg-indigo-500 border-0 rounded text-md focus:outline-none hover:bg-indigo-600">Submit</button>
                            </form>
                        @endif
                    @endif
                </div>



                @if (count($reviews) != 0)
                    <div style="width:65vw;"
                        class="relative flex flex-col w-4/5 gap-4 px-4 py-2 mx-auto mt-8 border border-gray-600 right-10">
                        {{-- @foreach ($reviews as $review) --}}


                        <p class="text-2xl font-bold">Reviews</p>
                        @foreach ($reviews as $review)
                            <div class="px-3 py-2 border border-black rounded-md">
                                <div class="flex items-center gap-6 mt-2">
                                    <img class="w-14" src="{{ asset('images/profile_image.png') }}" alt="">
                                    <p class="text-xl font-semibold">{{ $review->userName }}</p>
                                </div>
                                <p class="text-lg">{{ $review->review }}</p>
                            </div>
                        @endforeach
                        {{-- @endforeach --}}
                    </div>
                @endif

            </div>
        </div>
    </section>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed px-20 py-5 text-white bg-blue-700 top-10 left-1/3">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    {{-- dynamic search --}}
    <div id="search-output" class="absolute left-0 right-0 top-20"></div>

    @include('partials.footer')
    <script src="{{ asset('javascript/navbar_logic.js') }}"></script>
    <script src="{{ asset('javascript/search_logic.js') }}"></script>
</body>

</html>
