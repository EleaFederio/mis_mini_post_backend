<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sale_id',
        'quantity'
    ];

    function products(){
        return $this->belongsTo(Product::class);
    }

    function sales(){
        return $this->belongsTo(Sale::class);
    }
}
