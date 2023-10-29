<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name', 'category_id', 'supplier_id', 'product_code', 'product_description', 'photo', 'stock', 'buying_price', 'selling_price', 'sales', 'vat'
    ];

	// protected $fillable = [
 //        'product_name','product_description'
 //    ];

}
