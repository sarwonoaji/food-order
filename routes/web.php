<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderAdminController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/aK92LpQwEr/{table}', [ProductController::class, 'scanTable']);

Route::get('/', [ProductController::class, 'index']);
Route::post('/cart/add/{id}', [CartController::class, 'add']);
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/remove/{id}', [CartController::class, 'remove']);
Route::post('/cart/remove-one/{id}', [CartController::class, 'removeOne']);
Route::post('/checkout', [CartController::class, 'checkout']);
Route::get('/order/{id}', [CartController::class, 'showOrder']);
Route::post('/save-name', [ProductController::class, 'saveName']);

Route::resource('/admin/products', ProductAdminController::class);
Route::get('/admin/products', [ProductAdminController::class, 'index']);    
Route::get('/admin/products/create', [ProductAdminController::class, 'create']);
Route::post('/admin/products', [ProductAdminController::class, 'store']);   

Route::get('/admin/qrcodes', [QrCodeController::class, 'index'])->name('admin.qrcodes.index');
Route::get('/admin/qrcodes/create', [QrCodeController::class, 'create'])->name('admin.qrcodes.create');
Route::post('/admin/qrcodes', [QrCodeController::class, 'store'])->name('admin.qrcodes.store');
Route::get('/admin/qrcodes/{id}/edit', [QrCodeController::class, 'edit'])->name('admin.qrcodes.edit');
Route::put('/admin/qrcodes/{id}', [QrCodeController::class, 'update'])->name('admin.qrcodes.update');
Route::delete('/admin/qrcodes/{id}', [QrCodeController::class, 'destroy'])->name('admin.qrcodes.destroy');
Route::get('/admin/qrcodes/{id}', [QrCodeController::class, 'show'])->name('admin.qrcodes.show');


Route::get('/admin/orders', [OrderAdminController::class, 'index']);
Route::get('/admin/orders/{id}', [OrderAdminController::class, 'show']);
Route::post('/admin/orders/{id}/status', [OrderAdminController::class, 'updateStatus']);
Route::get('/admin/orders/{id}/print',[OrderAdminController::class, 'print']);