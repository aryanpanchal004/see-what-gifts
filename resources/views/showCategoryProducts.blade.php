<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('dist/output.css') }}" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- flowbite css --}}
    <title>Product Category Listing | N.M. Gift Store</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        <style>@import url('https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800&display=swap');

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
    </style>
</head>

<body>
    @include('partials.header')



    {{-- Products --}}
    @if (count($products) != 0)
        <h1 class="pt-4 text-3xl text-center text-blue-600 bg-white">Instruments in "{{ $catName }}" Category</h1>
        <div class="flex flex-wrap items-center justify-center gap-10 py-8 bg-white">
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
    @else
        <div class="flex items-center justify-center w-full h-full gap-10 bg-white">
            <img class="w-2/4" src={{ asset('static/images/no_product.jpg') }} alt="">
            <div class="flex flex-col gap-3">
                <p class="self-center text-3xl">No Product Found in this Category!</p>
                <a href="{{ route('welcome') }}" type="button"
                    class="font-medium text-indigo-600 hover:text-indigo-500">
                    Continue Shopping
                    <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>
        </div>
    @endif

    {{-- dynamic search --}}
    <div id="search-output" class="absolute left-0 right-0 top-20"></div>

    @include('partials.footer')


    <script src="javascript/navbar_logic.js"></script>
    <script src="javascript/search_logic.js"></script>
</body>

</html>
