<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

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
        $fileName = null;
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required'
        ]);

        if($request->product_img != null){
            $dataTime = date('Ymd_His');
            $file = $request->file('product_img');
            $fileName = $dataTime. '-'.rand(00000000, 99999999).'.jpg';
            Storage::disk('google')->putFileAs(env('GOOGLE_DRIVE_FOLDER_ID'), $file, $fileName);
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'product_img' => $fileName,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'product details saved to db!'
        ]);
    }

    public function search($keyWord){
        return Product::where('name', 'like', '%'.$keyWord.'%')->get();
    }
}
