<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ Auth::user()->name }}'s Cart | N.M. Fashion & Gifts</title>
    <x-includeFile />
</head>

<body>

    @if (count($products) != 0)

        <div class="flex flex-col h-full px-8 py-4 bg-white shadow-xl">
            <div class="flex-1 px-4 py-6 overflow-y-auto sm:px-6">
                <div class="flex items-start justify-between">
                    <h2 class="text-3xl font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                    <div class="flex items-center ml-3 h-7">
                        <button type="button" class="p-2 -m-2 text-gray-400 hover:text-gray-500">
                        </button>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flow-root">
                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                            </h1>
                            @foreach ($products as $product)
                                <li class="flex py-6">
                                    <div
                                        class="flex-shrink-0 w-24 h-24 overflow-hidden border border-gray-200 rounded-md">
                                        <img src="{{ asset("/storage/$product->image") }}"
                                            alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt."
                                            class="object-cover object-center w-full h-full">
                                    </div>

                                    <div class="flex flex-col flex-1 ml-4">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>
                                                    <a href="#">{{ $product->name }}</a>
                                                </h3>
                                                <p class="ml-4">₹{{ $product->price }}.00</p>
                                            </div>
                                            {{-- <p class="mt-1 text-sm text-gray-500">Salmon</p> --}}
                                        </div>
                                        <div class="flex items-end justify-between flex-1 text-sm">
                                            <div class="flex">
                                                <form method="POST" action="/cart/delete/{{ $product->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

            <div class="px-4 py-6 border-t border-gray-200 sm:px-6">
                <div class="flex justify-between text-base font-medium text-gray-900">
                    <p>Subtotal</p>
                    <p>₹{{ $total }}.00/-</p>
                </div>
                <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                <div class="mt-6">
                    <form method="POST" action="/address">
                        @csrf
                        @method('POST')
                        <input type="text" value="{{ $user_id }}" name="user_id" class="hidden">
                        <button href="#"
                            class="flex items-center justify-center w-full px-6 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">Checkout</button>
                    </form>
                </div>
                <div class="flex justify-center mt-6 text-sm text-center text-gray-500">
                    <p>
                        or
                        <a href="{{ route('welcome') }}" type="button"
                            class="font-medium text-indigo-600 hover:text-indigo-500">
                            Continue Shopping
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        </div>
    @else
        <div class="flex items-center justify-center w-full h-full gap-10 bg-white">
            <img class="w-2/4" src={{ asset('static/images/no_product.jpg') }} alt="">
            <div class="flex flex-col gap-3">
                <p class="self-center text-3xl">No Product Found in Cart!</p>
                <a href="{{ route('welcome') }}" type="button"
                    class="font-medium text-indigo-600 hover:text-indigo-500">
                    Continue Shopping
                    <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>
        </div>
    @endif

</body>

</html>
