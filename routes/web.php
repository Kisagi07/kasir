<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

/* Route::get('/', function () {
    return view('welcome');
});
 */
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{cart}', [CartController::class , 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');
Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::get('/transaction/{transaction}', [TransactionController::class, 'show'])->name('transaction.show');
