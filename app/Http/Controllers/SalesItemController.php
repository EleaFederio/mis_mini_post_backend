<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SalesItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesItemController extends Controller
{

    public function store(Request $request){
        $totalPrice = $request->totalPrice;
        $payment = $request->payment;
        $change = $payment - $totalPrice;
        $discount = $request->discount;
        $discountName = $request->discountName;
        $referenceNumber = rand(00000000, 99999999);
        $products = $request->products;

        // check if product exist before saving to DB
        if($totalPrice > 0 && $payment > 0){
            Sale::create([
                'total_price' => $totalPrice,
                'payment' => $payment,
                'reference_number' => $referenceNumber,
                'change' => $change,
                'discount' => $discount,
                'discountName' => $discountName
            ]);

            // find the last product in the Products table
            $lastEntry = Sale::orderBy('created_at', 'desc')->first();

            foreach ($products as $product){
                SalesItem::create([
                    // save using many-to-many relationship
                    'product_id' => $product['item'],
                    'sale_id' => $lastEntry->id,
                    'branch_id' =>$product['branch_id'],
                    'quantity' => $product['quantity']
                ]);
            }
            $this->paginate($products, 10);
//            return response()->json([
//                'success' => true,
//                'message' => 'ordered product successfully saved in database',
//                'products' => $products
//            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'something wrong',
            ]);
        }
        return $products;
    }


    /**
     * @return all the sales including
     *      reference number, item quantity & price, creation date
     *
     */
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
                    'branch' => $saleItem->branch->branch_name,
                    'total' => number_format((float)$saleItem->quantity * $saleItem->products->price, 2, '.', '')

                ]);
            }
            array_push($data, [
                // ********** computation of product cost ********** //
                'sales_id' => $sale->id,
                'total' => number_format((float)($sale->total_price * 0.12) + $sale->total_price, 2, '.', ''),
                'sub_total' => $sale->total_price,
                'tax' => number_format((float)$sale->total_price * 0.12, 2, '.', ''),
                'payment' => $sale->payment,
                'reference_number' => $sale->reference_number,
                'change' => number_format((float)$sale->payment - (($sale->total_price * 0.12) + $sale->total_price), 2, '.', ''),
                'discount'  => $sale->discount,
                'discountName'  => $sale->discountName,
                'created_at'  => Carbon::createFromFormat('Y-m-d H:i:s', $sale->created_at)->translatedFormat('M d, Y - h:i-A'),
                'product' => $subData
            ]);
//            return $data;
        }
        return $this->paginate($data, 10);
    }

    public function paginate($items, $perPage = 6, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
//        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        $lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

        return [
            'current_page' => $lap->currentPage(),
            'data' => $lap ->values(),
            'first_page_url' => $lap ->url(1),
            'from' => $lap->firstItem(),
            'last_page' => $lap->lastPage(),
            'last_page_url' => $lap->url($lap->lastPage()),
            'next_page_url' => $lap->nextPageUrl(),
            'per_page' => $lap->perPage(),
            'prev_page_url' => $lap->previousPageUrl(),
            'to' => $lap->lastItem(),
            'total' => $lap->total(),
            'links' => $lap->toArray()['links'],
//            'test' => $lap->elements()
        ];
    }

}
