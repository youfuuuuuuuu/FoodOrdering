<?php

use Illuminate\Support\Facades\Route;

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
    return view('addProduct');
});

Route::get('/add', function () {
    return view('addProduct');  
});

Route::post('addProduct/store',[App\Http\Controllers\ProductController::class,'add'])->name('addProduct');

Route::get('/showProduct',[App\Http\Controllers\ProductController::class,'view'])->name('showProduct');

Route::get('/deleteProduct/{id}',[App\Http\Controllers\ProductController::class,'delete'])->name('viewproduct.delete');

Route::get('/deleteCart/{id}', [App\Http\Controllers\CartController::class,'delete'])->name('viewcart.delete');

Route::get('/editProduct/{id}',[App\Http\Controllers\ProductController::class,'edit'])->name('editproduct');

Route::post('/updateProduct/store',[App\Http\Controllers\ProductController::class,'update'])->name('updateProduct');

Route::get('/productDetail/{id}',[App\Http\Controllers\ProductController::class,'showDetail'])->name('productDetail');

Route::get('/showAllProduct',[App\Http\Controllers\ProductController::class,'productList'])->name('showAllProduct');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/home',[App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

Route::post('addCart',[App\Http\Controllers\CartController::class,'add'])->name('addCart');

Route::get('myCart',[App\Http\Controllers\CartController::class,'showMyCart'])->name('myCart');

Route::post('/checkout', [App\Http\Controllers\PaymentController::class, 'paymentPost'])->name('payment.post');

Route::get('/mainDish',[App\Http\Controllers\ProductController::class,'mainDish'])->name('mainDish');

Route::get('/mainDish/{id}',[App\Http\Controllers\ProductController::class,'showDetail'])->name('productDetail');

Route::get('/sideDish',[App\Http\Controllers\ProductController::class,'sideDish'])->name('sideDish');

Route::get('/sideDish/{id}',[App\Http\Controllers\ProductController::class,'showDetail'])->name('productDetail');

Route::get('/beverage',[App\Http\Controllers\ProductController::class,'beverage'])->name('beverage');

Route::get('/beverage/{id}',[App\Http\Controllers\ProductController::class,'showDetail'])->name('productDetail');

Route::get('/dessert',[App\Http\Controllers\ProductController::class,'dessert'])->name('dessert');

Route::get('/dessert/{id}',[App\Http\Controllers\ProductController::class,'showDetail'])->name('productDetail');

Route::get('/helpAndSupport',[App\Http\Controllers\ProductController::class,'helpAndSupport'])->name('helpAndSupport');

Route::post('/searchProduct',[App\Http\Controllers\ProductController::class,'search'])->name('searchProduct');