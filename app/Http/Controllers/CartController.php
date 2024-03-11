<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
        $productsInCart = DB::table('cart_items')->where('user_id', $user_id)->get();
        $products = [];
        $totalAmount = 0;
        foreach ($productsInCart as $product) {
            $product_id = $product->product_id;
            $realProduct = Products::where('id', $product_id)->first();
            $totalAmount += $realProduct->price;
            array_push($products, $realProduct);
        }

        return view('cart', ['products' => $products, 'total' => $totalAmount, 'productsInCart' => $productsInCart, 'user_id' => $user_id]);
    }

    public function deleteProduct($id)
    {
        DB::table('cart_items')->where('product_id', $id)->delete();
        return back();
    }
}
