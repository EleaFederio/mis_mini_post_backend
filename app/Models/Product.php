<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'product_img'
    ];

    function salesItems(){
        return $this->hasMany(SalesItem::class);
    }

    function categories(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
