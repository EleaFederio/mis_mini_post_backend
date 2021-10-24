<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\SalesItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        $data = [];
        foreach ($products as $product){
            $product->categories;
            array_push($data, [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category' => $product->categories->category_name
            ]);
        }

        return $this->paginate($data);
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



    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required'
        ]);
        Product::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Product successfully added!'
        ]);
    }

    public function test(){
        $products = Product::all();
        $data = [];

        // Circle trough all 12 months
        for ($month = 1; $month <= 12; $month++) {
            // Create a Carbon object from the current year and the current month (equals 2019-01-01 00:00:00)
            $date = Carbon::create(date('Y'), $month);

            // Make a copy of the start date and move to the end of the month (e.g. 2019-01-31 23:59:59)
            $date_end = $date->copy()->endOfMonth();

            $tempTransactionCount = 0;
            foreach ($products as $product){
                $transaksi = SalesItem::where('product_id', $product->id)
                    // the creation date must be between the start of the month and the end of the month
                    ->where('created_at', '>=', $date)
                    ->where('created_at', '<=', $date_end)
                    ->count();
                $tempTransactionCount = $tempTransactionCount + $transaksi;
            }
            $data[$month] = $tempTransactionCount;
        }
        return response()->json([
            'success' => true,
            'message' => $data
        ]);
    }

    public function search($keyWord){
        return Product::where('name', 'like', '%'.$keyWord.'%')->get();
    }
}
