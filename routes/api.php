<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomePageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('san-pham/{slug_productCat?}', [ProductController::class, 'list'])->name('category-product')->where('slug_productCat', '.*');
Route::post('loc-san-pham.html', [ProductController::class, 'filter'])->name('filter_product');
Route::get('danh-sach-san-pham', [ProductController::class, 'litsProduct'])->name('product-list');
Route::post('loc-gia-san-pham.html', [ProductController::class, 'price'])->name('price_product');
Route::get('client/components/sidebar-productCat', [ProductController::class, 'category_product'])->name('category');
Route::get('client/components/sidebar-productCat', [HomePageController::class, 'list'])->name('category');
Route::get('chi-tiet-san-pham/{id}', [ProductController::class, 'detailProduct'])->name('detailProduct');
//search