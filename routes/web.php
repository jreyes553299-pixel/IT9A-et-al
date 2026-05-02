<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\AccountController;

Route::get('/run-migrations-render', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return "Migrations executed: " . nl2br(\Illuminate\Support\Facades\Artisan::output());
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::match(['get', 'post'], '/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account/address', [AccountController::class, 'updateAddress'])->name('account.address');
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile');
    Route::put('/account/security', [AccountController::class, 'updateSecurity'])->name('account.security');
    Route::post('/account/review', [AccountController::class, 'storeReview'])->name('account.review');
    Route::post('/account/order-again/{order}', [AccountController::class, 'orderAgain'])->name('account.order-again');
    
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{id}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('inventory', InventoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('suppliers/{supplier}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('suppliers.toggle-status');
    
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::patch('purchase-orders/{purchase_order}/update-status', [PurchaseOrderController::class, 'updateStatus'])->name('purchase-orders.update-status');

    Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('sales/trends', [SalesController::class, 'trends'])->name('sales.trends');
    Route::get('sales/{order}', [SalesController::class, 'show'])->name('sales.show');
    Route::patch('sales/{order}/update-status', [SalesController::class, 'updateStatus'])->name('sales.update-status');
    Route::delete('sales/{order}', [SalesController::class, 'destroy'])->name('sales.destroy');
});
