<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Reviews;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ReturnProducts;
use App\Mail\contactUSMail;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function Contact_US_POST(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        try {
            Mail::to("arrayofsilicon@gmail.com")->send(new ContactUSMail($contact));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect('/')->with('message', "Your Message Sent Successfully!");
    }

    public function catDelete($id)
    {

        $admin = session('admin_login');
        if (!$admin) {
            return view('admin_panel.login');
        }

        // delete brand
        ProductCategory::destroy($id);
        $products = Products::where('category_id', $id)->get();
        ProductCategory::where('category_id', $id)->delete();
        foreach ($products as $product) {
            $id = $product->id;
            Order::where('product_id', $id)->delete();
            ReturnProducts::where('product_id', $id)->delete();
            Cart::where('product_id', $id)->delete();
            Reviews::where('product_id', $id)->delete();
        }

        return redirect('/admin_panel/categories')->with('message', "Category Deleted Successfully");
    }

    public function categoryIndex()
    {
        $admin = session('admin_login');
        if (!$admin) {
            return view('admin_panel.login');
        }

        $categories = ProductCategory::all();
        return view('admin_panel.category', ['categories' => $categories]);
    }



    public function categoryInsert(Request $request)
    {

        $admin = session('admin_login');
        if (!$admin) {
            return view('admin_panel.login');
        }
        $formFields = $request->validate([
            'name' => 'required',
            'image' => 'required'
        ]);

        $image = $request->file("image")->store("category_images", 'public');

        DB::table('product_category')->insert([
            'name' => $request->name,
            'image' => $image
        ]);

        return redirect('/admin_panel/categories')->with('message', "Category inserted Successfully!");
    }




    public function delete($id)
    {
        Order::where('product_id', $id)->delete();
        ReturnProducts::where('product_id', $id)->delete();
        Cart::where('product_id', $id)->delete();
        Reviews::where('product_id', $id)->delete();
        Products::where('id', $id)->delete();
        return redirect('/admin_panel')->with('message', "Product Deleted Successfully");
    }



    public function updateProduct(Request $request, $id)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        $product = Products::find($id);
        $product->name = $request->input('name');
        $product->desc = $request->input('desc');
        $product->category_id = $request->input('category');
        $product->price = $request->input('price');

        if ($request->hasFile('image')) {
            $product->image = $request->file("image")->store("Products", 'public');
        }

        $product->update();
        return redirect('/admin_panel')->with('message', "Product Updated Successfully");
    }

    public function catUpdateStore(Request $request, $id)
    {
        $formFields = $request->validate([
            'name' => 'required',
        ]);


        $productCategory = ProductCategory::find($id);
        $productCategory->name = $request->name;
        if ($request->hasFile('image')) {
            $productCategory->image = $request->file("image")->store("category_images", 'public');
        }
        $productCategory->update();

        return redirect('/admin_panel/categories')->with('message', "Category Updated Successfully");
    }

    public function catUpdateForm(Request $request, $id)
    {
        $category = DB::table('product_category')->where('id', $id)->first();
        return view('admin_panel.editCategory', ['category' => $category]);
    }


    public function updateForm(Request $request)
    {
        $pro_id = $request->product_id;
        $product = DB::table('products')->where('id', $pro_id)->first();

        // ------------------- category name --------------

        $cat_id = $product->category_id;
        $catRow = DB::table('product_category')->where('id', $cat_id)->first();
        $product->cat_name = $catRow->name;


        $categories = DB::table('product_category')->get();

        return view('admin_panel.editProduct', ['product' => $product, 'categories' => $categories]);
    }

    public function index()
    {

        $admin = session('admin_login');
        if (!$admin) {
            return view('admin_panel.login');
        }

        $categories = DB::table('product_category')->get();
        $allProducts = DB::table('products')->get();

        foreach ($allProducts as $product) {
            // ------------------- category name --------------

            $cat_id = $product->category_id;
            $catRow = DB::table('product_category')->where('id', $cat_id)->first();
            $product->cat_name = $catRow->name;
        }

        return view(
            'admin_panel.index',
            ['categories' => $categories, 'products' => $allProducts]
        );
    }

    public function insert(Request $request)
    {

        $admin = session('admin_login');
        if (!$admin) {
            return view('admin_panel.login');
        }

        $formFields = $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'image' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        $image = $request->file("image")->store("Products", 'public');

        DB::table('products')->insert([
            'name' => $request->name,
            'desc' => $request->desc,
            'image' => $image,
            'category_id' => $request->category,
            'price' => $request->price,
        ]);

        return redirect("/admin_panel")->with('message', 'Product inserted successfully admin!');
    }
}
