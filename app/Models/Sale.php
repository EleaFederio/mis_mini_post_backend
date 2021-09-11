<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_price',
        'reference_number'
    ];

    function salesItems(){
        return $this->hasMany(SalesItem::class);
    }
}
