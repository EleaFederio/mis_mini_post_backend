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
                SalesItem::create([
                    'product_id' => $product['item'],
                    'sale_id' => $lastEntry->id,
                    'quantity' => $product['quantity']
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'ordered product successfully saved in database',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'something wrong',
            ]);
        }
    }

    public function show() {
        $sales = Sale::all();
        $data = [];
        foreach ($sales as $sale){
            $subData = [];
            $saleItems = SalesItem::where('sale_id', $sale->id)->get();
            foreach ($saleItems as $saleItem){
                array_push($subData, $saleItem->products);
            }
            array_push($data, [
                'total' => $sale->total_price,
                'payment' => $sale->payment,
                'reference_number' => $sale->reference_number,
                'change' => $sale->change,
                'product' => $subData
            ]);
//            foreach ($saleItems as $saleItem){
//
//                var_dump($saleItem->products);
//            }
        }
        return $data;

//        $salesItems = SalesItem::all();
//        $data = [];
//        foreach ($salesItems as $salesItem){
//            $products = $salesItem->products;
//            array_push($data, [
//                'payment' => $salesItem->sales->payment,
//                'total_price' => $salesItem->sales->total_price,
//                'reference_number' => $salesItem->sales->reference_number,
//                'change' => $salesItem->sales->change,
//
//                'quantity' => $salesItem->quantity
//            ]);
//        }
//
//        return response()->json([
//            'success' => false,
//            'data' => $data,
//        ]);
    }

}
