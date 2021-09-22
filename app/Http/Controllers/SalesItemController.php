<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SalesItem;
use Carbon\Carbon;
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
                array_push($subData, [
                    'name' => $saleItem->products->name,
                    'description' => $saleItem->products->description,
                    'price' => $saleItem->products->price,
                    'quantity' => $saleItem->quantity,
                    'total' => number_format((float)$saleItem->quantity * $saleItem->products->price, 2, '.', '')

                ]);
            }
            array_push($data, [
                'total' => number_format((float)($sale->total_price * 0.12) + $sale->total_price, 2, '.', ''),
                'sub_total' => $sale->total_price,
                'tax' => number_format((float)$sale->total_price * 0.12, 2, '.', ''),
                'payment' => $sale->payment,
                'reference_number' => $sale->reference_number,
                'change' => number_format((float)$sale->payment - (($sale->total_price * 0.12) + $sale->total_price), 2, '.', ''),
//                'created_at'  => $sale->created_at,
                'created_at'  => Carbon::createFromFormat('Y-m-d H:i:s', $sale->created_at)->translatedFormat('M d, Y - h:i-A'),
                'product' => $subData
            ]);
        }
        return $data;
    }

}
