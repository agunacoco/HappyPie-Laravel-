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

require __DIR__.'/auth.php';
