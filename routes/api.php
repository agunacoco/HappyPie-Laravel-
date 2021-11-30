<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/payment/')->group(function(){
    Route::get('call', [PaymentsController::class, 'callpayment'])->name('payment.call');
    Route::post('success', [PaymentsController::class, 'store'])->name('payment.store'); 
});

Route::prefix('/address/')->group(function(){
    Route::get('call', [AddressController::class, 'calladdress'])->name('calladdress.call');
    Route::post('success', [AddresssController::class, 'store'])->name('payment.store'); 
});
