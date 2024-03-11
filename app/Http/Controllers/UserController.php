<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function review(Request $request)
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            if (!($user->email_verified_at)) {
                return redirect('email/verify');
            }
        }

        $formFields = $request->validate([
            'review' => 'required'
        ]);

        $product_id = $request->pro_id;

        $id = Auth::id();

        DB::table('reviews')->insert([
            ['product_id' => $product_id, 'user_id' => $id, 'review' => $request->review],
        ]);

        return redirect('/product/show/' . $product_id)->with('message', 'Review Submitted Successfully!');
    }
}
