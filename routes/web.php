<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WEB\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

Auth::routes();

Route::group([
    'middleware' => ['auth:web'],
], function () {

    //products management
    Route::group([
        'prefix' => 'products',
        'as' => 'product.'
    ], function () {
        Route::get('/', [ProductController::class, 'index'])->name('list');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/get-products', [ProductController::class, 'getAjaxProductData'])->name('get-products');
        Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('delete-product');
        Route::put('/update-product/{id}', [ProductController::class, 'update'])->name('update');
    });
});

