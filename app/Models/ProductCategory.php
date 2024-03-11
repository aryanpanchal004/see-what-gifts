<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = "product_category";
    protected $fillable = [
        'name',
    ];
    // public function products()
    // {
    //     return $this->hasMany(Products::class);
    // }
}
