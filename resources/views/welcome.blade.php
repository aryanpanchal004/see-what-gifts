<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('dist/output.css') }}" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Gift Store | Home Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}
    {{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> --}}
    <style>
        @import url('https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800&display=swap');

        .product-list {
            padding: 20px 10px 20px;
            font-family: 'Nunito Sans', sans-serif;
        }

        .product-list>ul {
            margin: 0 -10px;
            padding: 0;
            list-style: none;
            display: flex;
        }

        .product-list>ul>li {
            width: 25%;
            padding: 10px;
        }

        .white-box {
            border-radius: 5px;
            box-shadow: 0 0 3px 0 rgba(0, 0, 0, 0.4);
            background-color: #ffffff;
            padding: 35px 20px;
            transition: all 0.5s ease-in-out;
            position: relative;
        }

        .wishlist-icon {
            position: absolute;
            right: 12px;
            top: 10px;
        }

        .wishlist-icon img {
            width: 20px;
            height: 20px;
        }

        .product-img {
            min-height: 135px;
        }

        .product-img img {
            max-width: 100%;
            max-height: 130px;
            display: block;
            margin: 0 auto;
        }

        .product-bottom {
            text-align: center;
        }

        .product-name {
            font-size: 16px;
            color: #666;
            text-align: center;
            margin: 10px 0 10px;
            font-weight: 600;
            max-height: 48px;
            min-height: 48px;
            overflow: hidden;
        }

        .price {
            margin-top: 0;
            font-size: 18px;
            font-weight: 600;
            color: #000000;
            font-family: 'Open Sans', sans-serif;
        }

        .blue-btn {
            border-radius: 5px;
            color: #ffffff;
            font-weight: 700;
            border: none;
            padding: 0 15px;
            cursor: pointer;
            height: 30px;
            line-height: 30px;
            max-width: 132px;
            margin: 10px auto 0;
            display: block;
            text-align: center;
            text-decoration: none;
        }

        .price .line-through {
            font-size: 14px;
            color: #999999;
            font-weight: 400;
            vertical-align: 1px;
            display: inline-block;
            text-decoration: line-through;
            margin-left: 4px;
        }
    </style>


</head>

<body>
    @include('partials.header')


    @if (session('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('message') }}</p>
        </div>
    @endif


    <div class="container flex justify-center mx-auto">
        <img class="w-1/5 md:w-2/12" src="/images/warranty_banner/1.png" alt="">
        <img class="w-1/5 md:w-2/12" src="/images/warranty_banner/2.png" alt="">
        <img class="w-1/5 md:w-2/12" src="/images/warranty_banner/3.png" alt="">
        <img class="w-1/5 md:w-2/12" src="/images/warranty_banner/4.png" alt="">
        <img class="w-1/5 md:w-2/12" src="/images/warranty_banner/5.png" alt="">
    </div>

    {{-- <section class="text-gray-600 body-font"> --}}
    <div class="container flex flex-wrap px-4 py-4 mx-auto">
        <div class="flex flex-wrap -m-1 md:-m-2">
            <div class="flex flex-wrap w-1/2">
                <div class="w-1/2 p-1 md:p-2">
                    <img alt="gallery" class="block object-cover object-center w-full h-full"
                        src="images/gallery/1.jpg">
                </div>
                <div class="w-1/2 p-1 md:p-2">
                    <img alt="gallery" class="block object-cover object-center w-full h-full"
                        src="images/gallery/2.jpg">
                </div>
                <div class="w-full p-1 md:p-2">
                    <img alt="gallery" class="block object-cover object-center w-full h-full"
                        src="images/gallery/3.jpg">
                </div>
            </div>
            <div class="flex flex-wrap w-1/2">
                <div class="w-full p-1 md:p-2">
                    <img alt="gallery" class="block object-cover object-center w-full h-full"
                        src="images/gallery/4.jpg">
                </div>
                <div class="w-1/2 p-1 md:p-2">
                    <img alt="gallery" class="block object-cover object-center w-full h-full"
                        src="images/gallery/5.jpg">
                </div>
                <div class="w-1/2 p-1 md:p-2">
                    <img alt="gallery" class="block object-cover object-center w-full h-full"
                        src="images/gallery/6.jpg">
                </div>
            </div>
        </div>
    </div>

    <div class="container flex flex-col mx-auto">
        <div class="flex flex-col md:flex-row">
            <img class="items-center justify-center w-full px-4 py-2 md:w-1/2" src="images/landing_page/1.png"
                alt="">
            <img class="items-center justify-center w-full px-4 py-2 md:w-1/2" src="images/landing_page/2.jpg"
                alt="">
        </div>

        <div class="flex flex-col md:flex-row">
            <img class="items-center justify-center w-full px-4 py-2 md:w-1/2" src="images/landing_page/3.jpg"
                alt="">
            <img class="items-center justify-center w-full px-4 py-2 md:w-1/2" src="images/landing_page/4.jpg"
                alt="">
        </div>

        <div class="flex flex-col md:flex-row">
            <img class="items-center justify-center w-full px-4 py-2 md:w-1/2" src="images/landing_page/5.jpg"
                alt="">
            <img class="items-center justify-center w-full px-4 py-2 md:w-1/2" src="images/landing_page/6.jpg"
                alt="">
        </div>

    </div>


    {{-- best selling products --}}

    <div class="container px-4 mx-auto bg-white">
        <h2 class="pt-16 mt-10 mb-6 text-3xl font-semibold text-center">Gift-Shop Bestselling Products | Best Deal
            Gauranteed!
        </h2>
        <div class="flex flex-wrap items-center justify-center gap-10 py-6 bg-white">
            <div class="container">
                <div class="product-list">
                    <div class="grid grid-cols-4 row">
                        @foreach ($products as $product)
                            <div class="col-md-3 col-sm-6">
                                <div class="white-box">
                                    <div class="product-img">
                                        <img src={{ asset('storage/' . $product->image) }}>
                                    </div>
                                    <a href="/product/show/{{ $product->id }}" class="product-bottom">
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div class="price">
                                            <span class="rupee-icon">₹</span> {{ $product->price }}.00/-
                                        </div>
                                        @if (!$product->inCart)
                                            <form action="/addToCart" method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="product_id" value={{ $product->id }}>
                                                <button type="submit"
                                                    class="text-white bg-blue-600 hover:bg-blue-700 blue-btn">Add to
                                                    cart</button>
                                            </form>
                                        @else
                                            <a href="/cart"
                                                class="text-white bg-green-600 hover:bg-green-700 blue-btn">Checkout</a>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>


        </div>


        {{-- top categories --}}
        <h2 class="mt-10 mb-10 text-3xl font-semibold text-center">Top Categories</h2>
        <div class="container px-4 mx-auto bg-white">
            <div class="flex flex-wrap items-center justify-center py-10 bg-white">

                @foreach ($t_categories as $t_category)
                    <a href="/showAllProducts/{{ $t_category->id }}"
                        class="flex flex-col items-center justify-center">
                        <img class="px-4 py-4 w-72" src="{{ asset('storage/' . $t_category->image) }}"
                            alt="">
                        <p class="text-lg font-bold text-center">{{ $t_category->name }}</p>
                    </a>
                @endforeach

            </div>
        </div>

        {{-- dynamic search --}}
        <div id="search-output" class="absolute left-0 right-0 top-20"></div>

        <section class="text-gray-600  flex body-font relative">
            <img class="w-2/5 self-center" src="images/contact_us.jpg" alt="">

            <div class="container px-5 py-12 mx-auto">
                <div class="flex flex-col text-center w-full mb-4">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Contact Us</h1>
                </div>
                <form method="post" action="/contact_us_post" class="w-4/5 mx-auto">
                    @method('post')
                    @csrf
                    <div class="flex flex-wrap -m-2">
                        <div class="p-2 w-1/2">
                            <div class="relative">
                                <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                                <input type="text" id="name" name="name"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            @error('name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-2 w-1/2">
                            <div class="relative">
                                <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                                <input type="email" id="email" name="email"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            @error('email')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                                <textarea id="message" name="message"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                            </div>
                            @error('message')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-2 w-full">
                            <button
                                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>


        @include('partials.footer')




        <script src="javascript/navbar_logic.js"></script>
        <script src="javascript/search_logic.js"></script>
</body>

</html>
