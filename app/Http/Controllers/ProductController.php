<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return ProductResource::collection(Product::paginate(10));
    }

    public function aaaa(Request $request){
        $products = Product::all();
        $data = [];
        foreach ($products as $product){
            $product->categories;
            array_push($data, [
               'name' => $product->name,
               'description' => $product->description,
                'price' => $product->price,
                'category' => $product->categories
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
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
