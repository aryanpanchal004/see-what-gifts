<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Orders & Return Info</title>
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

<body class="py-5 mx-auto">



    @if (session('msg'))
        <div class="flex justify-between w-4/5 p-3 mx-auto mt-2 text-white bg-green-600 rounded shadow-inner">
            <p class="self-center">
                {{ session('msg') }}
            </p>
            <strong class="text-xl cursor-pointer align-center alert-del">&times;</strong>
        </div>
    @endif

    @if (count($orders) != 0 || count($returns) != 0)
        <h2 class="text-3xl text-blue-600">Your Past Orders</h2>
        <div class="container px-10">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Return Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
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
                                        <td>Not-Returnable</td>
                                    @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <h2 class="text-3xl text-blue-600">Your Return Orders</h2>
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
        </div>
    @else
        <div class="flex items-center justify-center w-full h-full gap-10 bg-white">
            <img class="w-2/4" src={{ asset('static/images/no_product.jpg') }} alt="">
            <div class="flex flex-col gap-3">
                <p class="self-center text-3xl">No Orders Found!</p>
                <a href="{{ route('welcome') }}" type="button"
                    class="font-medium text-indigo-600 hover:text-indigo-500">
                    Continue Shopping
                    <span aria-hidden="true"> &rarr;</span>
                </a>
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
