<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//This Is For Main Welcome Page
Route::get('/welcome', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');


//This Route Is For Admin DashBoard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//This Route Is For Users Registerd Page
Route::get('/users', [UserController::class, 'index'])
    ->name('users.index')
    ->middleware('auth');

//This Is to Show Profile Details
Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile')
    ->middleware('auth');

//This Is for Products Page
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulkDelete');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');


//This Is For Category Add Page
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// This Is For Settings
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
Route::post('/settings/logo', [SettingsController::class, 'updateLogo'])->name('settings.update.logo');


// This Route is For All Products with pagination
Route::get('/all-products', [ProductController::class, 'showAllProducts'])->name('all.products');
Route::get('/', [ProductController::class, 'showAllProducts'])->name('all.products');



