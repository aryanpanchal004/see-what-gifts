<?php

namespace App\Http\Controllers;

use id;
use Error;
use Stripe;
use Session;
use Exception;
use App\Exceptions;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderConfirmationMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\Debugbar\Facades\Debugbar;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PaymentController extends Controller
{

    public function cod(Request $request)
    {

        $user_id = Auth::id();
        $productsInCart = DB::table('cart_items')->where('user_id', $user_id)->get();
        $products = [];

        foreach ($productsInCart as $product) {
            $product_id = $product->product_id;
            $realProduct = DB::table('products')->where('id', $product_id)->first();
            $realProduct->quantity = 1;
            array_push($products, $realProduct);
        }

        $name = $request->get('full_name');
        $phone_number = $request->get('phone_number');
        $shipping1 = $request->get('shipping_address_1');
        $shipping2 = $request->get('shipping_address_2');
        $state = $request->get('shipping_state');
        $shippingCity = $request->get('shipping_city');
        $zipcode = $request->get('shipping_zipcode');

        foreach ($products as $product) {
            // order table details
            $order = Order::create(
                [
                    'user_id' => $user_id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'payment_type' => 'cod',
                    'status' => 'paid',
                ]
            );
            $user = User::where('id', $order->user_id)->first();
            Mail::to($request->user()->email)->send(new OrderConfirmationMail($order, $user));
        }
        // // order table details
        // $order = Order::create(
        //     [
        //         'id' => $order_id,
        //         'user_id' => $user_id,
        //         'total_price' => $totalAmount,
        //         'status' => 'cod'
        //     ]
        // );
        // $order->save();
        $orders = Order::latest()->take(count($productsInCart))->get();

        // shipping table details

        foreach ($orders as $order) {

            DB::table('shipping_data')->insert(
                [
                    'order_id' => $order->id,
                    'full_name' => $name,
                    'phone_number' => $phone_number,
                    'address_line_1' => $shipping1,
                    'address_line_2' => $shipping2,
                    'city' => $shippingCity,
                    'state' => $state,
                    'zipcode' => $zipcode,
                ]
            );
        }


        return view('success');
    }

    public function checkout(Request $request)
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            if (!($user->email_verified_at)) {
                return redirect('email/verify');
            }
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $user_id = Auth::id();
        $productsInCart = DB::table('cart_items')->where('user_id', $user_id)->get();
        $products = [];
        $totalAmount = 0;
        foreach ($productsInCart as $product) {
            $product_id = $product->product_id;
            $realProduct = DB::table('products')->where('id', $product_id)->first();
            $realProduct->quantity = 1;
            $totalAmount += $realProduct->price;
            array_push($products, $realProduct);
        }

        $lineItems = [];
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->price;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => $product->name,
                        'images' => [$product->image]
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $product->quantity,
            ];
        }

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => Route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => Route('checkout.cancel', [], true),
        ]);

        $name = $request->get('full_name');
        $phone_number = $request->get('phone_number');
        $shipping1 = $request->get('shipping_address_1');
        $shipping2 = $request->get('shipping_address_2');
        $state = $request->get('shipping_state');
        $shippingCity = $request->get('shipping_city');
        $zipcode = $request->get('shipping_zipcode');

        // $order_id = DB::table('orders')->max('id');
        // if ($order_id == NULL) {
        //     $order_id = 1;
        // } else {
        //     $order_id += 1;
        // }


        foreach ($productsInCart as $product) {
            $product_id = $product->product_id;
            $product = Products::where('id', $product_id)->first();
            // order table details
            $order = Order::create(
                [
                    // 'id' => $order_id,
                    'user_id' => $user_id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'session_id' => $checkout_session->id,
                    'payment_type' => 'online',
                    'status' => 'paid',
                ]
            );

            $user = User::where('id', $order->user_id)->first();
            Mail::to($request->user()->email)->send(new OrderConfirmationMail($order, $user));
            $order->save();
        }

        // shipping table details
        $orders = Order::latest()->take(count($productsInCart))->get();

        foreach ($orders as $order) {
            DB::table('shipping_data')->insert(
                [
                    'order_id' => $order->id,
                    'full_name' => $name,
                    'phone_number' => $phone_number,
                    'address_line_1' => $shipping1,
                    'address_line_2' => $shipping2,
                    'city' => $shippingCity,
                    'state' => $state,
                    'zipcode' => $zipcode,
                ]
            );
        }



        // $order = new Order();
        // $order->status = 'unpaid';
        // $order->total_price = $totalPrice;
        // $order->user_id = Auth::id();
        // $order->session_id = $checkout_session->id;
        // $order->save();


        return redirect($checkout_session->url);
    }

    public function success(Request $request)
    {


        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        // $sessionId = $request->get('session_id');
        // try {
        //     $session = \Stripe\Checkout\Session::retrieve($sessionId);
        //     // if (!$session) {
        //     //     throw new NotFoundHttpException;
        //     // }
        //     $customer = \Stripe\Checkout\Session::retrieve($session->customer);
        //     dd($customer);
        //     return view("success", compact($customer));
        // } catch (\Exception $e) {
        //     throw new NotFoundHttpException();
        // }

        try {
            $session_id = $request->get('session_id');
            $session = $stripe->checkout->sessions->retrieve($session_id);
            $customer_details = $session->customer_details;
            $customer = array('email' => $customer_details->email, 'name' => $customer_details->name);
            $orders = Order::where('session_id', $session_id)->get();
            if (!$orders) {
                throw new NotFoundHttpException();
            } else {
                foreach ($orders as $order) {
                    $order->payment_type = 'online';
                    $order->save();
                }
            }
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        return view('success', ['customer' => $customer]);
    }

    public function cancel()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            if (!($user->email_verified_at)) {
                return redirect('email/verify');
            }
        }
        return view("cancel");
    }

    public function webhook()
    {

        $endpoint_secret = env('WEBHOOK_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('unexpected value', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Signature verification exception', 400);
        }

        // Handle the event
        dd($event);
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $sessionId = $session->id;

                $order = Order::where('session_id', $sessionId)->first();
                if (!$order) {
                    throw new NotFoundHttpException();
                } else {
                    $order->status = 'paid';
                    $order->save();
                }
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }

    public function address()
    {
        $user_id = Auth::id();
        $productsInCart = DB::table('cart_items')->where('user_id', $user_id)->get();
        $productsArray = [];
        $totalAmount = 0;
        foreach ($productsInCart as $product) {
            $product_id = $product->product_id;
            $realProduct = DB::table('products')->where('id', $product_id)->first();
            $realProduct->quantity = $product->quantity;
            $totalAmount += $realProduct->price;
            array_push($productsArray, $realProduct);
        }

        // linking products by their category for nav bar
        $categories = ProductCategory::take(6)->get();
        foreach ($categories as $cat) {
            $products = Products::where('category_id', $cat->id)->get();
            $cat->products = $products;
        }

        return view('address', ['products' => $productsArray, 'total' => $totalAmount, 'productsInCart' => $productsInCart, 'categories' => $categories]);
    }
}
