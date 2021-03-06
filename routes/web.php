<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\HappypiesController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\OrderlistsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('happypies.main');
})->name('happypie.main');

Route::get('/happypies/aboutme', function () {
    return view('happypies.intro');
})->name('happypie.intro');

Route::get('/happypies/menu', [HappypiesController::class, 'index'])->name('happypie.menu');

Route::get('/happypies/index', [MenusController::class, 'index'])->name('happypie.index');
Route::post('/happypies/store', [MenusController::class, 'store'])->middleware('auth')->name('happypie.store');
Route::get('/happypies/show/{menu_id}', [MenusController::class, 'show'])->name('happypie.show');
Route::delete('/happypies/{menu_id}', [MenusController::class, 'destroy'])->middleware('auth')->name('happypie.destroy');
Route::patch('/happypies/{menu_id}', [MenusController::class, 'update'])->middleware('auth')->name('happypie.update');
Route::get('/happypies/shoppingcart', [HappypiesController::class, 'cartindex'])->name('happypie.cart');
Route::get('/happypies/shoppingcart/list', [CartsController::class, 'index'])->name('cart.index');
Route::post('/happypies/cart/store/{menu_id}', [CartsController::class, 'store'])->middleware('auth')->name('cart.store');
Route::patch('/happypies/cart/count/{menu_id}', [CartsController::class, 'update'])->middleware('auth')->name('cart.update');
Route::delete('/happypies/cart/{menu_id}', [CartsController::class, 'destroy'])->middleware('auth')->name('cart.destroy');
Route::get('/happypies/mypage', [HappypiesController::class, 'mypage'])->middleware('auth')->name('happypie.mypage');

Route::get('happypies/payment/success', [HappypiesController::class, 'payhistory'])->middleware('auth')->name('happypie.payhistory');
Route::post('/happypies/payment/store', [PaymentsController::class, 'store'])->middleware('auth');

Route::delete('/happypies/cart/destroy', [PaymentsController::class, 'destroyCart'])->middleware('auth');
Route::get('/happypies/receipt/{order_id}', [PaymentsController::class, 'showReceipt'])->middleware('auth');

Route::post('/happypies/delivery/store', [PaymentsController::class, 'storeDelivery'])->middleware('auth');

Route::prefix('/happypies/ordersheet')->group(function(){
    Route::get('/', [HappypiesController::class, 'ordersheet'])->middleware('auth')->name('happypie.ordersheet');
    Route::get('/list', [OrderlistsController::class, 'index'])->middleware('auth');
    Route::patch('/status/{payment_id}', [OrderlistsController::class, 'updateStatus'])->middleware('auth');
    Route::patch('/show/{payment_id}', [OrderlistsController::class, 'show'])->middleware('auth');
});

Route::get('/happypies/orderlist/index', [PaymentsController::class, 'index'])->middleware('auth');
Route::get('/happypies/orderlist', [HappypiesController::class, 'orderlist'])->middleware('auth')->name('happypie.orderlist');
require __DIR__.'/auth.php';
