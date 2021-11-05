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
            'message' => 'Discount added!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        $discountObject = Discount::find($discount->id);
        return response()->json([
            'success' => true,
            'discount' => $discountObject
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Discount $discount)
    {
        $discountItem = Discount::findOrFail($discount->id);
        if($discountItem){
            $discountItem->update($request->all());
            return response()->json([
                'success' => true,
                'discount' => Discount::all()
            ]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discountItem = Discount::findOrFail($discount->id);
        if ($discountItem)
            $discountItem->delete();
        else response()->json(error);
        return response()->json(null);
    }
}
