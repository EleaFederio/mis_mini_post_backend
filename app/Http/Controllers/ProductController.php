<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
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

    public function paginate($items, $perPage = 5, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
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

    public function search($keyWord){
        return Product::where('name', 'like', '%'.$keyWord.'%')->get();
    }
}
