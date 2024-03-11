<?php

namespace App\Http\Controllers;

use App\Mail\ReturnProduct;
use App\Models\User;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ReturnProducts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function showAdminReturns()
    {

        $admin = session('admin_login');
        if (!$admin) {
            return view('admin_panel.login');
        }

        $returns = ReturnProducts::all();
        foreach ($returns as $return) {
            $user_id = $return->user_id;
            $user = User::where('id', $user_id)->first();
            $return->user = $user;
        }
        return view('admin_panel.returns', ['returns' => $returns]);
    }
    public function showAdminOrders()
    {

        $admin = session('admin_login');
        if (!$admin) {
            return view('admin_panel.login');
        }

        $orders = Order::all();
        foreach ($orders as $order) {
            $user_id = $order->user_id;
            $user = User::where('id', $user_id)->first();
            $order->user = $user;
        }
        return view('admin_panel.orders', ['orders' => $orders]);
    }
    public function index()
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            if (!($user->email_verified_at)) {
                return redirect('email/verify');
            }
        }

        $user_id = Auth::id();

        $results = DB::select("SELECT * FROM orders WHERE DATEDIFF(created_at , CURDATE()) < 15 AND user_id = $user_id");

        $returnable = [];
        foreach ($results as $result) {
            $returnable[] = $result->id;
        }

        $orders = Order::where('user_id', $user_id)->get();
        // dd($returnable);

        if ($results != 0) {
            foreach ($orders as $order) {
                if (array_search($order->id, $returnable) !== false) {
                    $order->returnable = true;
                } else {
                    $order->returnable = false;
                }
            }
        }

        // user's returned products
        $returns  = ReturnProducts::where('user_id', Auth::user()->id)->get();

        return view('orders', ['orders' => $orders, 'returns' => $returns]);
    }

    public function returnProduct(Request $request)
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            if (!($user->email_verified_at)) {
                return redirect('email/verify');
            }
        }

        $order = Order::where('id', $request->order_id)->first();
        $return = ReturnProducts::create([
            'user_id' => Auth::user()->id,
            'product_id' => $order->product_id,
            'product_name' => $order->product_name,
            'price' => $order->price,
            'payment_type' => $order->payment_type
        ]);
        $user = User::where('id', $return->user_id)->first();
        Mail::to($request->user()->email)->send(new ReturnProduct($user, $return));
        DB::table('orders')->where('id', $request->order_id)->delete();
        return redirect()->back()->with(['msg' => 'Product Return Successfull!']);
    }
}
