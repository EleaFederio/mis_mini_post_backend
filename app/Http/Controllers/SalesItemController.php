<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesItemController extends Controller
{

    public function store(Request $request){
        $totalPrice = $request->totalPrice;
        $payment = $request->payment;
        $change = $payment - $totalPrice;
        $referenceNumber = rand(00000000, 99999999);
        $products = $request->products;
        if($totalPrice > 0 && $payment > 0){
            Sale::create([
                'total_price' => $totalPrice,
                'payment' => $payment,
                'reference_number' => $referenceNumber,
                'change' => $change
            ]);
            $lastEntry = Sale::orderBy('created_at', 'desc')->first();
            foreach ($products as $product){
//                dd($product['item']);
                SalesItem::create([
                    'product_id' => $product['item'],
                    'sale_id' => $lastEntry->id,
                    'quantity' => $product['quantity']
                ]);
            }

//            return $products;

        }else{
            return response()->json([
                'message' => 'something wrong',
            ]);
        }
    }

}
