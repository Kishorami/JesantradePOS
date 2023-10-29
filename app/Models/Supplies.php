<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplies extends Model
{
    protected $fillable = [
        'product_name', 'product_code', 'quantity', 'unit_cost', 'total_cost', 'suppliers_id', 
    ];
}
