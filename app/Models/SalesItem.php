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
        'branch_id',
        'quantity'
    ];

    function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    function sales(){
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
