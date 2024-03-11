<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Orders | Admin Panel</title>
    <style>
        h2 {
            text-align: center;
            padding: 20px 0;
        }

        table caption {
            padding: .5em 0;
        }

        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
        }

        .p {
            text-align: center;
            padding-top: 140px;
            font-size: 14px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    @if (session('msg'))
        <div class="flex justify-between w-4/5 p-3 mx-auto mt-2 text-white bg-green-600 rounded shadow-inner">
            <p class="self-center">
                {{ session('msg') }}
            </p>
            <strong class="text-xl cursor-pointer align-center alert-del">&times;</strong>
        </div>
    @endif

    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl px-4 mx-auto">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <!-- Website Logo -->
                        <p class="mt-4 text-lg font-semibold text-gray-500">N.M. Fashion & Gifts</p>
                    </div>
                    <!-- Primary Navbar items -->
                    <div class="items-center hidden space-x-1 md:flex">
                        <a href="/admin_panel"
                            class="px-2 py-4 font-semibold text-gray-500 transition duration-300 hover:text-blue-500">Products</a>
                        <a href="/admin_panel/categories"
                            class="px-2 py-4 font-semibold text-gray-500 transition duration-300 hover:text-blue-500">Category</a>
                        <a href="/admin_panel/orders"
                            class="px-2 py-4 font-semibold text-blue-500 border-b-4 border-blue-500 ">Orders</a>
                        <a href="/admin_panel/returns"
                            class="px-2 py-4 font-semibold text-gray-500 transition duration-300 hover:text-blue-500">Returns</a>
                        <a href="/admin_logout"
                            class="px-2 py-2 font-medium transition duration-300 rounded cursor-pointer insertTab hover:bg-blue-800 hover:text-white ">Logout</a>
                    </div>
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

                <li><a href="#contact"
                        class="block px-2 py-4 text-sm transition duration-300 hover:bg-green-500">Orders</a></li>
            </ul>
        </div>

    </nav>

    @if (count($orders) != 0)
        <h2 class="text-3xl text-blue-600">Total Orders</h2>
        <div class="container px-10">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Customer Mail id</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Return Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->user->email }}</td>
                                    <td>{{ $order->product_name }}</td>
                                    <td>₹{{ $order->price }}.00/-</td>
                                    @php
                                        $dateString = $order->created_at;
                                        $date = strtotime($dateString);
                                        $formattedDate = date('d-m-Y', $date);
                                    @endphp
                                    <td>{{ $formattedDate }}</td>
                                    @if ($order->returnable)
                                        <td>
                                            <form action="/return/product" method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="order_id" value={{ $order->id }}>
                                                <button
                                                    class="px-4 py-2 text-white duration-300 bg-yellow-500 border-2 rounded hover:bg-yellow-600">Return
                                                    Product</button>
                                            </form>
                                        </td>
                                    @else
                                        <td>Non-Returnable</td>
                                    @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- <h2 class="text-3xl text-blue-600">Your Return Orders</h2>
        <div class="container px-10">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Return Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($returns as $return)
                                <tr>
                                    <td>{{ $return->product_name }}</td>
                                    <td>₹{{ $return->price }}.00/-</td>
                                    @php
                                        $dateString = $return->created_at;
                                        $date = strtotime($dateString);
                                        $formattedDate = date('d-m-Y', $date);
                                    @endphp
                                    <td>{{ $formattedDate }}</td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    @else
        <div class="flex items-center justify-center w-full h-full gap-10 bg-white">
            <img class="w-2/4" src={{ asset('static/images/no_product.jpg') }} alt="">
            <div class="flex flex-col gap-3">
                <p class="self-center text-3xl">No Orders found!</p>
            </div>
        </div>
    @endif

    <script>
        $('table').DataTable();

        var alert_del = document.querySelectorAll('.alert-del');
        alert_del.forEach((x) =>
            x.addEventListener('click', function() {
                x.parentElement.classList.add('hidden');
            })
        );
    </script>
</body>

</html>
