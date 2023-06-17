<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    
    protected $fillable = ['name', 'description', 'price'];


    public function variants(){

        return $this->hasMany(Variant::class);
    }
}
