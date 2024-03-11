<?php

use App\Models\Reviews;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', [ProductsController::class, 'index'])->name('welcome');

Route::get('/homePage', [ProductsController::class, 'homePageFromOrders'])->name('homePage');

// ----------------- admin routes ---------------
Route::post('/admin/product/insert', [AdminController::class, 'insert'])->name('admin.insert');

Route::post('/contact_us_post', [AdminController::class, 'Contact_US_POST']);

Route::post('/product/update', [AdminController::class, 'updateForm']);

Route::post('/product/delete/{id}', [AdminController::class, 'delete']);

Route::post('/admin/brand/delete/{id}', [AdminController::class, 'deleteBrand']);

Route::post('/admin/category/delete/{id}', [AdminController::class, 'catDelete']);

Route::post('/category/update/{id}', [AdminController::class, 'catUpdateForm']);

Route::put('category/updateStore/{id}', [AdminController::class, 'catUpdateStore']);

Route::put('brand/updateStore/{id}', [AdminController::class, 'brandUpdateStore']);

Route::post('/admin/category/insert', [AdminController::class, 'categoryInsert']);

Route::post('/admin/brand/insert', [AdminController::class, 'brandInsert']);

Route::get('/admin_panel/categories', [AdminController::class, 'categoryIndex']);


Route::put('/product/update/{id}', [AdminController::class, 'updateProduct']);

Route::get('/admin_panel', [AdminController::class, 'index'])->name('admin.index');

// --------------------  admin routes end --------------------------- 

Route::get('/products/search', [ProductsController::class, 'searchProduct'])->name('search-products');

//  categories 

Route::get('/showAllProducts/{id}', [ProductsController::class, 'showAllProductOfCategory'])->name('showAllProducts');

Route::get('/dashboard', function () {
    $user_id = Auth::id();
    $cart = DB::table('cart_items')->where('user_id', $user_id)->get();
    $productInCart = [];
    foreach ($cart as $cartItem) {
        array_push($productInCart, $cartItem->product_id);
    }
    $all_products = Products::all();

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

    return view('welcome', ['products' => $all_products, 'categories' => $categories, 't_categories' => $t_categories]);
})->name('dashboard')->middleware('verified');

// return cart page
Route::get('/cart', [CartController::class, 'index'])->name('cart')->middleware('auth');

// Add to cart
Route::post('/addToCart', [ProductsController::class, 'addToCart'])->name('addToCart')->middleware('auth');

// return products
Route::post('/return/product', [OrderController::class, 'returnProduct'])->name('returnProduct')->middleware('auth');

// delete product from cart
Route::delete('/cart/delete/{id}', [CartController::class, 'deleteProduct'])->name('removeFromCart')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['web', 'auth'])->group(function () {
    // Email verification routes
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

// payment Controller 
Route::post('/checkout/payonline', [PaymentController::class, 'checkout'])->name('checkout.online')->middleware('auth');;

// success cancel
Route::get('/checkout/cancel', [PaymentController::class, 'cancel'])->name('checkout.cancel')->middleware('auth');;

// success checkout
Route::get('/checkout/success', [PaymentController::class, 'success'])->name('checkout.success')->middleware('auth');

Route::post('/webhook', [PaymentController::class, 'webhook'])->name('checkout.webhook');

// checkout address  form
Route::post('/address', [PaymentController::class, 'address'])->name('checkout.address')->middleware('auth');

// show all orders in one page
Route::get('/orders/show', [OrderController::class, 'index'])->name('showOrders')->middleware('auth');

Route::get('/about', function () {
    // linking products by their category for nav bar
    $categories = ProductCategory::take(6)->get();
    foreach ($categories as $cat) {
        $products = Products::where('category_id', $cat->id)->get();
        $cat->products = $products;
    }
    return view('about', ["categories" => $categories]);
});

// post review route
Route::post('/postReview', [UserController::class, 'review']);

// cash on delivery handling
Route::post("/cashOnDelivery", [PaymentController::class, 'cod'])->name('checkout.cod')->middleware('auth');;

// single product listing
Route::get('/product/show/{id}', [ProductsController::class, 'singleProductGet'])->name('showProductListing')->where(array('id' => '[0-9]+'))->name("showProductListing");

require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/feedback', function (Request $request) {

    $validatedData = $request->validate(['feedback' => 'required']);
    $user_id = Auth::id();
    Reviews::create([
        'user_id' => $user_id,
        'product_id' => $request->product_id,
        'review' => $request->feedback
    ]);
    return redirect()->back()->with("message", "Review Added!");
});

Route::get('/admin_logout', function () {
    session()->put('admin_login', null);
    return redirect('admin_panel');
});

Route::post('/admin_login_post', function (Request $request) {
    $username = $request->username;
    $password = $request->password;

    $admin = DB::table('admin')->first();
    $realPassword = $admin->password;
    $realPassword = str_replace(["\r", "\n"], "", $realPassword);

    if ($username == $admin->username && $password == $realPassword) {
        session()->put('admin_login', true);
        session()->save();
        return redirect('admin_panel');
    } else {
        return redirect()->back()->with('error', 'Validation failed. Please check your input.');
    }
});


Route::get('/admin_panel/orders', [OrderController::class, 'showAdminOrders'])->name('showAdminOrders');

Route::get('/admin_panel/returns', [OrderController::class, 'showAdminReturns'])->name('showAdminReturns');
