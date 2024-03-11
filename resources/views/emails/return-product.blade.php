<p>Dear, {{ $user->name }} Your Return Product is Accepted, Product Amount ₹{{ $return->price }}.00/- will be
    trasfered to your bank account in
    24 hours</p>
<br>
<p>Order ID: {{ $return->id }}</p> <br>
<p>Product Name: {{ $return->product_name }}</p>
<br>
<p>Price: ₹{{ $return->price }}.00/-</p>
