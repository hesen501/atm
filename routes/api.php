<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BankNotesController;
use App\Http\Controllers\CashoutController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('users', UserController::class);
Route::resource('currencies', CurrencyController::class);
Route::resource('accounts', AccountController::class);
Route::resource('bank-notes', BankNotesController::class);

Route::post('/cashout', [CashoutController::class, 'index']);
