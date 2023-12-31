<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variant extends Model
{
    use HasFactory;
    
    protected $fillable= ['name', 'sku', 'additional_cost', 'stock_count', 'product_id'];

}
