<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    protected $fillable = [
        'p_bill_code', 'p_data', 'p_total',
    ];
}
