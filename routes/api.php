<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductController;
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

Route::post('/login', [LoginController::class, 'login'])->name('api.login');

//routes with auth
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'products'
], function () {
    Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('get-product-for-edit');
    Route::post('/store-product', [ProductController::class, 'store'])->name('store-product');
    Route::post('/update-product/{id}', [ProductController::class, 'update'])->name('update-product');
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('delete-product');
});

//routes without auth
Route::group([
    'prefix' => 'products'
], function () {
    Route::get('/', [ProductController::class, 'index'])->name('get-product-list');
    Route::get('/show-product/{id}', [ProductController::class, 'show'])->name('show-product');
});

