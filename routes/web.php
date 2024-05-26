<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\ProductController;
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


Route::get('/old_welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::post('/set-theme', [ThemeController::class, 'setTheme'])->name('set-theme');
Route::get('/get-theme', [ThemeController::class, 'getTheme'])->name('get-theme');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin', function (){
        return Inertia::render('Admin/Index');
    })->name('admin.index')->middleware('role:admin');
    Route::resource('/admin/categories', CategoryController::class)->middleware('role:admin');
    Route::resource('/admin/ingredients', IngredientController::class)->middleware('role:admin');
    Route::resource('/admin/products', ProductController::class)->middleware('role:admin');
});



require __DIR__.'/auth.php';
