<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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


Route::get('/cls', function() {
    Session::flush();
    return 'FINISHED';
});
Route::get('/migrate', function() {
    Artisan::call('migrate');
    return 'FINISHED';
});

Route::get('/',[\App\Http\Controllers\BikeController::class,'index']);

Route::post('language',[\App\Http\Controllers\BikeController::class,'language']);
Route::post('subscription',[\App\Http\Controllers\BikeController::class,'subscription']);
Route::post('checkout',[\App\Http\Controllers\BikeController::class,'checkout']);
Route::post('detail',[\App\Http\Controllers\BikeController::class,'detail']);
Route::post('pick',[\App\Http\Controllers\BikeController::class,'pick']);
Route::post('billing',[\App\Http\Controllers\BikeController::class,'billing']);

Route::post('payment',[\App\Http\Controllers\StripePaymentController::class,'charge'])->name('stripe.post');


Route::get('order',[\App\Http\Controllers\OrderController::class,'index']);
