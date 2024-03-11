<!DOCTYPE html>
<html lang="en">

<head>

    <title>Fill up your address || N.M. Gifts & Fashion</title>
    <x-includeFile />
</head>

<body>
    @include('partials.header')

    <main class="p-5">
        <div class="container mx-auto lg:w-2/3 xl:w-2/3">
            <h3 class="w-full py-4 mt-4 mb-4 text-4xl font-semibold leading-7 text-center text-blue-600">
                Order Summary</h3>
            <div class="mb-4 2xl:container 2xl:mx-auto">
                <div class="flex flex-col items-center justify-center space-y-10">
                    @foreach ($products as $product)
                        <div class="flex flex-col items-start justify-center w-full lg:w-9/12 xl:w-full">
                            <div class="flex flex-col items-center justify-center w-full mt-8 space-y-4">
                                <div
                                    class="flex items-start justify-start w-full border border-gray-200 md:flex-row md:items-center">
                                    <div class="w-40 -m-px md:w-32">
                                        <img class="hidden md:block" src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->desc }}" />
                                        <img class="md:hidden" src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->desc }}" />
                                    </div>
                                    <div
                                        class="flex flex-col items-start justify-start w-full p-4 md:justify-between md:items-center md:flex-row md:px-8">
                                        <div class="flex flex-col items-start justify-start md:flex-shrink-0">
                                            <h3
                                                class="text-lg font-semibold leading-6 text-gray-800 md:text-xl md:leading-5">
                                                {{ $product->name }}</h3>
                                            <div
                                                class="flex flex-row items-start justify-start mt-4 space-x-4 md:space-x-6">
                                                {{-- <p class="text-sm leading-none text-black">Size: <span class="text-gray-800 "> Small</span></p> --}}
                                                <p class="text-sm leading-none text-gray-600">Quantity: <span
                                                        class="text-gray-800 ">{{ $product->quantity }}</span></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center w-full mt-4 md:mt-0 md:justify-end">
                                            <p
                                                class="text-xl font-semibold leading-5 text-gray-800 lg:text-2xl lg:leading-6">
                                                ₹{{ $product->price }}.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-start justify-start w-full mt-8 space-y-10 xl:mt-10">
                                <div class="flex flex-col w-full space-y-4">
                                    <div class="flex items-center justify-between w-full">
                                        <p class="text-base font-semibold leading-4 text-gray-800">Total</p>
                                        <p class="text-base font-semibold leading-4 text-gray-600">
                                            ₹{{ $total }}.00/-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- dynamic search --}}
            <div id="search-output" class="absolute left-0 right-0 top-20"></div>


            <!-- Personal Details Address -->
            <form id="mainForm" onsubmit="return validateForm()" action="{{ route('checkout.online') }}"
                method="POST">
                @csrf
                @method('post')

                <div class="mb-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="my-2 text-xl font-semibold md:text-3xl">Personal Details</h2>

                    </div>

                    <div class="flex-1 mb-4">
                        <input placeholder="Enter your full name" type="text" id="full_name" name="full_name"
                            class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500"
                            required />

                    </div>
                    <div class="flex-1 mb-4">
                        <input placeholder="Enter your phone number" type="number" id="phone_number"
                            name="phone_number"
                            class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500"
                            required />
                        <!-- HTML markup -->
                        <div id="phone_err"
                            class="hidden bg-red-100 mt-3 text-red-600 py-2 px-4 border border-red-400 rounded">
                            <p>Enter Valid mobile number (mobile number must be atleast 10 digit)</p>
                        </div>

                    </div>

                </div>
                <!--/ personal details over -->

                <!-- Shipping Address -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="my-2 text-xl font-semibold md:text-3xl">Shipping Address</h2>

                    </div>

                    <div class="flex-1 mb-4">
                        <input placeholder="Address 1" type="text" name="shipping_address_1"
                            class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500"
                            required />
                    </div>
                    <div class="flex-1 mb-4">
                        <input placeholder="Address 2" type="text" name="shipping_address_2"
                            class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500"
                            required />
                    </div>

                    <div class="flex-1 mb-4">
                        <input placeholder="City" type="text" name="shipping_city"
                            class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500" />
                    </div>
                    <div class="flex-1 mb-4">
                        <input placeholder="State" type="text" name="shipping_state"
                            class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500"
                            required />
                    </div>


                    <div class="flex-1 mb-4">
                        <input placeholder="Zipcode" type="text" name="shipping_zipcode"
                            class="w-full border-gray-300 rounded-md focus:border-purple-500 focus:outline-none focus:ring-purple-500"
                            required />
                    </div>
                </div>
                <!--/ Shipping Address -->

                {{-- checkout method --}}
                <div class="flex gap-4 my-4">
                    <div class="form-check">
                        <input name="checkout-option"
                            class="float-left w-4 h-4 mt-1 mr-2 align-top transition duration-200 bg-white bg-center bg-no-repeat bg-contain border border-gray-300 rounded-full appearance-none cursor-pointer form-check-input checked:bg-blue-600 checked:border-blue-600 focus:outline-none"
                            type="radio" value="online" id="online" checked required>
                        <label class="inline-block text-gray-800 form-check-label" for="online">
                            Pay Online
                        </label>
                    </div>
                    <div class="form-check">
                        <input name="checkout-option"
                            class="float-left w-4 h-4 mt-1 mr-2 align-top transition duration-200 bg-white bg-center bg-no-repeat bg-contain border border-gray-300 rounded-full appearance-none cursor-pointer form-check-input checked:bg-blue-600 checked:border-blue-600 focus:outline-none"
                            type="radio" value="cod" id="cod" required>
                        <label class="inline-block text-gray-800 form-check-label" for="cod">
                            Cash On Delivery
                        </label>
                    </div>
                </div>

                <div id="online_btn">
                    <button
                        class="w-full mb-10 btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700">Continue
                        Payment</button>
                </div>

                <div id="cod_btn" class="hidden">
                    <button
                        class="w-full mb-10 btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700">Confirm
                        Order</button>
                </div>
        </div>
        </form>

        </div>
        </div>
    </main>
    <script>
        function validateForm() {
            const phone_number = $("#phone_number").val();
            var pattern = /^\d{10}$/;
            console.log(phone_number);
            if (!pattern.test(phone_number)) {
                $("#phone_err").css("display", "block");
                return false;
            } else {
                $("#phone_err").css("display", "none");
                return true;
            }
        }

        $(document).ready(function() {
            $(".form-check-input").change(function(e) {
                console.log(this.id);
                if (this.id === "cod") {
                    $("#online_btn").css('display', 'none');
                    $("#cod_btn").css('display', 'block');
                    $("#mainForm").attr("action", "{{ route('checkout.cod') }}")
                }

                if (this.id == 'online') {
                    $("#cod_btn").css("display", "none");
                    $("#online_btn").css("display", "block");
                    $("#mainForm").attr("action", "{{ route('checkout.online') }}")
                }
            });

        });
    </script>
    <script src="javascript/navbar_logic.js"></script>
    <script src="javascript/search_logic.js"></script>
</body>

</html>
