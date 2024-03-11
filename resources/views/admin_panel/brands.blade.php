<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.slim.js"
        integrity="sha256-DKU1CmJ8kBuEwumaLuh9Tl/6ZB6jzGOBV/5YpNE2BWc=" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>

    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl px-4 mx-auto">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <div>
                            <!-- Website Logo -->
                            <p class="mt-4 text-lg font-semibold text-gray-500">N.M. Fashion & Gifts</p>
                        </div>
                    </div>
                    <!-- Primary Navbar items -->
                    <div class="items-center hidden space-x-1 md:flex">
                        <a href="/admin_panel"
                            class="px-2 py-4 font-semibold text-gray-500 transition duration-300 hover:text-blue-500">Products</a>
                        <a href="/admin_panel/categories"
                            class="px-2 py-4 font-semibold text-gray-500 transition duration-300 hover:text-blue-500">Category</a>
                        <a href="/admin_panel/orders"
                            class="px-2 py-4 font-semibold text-gray-500 transition duration-300 hover:text-blue-500">Orders</a>
                        <a href="/admin_panel/returns"
                            class="px-2 py-4 font-semibold text-gray-500 transition duration-300 hover:text-blue-500">Returns</a>
                    </div>
                </div>
                <!-- Secondary Navbar items -->
                <div class="items-center hidden space-x-3 md:flex ">
                    <a
                        class="px-2 py-2 font-medium text-white transition duration-300 bg-blue-700 rounded showTab hover:cursor-pointer hover:bg-blue-800 hover:text-white">Show</a>
                    <a
                        class="px-2 py-2 font-medium transition duration-300 rounded cursor-pointer insertTab hover:bg-blue-800 ">Insert</a>
                </div>
                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button class="outline-none mobile-menu-button">
                        <svg class="w-6 h-6 text-gray-500 hover:text-blue-500" x-show="!showMenu" fill="none"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- mobile menu -->
        <div class="hidden mobile-menu">
            <ul class="">
                <li class="active"><a href="index.html"
                        class="block px-2 py-4 text-sm font-semibold text-white bg-green-500">Products</a></li>
                <li><a href="#services"
                        class="block px-2 py-4 text-sm transition duration-300 hover:bg-green-500">Category</a></li>
                <li><a href="#about"
                        class="block px-2 py-4 text-sm transition duration-300 hover:bg-green-500">Brands</a></li>
                <li><a href="#contact"
                        class="block px-2 py-4 text-sm transition duration-300 hover:bg-green-500">Orders</a></li>
            </ul>
        </div>

    </nav>


    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed px-10 py-3 text-white bg-blue-700 top-24 left-1/3">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    {{-- insert a new product --}}
    <form id="insertProduct" action="/admin/brand/insert" method="POST" enctype="multipart/form-data" class="hidden">
        @csrf
        @method('post')
        <div class="block w-11/12 p-6 mx-auto mt-6 bg-white rounded-lg shadow-lg">
            <h1 class="mb-4 text-xl text-blue-700 uppercase">Insert new brand</h1>
            <div class="mb-6 form-group">
                <label for="product_name" class="inline-block mb-2 text-gray-700 form-label">Enter Brand Name</label>
                <input type="text"
                    class="form-control block
              w-1/3
              px-3
              py-1.5
              text-base
              font-normal
              text-gray-700
              bg-white bg-clip-padding
              border border-solid border-gray-300
              rounded
              transition
              ease-in-out
              m-0
              focus:text-gray-700 focus:bg-white focus:border-blue-700 focus:outline-none"
                    id="product_name" placeholder="Enter brand name here" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="pt-1 pl-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex mb-6 form-group">
                <div class="flex justify-center">
                    <div class="mb-3">
                        <label for="formFile" class="inline-block mb-2 text-gray-700 form-label">Select Brand
                            Logo</label>
                        <input
                            class="form-control
                  block
                  w-full
                  px-3
                  py-1.5
                  text-base
                  font-normal
                  text-gray-700
                  bg-white bg-clip-padding
                  border border-solid border-gray-300
                  rounded
                  transition
                  ease-in-out
                  m-0
                  focus:text-gray-700 focus:bg-white focus:border-blue-700 focus:outline-none"
                            type="file" id="formFile" name="image" ">
                  {{-- <img class="mt-4" src="{{ asset('storage/' . $brand->logo ) }}" alt="{{ $brand->name }}" style="height:40vh;"> --}}
                  @error('image')
    <p class="pt-1 pl-1 text-sm text-red-600">{{ $message }}</p>
@enderror
                </div>
              </div>
          </div>

          <button type="submit" class="
            w-full
            px-6
            py-2.5
            bg-blue-700
            text-white
            text-md
            font-bold
            leading-tight
            uppercase
            rounded
            shadow-md
            hover:bg-blue-700 hover:shadow-lg
            focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
            active:bg-blue-800 active:shadow-lg
            transition
            duration-150
            ease-in-out">Submit</button>
    </div>
    </form>

     {{-- show products table --}}
  <div id="showProduct" class="container mx-auto w-11\12 mt-4 rounded-lg">
    <div class="flex flex-col">
      <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
          <div class="overflow-hidden">
            <table class="min-w-full">
              <thead class="bg-white border-b">
                <tr>
                  <th scope="col" class="px-6 py-4 font-semibold text-center text-gray-900 text-md">
                    Name
                  </th>
                  <th scope="col" class="px-6 py-4 font-semibold text-center text-gray-900 text-md">
                    Logo
                  </th>
                  <th scope="col" class="px-6 py-4 font-semibold text-center text-gray-900 text-md">
                    Edit
                  </th>
                  <th scope="col" class="px-6 py-4 font-semibold text-center text-gray-900 text-md">
                    Delete
                  </th>
                </tr>
              </thead>
              <tbody>
                     @foreach ($brands as $brand)
                        <tr class="transition duration-300 ease-in-out bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap text-md">
                                {{ $brand->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap text-md">
                                <img class="mt-4" src="{{ asset('storage/' . $brand->logo) }}"
                                    alt="{{ $brand->name }}" style="height:40vh;margin:auto;">
                            </td>

                            <td class="px-6 py-4 text-gray-900 text-md whitespace-nowrap">
                                {{-- delete button --}}
                                <form action="/admin/brand/delete/{{ $brand->id }}" method="post">
                                    @csrf
                                    @method('post')
                                    <div class="flex justify-center space-x-2">
                                        <button
                                            class="inline-block px-6 py-2.5 bg-red-600 text-white text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Delete</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>



        <script>
            const btn = document.querySelector("button.mobile-menu-button");
            const menu = document.querySelector(".mobile-menu");

            btn.addEventListener("click", () => {
                menu.classList.toggle("hidden");
            });

            function removeAllActiveBtn() {
                $('.showTab').removeClass("bg-blue-700 text-white");
                $('.showTab').addClass("text-gray-500");
                $('.insertTab').removeClass("bg-blue-700 text-white");
                $('.insertTab').addClass("text-gray-500");
            }

            $(document).ready(function() {

                $(".insertTab").click(function(e) {
                    removeAllActiveBtn();

                    $(this).addClass('bg-blue-700');
                    $(this).addClass('text-white');

                    $("#showProduct").addClass("hidden");
                    $("#insertProduct").removeClass("hidden");
                });

                $(".showTab").click(function(e) {
                    removeAllActiveBtn();

                    $(this).addClass('bg-blue-700');
                    $(this).addClass('text-white');

                    $("#insertProduct").addClass("hidden");
                    $("#showProduct").removeClass("hidden");
                });

            });
        </script>
</body>

</html>
