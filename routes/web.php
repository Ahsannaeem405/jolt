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
    Artisan::call('optimize');
    Session::flush();
    return 'FINISHED';
});
Route::get('/migrate', function() {
    Artisan::call('migrate');
    Artisan::call('schedule:run');
    return 'FINISHED';
});

Route::get('/',[\App\Http\Controllers\BikeController::class,'index']);
Route::post('language',[\App\Http\Controllers\BikeController::class,'language']);
Route::post('subscription',[\App\Http\Controllers\BikeController::class,'subscription']);
Route::post('checkout',[\App\Http\Controllers\BikeController::class,'checkout']);
Route::post('detail',[\App\Http\Controllers\BikeController::class,'detail']);
Route::post('pick',[\App\Http\Controllers\BikeController::class,'pick']);
Route::post('billing',[\App\Http\Controllers\BikeController::class,'billing']);
Route::get('back/{id}',[\App\Http\Controllers\BikeController::class,'back']);

Route::post('payment',[\App\Http\Controllers\StripePaymentController::class,'charge'])->name('stripe.post');
Route::post('chargeNow/{id}',[\App\Http\Controllers\StripePaymentController::class,'chargeNow'])->name('stripe.post.paynow');
Route::get('paynow/{id}',[\App\Http\Controllers\StripePaymentController::class,'payNow']);


Route::get('order',[\App\Http\Controllers\OrderController::class,'index']);
Route::post('sentotp',[\App\Http\Controllers\OrderController::class,'Sendotp']);

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/subscription',[\App\Http\Controllers\HomeController::class,'index']);
Route::get('/subscription/{status}/{id}',[\App\Http\Controllers\HomeController::class,'status']);
Route::get('/logout',[\App\Http\Controllers\HomeController::class,'logout']);
