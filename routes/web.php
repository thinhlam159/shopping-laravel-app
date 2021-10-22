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
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});
//Route::prefix('categories')->group(function() {
////    Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
////    Route::get('create', [
////        'as' => 'categories.create',
////        'uses' => 'App\Http\Controllers\CategoryController@create'
////    ]);
//    Route::resource(App\Http\Controllers\CategoryController::class);
//});
Route::prefix('admin')->group(function() {
    Route::resource('categories',App\Http\Controllers\CategoryController::class);
    Route::resource('menu',App\Http\Controllers\MenuController::class);
    Route::resource('product',App\Http\Controllers\AdminProductController::class);

    Route::get('/login', 'App\Http\Controllers\AdminController@loginAdmin');
    Route::post('/login', 'App\Http\Controllers\AdminController@postLoginAdmin');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
