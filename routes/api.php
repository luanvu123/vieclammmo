<?php

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    // Kiểm tra xem đã có đánh giá chưa
    Route::get('/check-review', function (Request $request) {
        $review = Review::where('customer_id', $request->customer_id)
            ->where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->first();

        return response()->json([
            'exists' => $review ? true : false,
            'review' => $review
        ]);
    });
});
