<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('index');

Route::get('/about-us', function () {
    return Inertia::render('AboutUs');
})->name('about-us');


Route::post('/set-theme', [ThemeController::class, 'setTheme'])->name('set-theme');
Route::get('/get-theme', [ThemeController::class, 'getTheme'])->name('get-theme');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::post('/store-order', [CartController::class, 'storeOrder'])->name('store-order');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::middleware('auth')->group(function () {
    Route::get('/profile-old', [ProfileController::class, 'indexOld'])->name('profile-old');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/store-address', [ProfileController::class, 'storeAddress'])->name('store-address');
    Route::put('/update-address', [ProfileController::class, 'updateAddress'])->name('update-address');
    Route::delete('/delete-address', [ProfileController::class, 'deleteAddress'])->name('delete-address');
    Route::put('/add-to-favorite', [MenuController::class, 'addToFavorite'])->name('add-to-favorite');
    Route::put('/remove-from-favorite', [MenuController::class, 'removeFromFavorite'])->name('remove-from-favorite');

    Route::get('/admin', [OrderController::class, 'index'])->name('admin.index')->middleware('role:admin');
    Route::put('/order-update/{order}', [OrderController::class, 'update'])->name('order.update')->middleware('role:admin');
    Route::resource('/admin/categories', CategoryController::class)->middleware('role:admin');
    Route::resource('/admin/ingredients', IngredientController::class)->middleware('role:admin');
    Route::resource('/admin/products', ProductController::class)->middleware('role:admin');
});





require __DIR__.'/auth.php';
