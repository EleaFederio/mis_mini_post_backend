<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\SalesItemController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\BranchController;
use \App\Http\Controllers\DiscountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('product', [ProductController::class, 'index']);
Route::get('product/{id}', [ProductController::class, 'view']);
Route::put('product/update/{id}', [ProductController::class, 'update']);
Route::delete('product/{id}', [ProductController::class, 'delete']);

Route::get('products', [ProductController::class, 'showProducts']);
Route::get('aaa', [ProductController::class, 'aaaa']);
Route::post('product/add', [ProductController::class, 'store']);
Route::get('product/search/{keyWord}', [ProductController::class, 'search']);

Route::post('transaction/add', [SalesItemController::class, 'store']);
Route::get('transactions', [SalesItemController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('branches', [BranchController::class, 'index']);

Route::apiResource('discount', DiscountController::class);



Route::get('/year/sale/{year}', [ProductController::class, 'dataWareHouse']);
