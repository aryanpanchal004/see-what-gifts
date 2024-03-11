<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'name',
        'desc',
        'image',
        'category_id',
        'brand_id',
        'price',
    ];

    // public function productCategory()
    // {
    //     return $this->belongsTo(ProductCategory::class);
    // }
    // return view('welcome',['product',Products::all()]);
}
