<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;
use Illuminate\Support\Facades\DB;
use App\Exports\OrdersExport;
use App\Exports\ProductsExport;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminSliderController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminPermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\IntroduceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PaymentController;

use Maatwebsite\Excel\Facades\Excel;
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
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('auth.login'); 
    })->name('admin');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
// Route::group(['prefix' => 'laravel-filemanager'], //--'middleware' => ['web', 'auth']]--,
// function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
    
// });

Route::get('/',[HomePageController::class, 'list'])->name('homePage');
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'show'])->name('dashboard');


 //Route::middleware('auth')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('admin', [DashboardController::class, 'show']);
    Route::get('admin/users/list', [AdminUserController::class, 'list'])->middleware('can:user.list');
    Route::get('admin/users/add', [AdminUserController::class, 'add'])->middleware('can:user.add');
    Route::post('admin/users/store', [AdminUserController::class, 'store']);
    Route::get('admin/users/action', [AdminUserController::class, 'action']);
    Route::get('admin/users/delete/{user}', [AdminUserController::class, 'delete_user'])->name('delete_user')->middleware('can:user.delete');
    Route::get('admin/users/edit/{user}', [AdminUserController::class, 'edit'])->name('user.edit')->middleware('can:user.edit');
    Route::post('admin/users/update/{user}', [AdminUserController::class, 'update'])->name('user.update');
    Route::get('admin/users/role', [AdminUserController::class, 'create']);
    
    //page
    Route::get('admin/pages/list', [AdminPageController::class, 'list'])->middleware('can:page.list');
    Route::get('admin/pages/add', [AdminPageController::class, 'add'])->middleware('can:page.add');
    Route::get('admin/pages/action', [AdminPageController::class, 'action']);
    Route::post('admin/pages/store', [AdminPageController::class, 'store']);
    Route::get('admin/pages/edit/{id}', [AdminPageController::class, 'edit'])->name('page.edit')->middleware('can:page.edit');
    Route::get('admin/pages/delete/{id}', [AdminPageController::class, 'delete_page'])->name('delete_page')->middleware('can:page.delete');
    Route::post('admin/pages/update/{id}', [AdminPageController::class, 'update'])->name('page.update');
    //post
    Route::get('admin/posts/list', [AdminPostController::class, 'list'])->middleware('can:post.list');
    Route::get('admin/posts/add', [AdminPostController::class, 'add'])->middleware('can:post.add');
    Route::get('admin/posts/action', [AdminPostController::class, 'action']);
    Route::post('admin/posts/store', [AdminPostController::class, 'store']);
    Route::get('admin/posts/edit/{id}', [AdminPostController::class, 'edit'])->name('post.edit')->middleware('can:post.edit');
    Route::get('admin/posts/delete/{id}', [AdminPostController::class, 'delete_page'])->name('delete_post')->middleware('can:post.delete');
    Route::post('admin/posts/update/{id}', [AdminPostController::class, 'update'])->name('post.update');
    
    Route::get('admin/posts/cat/list', [AdminPostController::class, 'listCat']);
    Route::get('admin/posts/cat/add', [AdminPostController::class, 'list_add_Cat']);
    Route::post('admin/posts/storeCat', [AdminPostController::class, 'storeCat']);
    Route::get('admin/posts/cat/delete/{id}', [AdminPostController::class, 'delete_cat'])->name('delete_cat_post');
    Route::get('admin/posts/cat/edit/{id}', [AdminPostController::class, 'editCat'])->name('post_cat.edit');
    Route::post('admin/posts/cat/update/{id}', [AdminPostController::class, 'updateCat'])->name('post_cat.update');
    
    //product
    Route::get('admin/products/list', [AdminProductController::class, 'list'])->middleware('can:product.list');//can('product.list')
    Route::get('admin/products/add', [AdminProductController::class, 'add'])->middleware('can:product.add');
    Route::get('admin/products/action', [AdminProductController::class, 'action']);
    Route::post('admin/products/store', [AdminProductController::class, 'store']);
    Route::get('admin/products/edit/{id}', [AdminProductController::class, 'edit'])->name('product.edit')->middleware('can:product.edit');
    Route::get('admin/products/delete/{id}', [AdminProductController::class, 'delete_page'])->name('delete_post')->middleware('can:product.delete');
    Route::post('admin/products/update/{id}', [AdminProductController::class, 'update'])->name('product.update');
    
    Route::get('admin/products/cat/list', [AdminProductController::class, 'listCat']);
    Route::get('admin/products/cat/add', [AdminProductController::class, 'addCat']);
    Route::post('admin/products/cat/store', [AdminProductController::class, 'storeCat']);
    Route::get('admin/products/cat/edit/{id}', [AdminProductController::class, 'editCat'])->name('productCat.edit');
    Route::get('admin/products/cat/delete/{id}', [AdminProductController::class, 'delete_productCat'])->name('delete_productCat');
    Route::post('admin/products/cat/update/{id}', [AdminProductController::class, 'updateCat'])->name('productCat.update');
    
    //slider
    Route::get('admin/sliders/list', [AdminSliderController::class, 'list'])->middleware('can:slider.list');
    Route::get('admin/sliders/add', [AdminSliderController::class, 'add'])->middleware('can:slider.add');
    Route::get('admin/sliders/action', [AdminSliderController::class, 'action']);
    Route::post('admin/sliders/store', [AdminSliderController::class, 'store']);
    Route::get('admin/sliders/edit/{id}', [AdminSliderController::class, 'edit'])->name('slider.edit')->middleware('can:slider.edit');
    Route::get('admin/sliders/delete/{id}', [AdminSliderController::class, 'delete_page'])->name('delete_slider')->middleware('can:slider.delete');
    Route::post('admin/sliders/update/{id}', [AdminSliderController::class, 'update'])->name('slider.update');
    
    //banner
    Route::get('admin/banners/list', [AdminBannerController::class, 'list'])->middleware('can:banner.list');
    Route::get('admin/banners/add', [AdminBannerController::class, 'add'])->middleware('can:banner.add');
    Route::get('admin/banners/action', [AdminBannerController::class, 'action']);
    Route::post('admin/banners/store', [AdminBannerController::class, 'store']);
    Route::get('admin/banners/edit/{id}', [AdminBannerController::class, 'edit'])->name('banner.edit')->middleware('can:banner.edit');
    Route::get('admin/banners/delete/{id}', [AdminBannerController::class, 'delete_banner'])->name('delete_banner')->middleware('can:banner.delete');
    Route::post('admin/banners/update/{id}', [AdminBannerController::class, 'update'])->name('banner.update');
    
    //menu
    
    Route::get('admin/menus/list', [AdminMenuController::class, 'list'])->middleware('can:menu.list');
    Route::get('admin/menus/add', [AdminMenuController::class, 'add'])->middleware('can:menu.add');
    Route::get('admin/menus/action', [AdminMenuController::class, 'action']);
    Route::post('admin/menus/store', [AdminMenuController::class, 'store']);
    Route::get('admin/menus/edit/{id}', [AdminMenuController::class, 'edit'])->name('menu.edit')->middleware('can:menu.edit');
    Route::get('admin/menus/delete/{id}', [AdminMenuController::class, 'delete_menu'])->name('delete_menu')->middleware('can:menu.delete');
    Route::post('admin/menus/update/{id}', [AdminMenuController::class, 'update'])->name('menu.update');

    //order
    Route::get('admin/orders/list', [AdminOrderController::class, 'list'])->middleware('can:order.list');
    Route::get('admin/orders/edit/{id}', [AdminOrderController::class, 'edit'])->name('order.edit')->middleware('can:order.edit');
    Route::get('admin/orders/action', [AdminOrderController::class, 'action']);
    Route::get('admin/orders/delete/{id}', [AdminOrderController::class, 'delete_order'])->name('delete_order')->middleware('can:order.delete');

    //role
     Route::post('vai-tro', [AdminRoleController::class, 'phanvaitro'])->name('phanvaitro');
     Route::get('admin/role/add', [AdminRoleController::class, 'add'])->name('role.add')->middleware('can:role.add');
     Route::get('admin/role/list', [AdminRoleController::class, 'list'])->name('role.list')->middleware('can:role.list');
     Route::post('admin/role/store', [AdminRoleController::class, 'store'])->name('role.store');
     Route::get('admin/role/edit/{role}', [AdminRoleController::class, 'edit'])->name('role.edit')->middleware('can:role.edit');
     Route::post('admin/role/update/{role}', [AdminRoleController::class, 'update'])->name('role.update');
     Route::get('admin/role/delete/{role}', [AdminRoleController::class, 'delete'])->name('role.delete')->middleware('can:role.delete');

    // //permission
    Route::get('admin/permission/add', [AdminPermissionController::class, 'add'])->name('permission.add')->middleware('can:permission.add');
    Route::post('admin/permission/store', [AdminPermissionController::class, 'store'])->name('permission.store');
    Route::get('admin/permission/delete/{id}', [AdminPermissionController::class, 'delete'])->name('permission.delete')->middleware('can:permission.delete');
    Route::get('admin/permission/list', [AdminPermissionController::class, 'list'])->middleware('can:permission.list');
    Route::get('admin/permission/edit/{id}', [AdminPermissionController::class, 'edit'])->name('permission.edit')->middleware('can:permission.edit');
    Route::post('admin/permission/update/{id}', [AdminPermissionController::class, 'update'])->name('permission.update');
 //});

///product

//Route::get('danh-muc', 'ProductController@list')->name('category-product');
Route::get('san-pham/{slug_productCat?}', [ProductController::class, 'list'])->name('category-product')->where('slug_productCat', '.*');
Route::post('loc-san-pham.html', [ProductController::class, 'filter'])->name('filter_product');
Route::get('danh-sach-san-pham', [ProductController::class, 'litsProduct'])->name('product-list');
Route::post('loc-gia-san-pham.html', [ProductController::class, 'price'])->name('price_product');
Route::get('client/components/sidebar-productCat', [ProductController::class, 'category_product'])->name('category');
Route::get('client/components/sidebar-productCat', [HomePageController::class, 'list'])->name('category');
Route::get('chi-tiet-san-pham/{id}', [ProductController::class, 'detailProduct'])->name('detailProduct');
//search
Route::post('tim-liem-san-pham.html', [ProductController::class, 'search'])->name('search_product');

///blog và trang 
Route::get('Danh-sach-bai-viet.html', [BlogController::class, 'list'])->name('list_blog');
Route::get('chi-tiet-bai-viet/{id}', [BlogController::class, 'detail_blog'])->name('detail_blog');
Route::get('trang-gioi-thieu.html', [IntroduceController::class, 'list'])->name('introduce');
Route::get('trang-lien-he.html', [IntroduceController::class, 'contact'])->name('contact');

//giỏ hàng
Route::get('them-gio-hang/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('them-gio-hang./{id}', [CartController::class, 'add_cart_detail'])->name('add_cart_detail');
Route::get('gio-hang.html', [CartController::class, 'list'])->name('cart.list');
Route::get('xoa-san-pham/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('client/store', [CartController::class, 'store'])->name('cart.store');
Route::get('xoa-tat-ca-san-pham.html', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('client/update', [CartController::class, 'update'])->name('cart.update');
Route::post('add-to-cart-ajax', [CartController::class, 'add_cart_ajax'])->name('add_cart_ajax');
Route::post('ajax-shopping-cart', [CartController::class, 'ajax_shopping_cart'])->name('ajax_shopping_cart');

Route::middleware(['client.auth'])->group(function () {
    // Các route yêu cầu đăng nhập để mua hàng
    Route::get('nhap-thong-tin-thanh-toan.html', [CartController::class, 'checkout'])->name('checkout');
    Route::post('mua-hang-thanh-cong.html', [CartController::class, 'thankyou'])->name('thankyou');
});
//ajax thông tinkh
// Route::get('/get-provinces', [CartController::class, 'getProvinces'])->name('getProvinces');
Route::get('get-districts/{province_id}', [CartController::class, 'getDistricts'])->name('getDistricts');
Route::get('get-wards/{district_id}', [CartController::class, 'getWards'])->name('getWards');
Route::get('403', function () {
    return view('errors.403');
});
//Route::get('guimail.html', [CartController::class, 'checkout'])->name('checkout');
Route::get('loginClient', [HomePageController::class, 'loginClient'])->name('loginClient');
Route::get('logoutClient', [HomePageController::class, 'logoutClient'])->name('logoutClient');
Route::get('registerClient', [HomePageController::class, 'registerClient'])->name('registerClient');

// // Trang admin
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('auth', 'admin');

// Trang client
Route::get('/client/home', function () {
    return view('client.home');
})->name('client.home')->middleware('auth', 'client');

//payment vnpay
Route::get('/vnpay_payment', [CartController::class, 'vnpay_payment'])->name('vnpay_payment');
// routes/web.php
Route::get('/vnpay_return', [CartController::class, 'vnpayReturn']);

//review
Route::post('/review/store', [ProductController::class, 'storeReview'])->name('review.store');

//excel
Route::get('admin/orders/export', function () {
    return Excel::download(new OrdersExport, 'orders.xlsx');
})->name('orders.export');

Route::get('admin/products/export', function () {
    return Excel::download(new ProductsExport, 'products.xlsx');
})->name('products.export');