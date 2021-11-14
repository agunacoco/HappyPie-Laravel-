<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\HappypiesController;
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
Route::post('/happypies/store', [MenusController::class, 'store'])->name('happypie.store');
Route::get('/happypies/show/{menu_id}', [MenusController::class, 'show'])->name('happypie.show');
Route::get('/happypies/shoppingcart', [HappypiesController::class, 'shoppingcart'])->name('happypie.shoppingcart');
Route::delete('/happypies/{menu_id}', [MenusController::class, 'destroy'])->name('happypie.destroy');
Route::patch('/happypies/{menu_id}', [MenusController::class, 'update'])->name('happypie.update');

require __DIR__.'/auth.php';
