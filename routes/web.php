<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DessertsController;
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

Route::get('/happypies/menu', [DessertsController::class, 'index'])->name('happypie.menu');
require __DIR__.'/auth.php';
