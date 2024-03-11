<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Reviews;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ReturnProducts;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    public function singleProductGet($id)
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            if (!($user->email_verified_at)) {
                return redirect('email/verify');
            }
        }

        // find product 
        $product = Products::where('id', $id)->first();

        // reviews
        $reviews = Reviews::all();

        // linking products by their category for nav bar
        $categories = ProductCategory::take(6)->get();
        foreach ($categories as $cat) {
            $products = Products::where('category_id', $cat->id)->get();
            $cat->products = $products;
        }

        $isReviewAllow = false;

        if (Auth::check()) {
            global $userId;
            $userId = Auth::user()->id;
            $product_cart = Cart::where('user_id', $userId)->where('product_id', $product->id)->first();
            if ($product_cart) {
                $product->inCart = true;
            } else {
                $product->inCart = false;
            }

            // checking if review is allowed or not
            $reviewAllow1 = ReturnProducts::where('user_id', $userId)->where('product_id', $product->id)->first();
            $reviewAllow2 = Order::where('user_id', $userId)->where('product_id', $product->id)->first();

            global $isReviewAllow;
            if ($reviewAllow1 || $reviewAllow2) {
                $isReviewAllow = true;
            }
        } else {
            $product->inCart = false;
        }

        $reviews = Reviews::where('product_id', $product->id)->get();
        foreach ($reviews as $review) {
            $user_id = $review->user_id;
            $user = User::where('id', $user_id)->first();
            $review->userName = $user->name;
        }

        return view('singleProduct', ['product' => $product, 'reviews' => $reviews, 'categories' => $categories, 'reviewAllowed' => $isReviewAllow]);
    }

    public function  homePageFromOrders()
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            if (!($user->email_verified_at)) {
                return redirect('email/verify');
            }
        }

        $user_id = Auth::id();
        $cart = DB::table('cart_items')->where('user_id', $user_id)->get();
        $productInCart = [];
        foreach ($cart as $cartItem) {
            array_push($productInCart, $cartItem->product_id);
        }
        $all_products = Products::all();
        $categories = ProductCategory::all();

        foreach ($all_products as $eachProduct) {
            if (array_search($eachProduct->id, $productInCart) !== false) {
                $eachProduct->inCart = true;
            } else {
                $eachProduct->inCart = false;
            }
        }

        return view('welcome', ['products' => $all_products, 'categories' => $categories]);
    }

    public function showAllProductOfCategory($id)
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            if (!($user->email_verified_at)) {
                return redirect('email/verify');
            }
        }
        $user_id = Auth::id();
        $cart = DB::table('cart_items')->where('user_id', $user_id)->get();
        $productInCart = [];
        foreach ($cart as $cartItem) {
            array_push($productInCart, $cartItem->product_id);
        }
        $all_products = Products::where('category_id', $id)->get();
        foreach ($all_products as $eachProduct) {
            if (array_search($eachProduct->id, $productInCart) !== false) {
                $eachProduct->inCart = true;
            } else {
                $eachProduct->inCart = false;
            }
        }


        // get categories for nav bar 
        // linking products by their category for nav bar
        $categories = ProductCategory::take(6)->get();
        foreach ($categories as $cat) {
            $temp = Products::where('category_id', $cat->id)->get();
            $cat->products = $temp;
        }

        $category = ProductCategory::where('id', $id)->first();
        return view('showCategoryProducts', [
            'products' => $all_products,
            'catName' => $category->name,
            'categories' => $categories
        ]);
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

        // checking if product is in cart or not
        $cart = DB::table('cart_items')->where('user_id', $user_id)->get();
        $productInCart = [];
        foreach ($cart as $cartItem) {
            array_push($productInCart, $cartItem->product_id);
        }
        $all_products = Products::take(8)->get();
        foreach ($all_products as $eachProduct) {
            if (array_search($eachProduct->id, $productInCart) !== false) {
                $eachProduct->inCart = true;
            } else {
                $eachProduct->inCart = false;
            }
        }

        // linking products by their category for nav bar
        $categories = ProductCategory::take(6)->get();
        foreach ($categories as $cat) {
            $products = Products::where('category_id', $cat->id)->get();
            $cat->products = $products;
        }

        $t_categories = ProductCategory::all();

        // featured Products section
        $featured_products = Products::take(8)->get();

        return view(
            'welcome',
            [
                'f_products' => $featured_products,
                'products' => $all_products,
                'categories' => $categories,
                't_categories' => $t_categories
            ]
        );
    }





    public function addToCart(Request $request)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            if (!($user->email_verified_at)) {
                return redirect('email/verify');
            }
        }

        $quantity = 1;
        $user_id = Auth::id();
        $product_id = $request->product_id;

        DB::table('cart_items')->insert([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
        ]);

        return redirect()->back();
    }

    public function singleProductListing(Request $request, $id)
    {
        view('singleProduct');
    }

    public function searchProduct(Request $request)
    {
        $query = $request->get('searchQuery');
        if (empty($query)) {
            return 'empty-state';
        }
        if ($request->ajax()) {
            $products = Products::where('name', 'like', '%' . $query . '%')
                ->orWhere('desc', 'like', '%' . $query . '%')
                ->orWhere('price', 'like', '%' . $query . '%')->get();

            $output = '';
            if (count($products) > 0) {
                foreach ($products as $product) {
                    $output .= '<a href="/product/show/' . $product->id . '" class="box-border flex flex-col justify-center w-3/4 px-4 py-2 mx-auto bg-white border border-gray-300 rounded-lg shadow border-1 align-center hover:border-blue-700 hover:border-2">
                    <div class="flex flex-col items-center gap-4 sm:flex-row">
                    <div class="flex justify-start w-full gap-4">
                        <span class="material-symbols-outlined">search</span>
                        <h2 class="mb-4 text-base font-semibold md:text-xl">' . $product->name . '</h2>
                    </div>
                    </div>
                    </a >';
                }
            } else {
                $output .= 'no-result';
            }

            return $output;
        }
    }
}
