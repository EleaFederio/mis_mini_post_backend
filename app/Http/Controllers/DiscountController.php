<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::all();
        return $discounts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // *** Accept - application/json *** //
        $validateData = $request->validate([
            'name' => ['required', 'unique:discounts'],
            'percent' => ['required', 'integer']
        ]);

        Discount::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Discount added!',
            'discount'  => Discount::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show($discount)
    {
        $discountObject = Discount::find($discount);
        if(!empty($discountObject)){
            return response()->json([
                'success' => true,
                'discount' => $discountObject
            ]);
        }else{
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Item doesn\'t exist!'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $discount)
    {
        $discountItem = Discount::find($discount);
        if(!empty($discountItem)){
            $discountItem->update($request->all());
            return response()->json([
                'success' => true,
                'discount' => Discount::all()
            ]);
        }else{
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Item doesn\'t exist!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($discount)
    {
        $discountItem = Discount::find($discount);
        if(!empty($discountItem)){
            $discountItem->delete();
            return response()->json([
                'success' => true,
                'message' => 'Discount successfully deleted!',
                'discount' => Discount::all()
            ]);
        }else{
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Item doesn\'t exist!'
            ]);
        }
    }

    public function uploadDiscount(Request $request){
        $discounts = $request->all();
        foreach ($discounts as $discount){
//            $discount->validate([
//                'name' => ['required', 'unique:discounts'],
//                'percent' => ['required', 'integer']
//            ]);
            Discount::create($discount);
        }
        return response()->json([
            'success' => true,
            'message' => 'Discount successfully uploaded!',
        ]);
    }
}
