<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TransactionController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/buy-currency', [TransactionController::class, 'buyCurrency']);
Route::middleware('auth:sanctum')->post('/sell-currency', [TransactionController::class, 'sellCurrency']);
Route::middleware('auth:sanctum')->get('/summary', [TransactionController::class, 'summary']);
Route::middleware('auth:sanctum')->get('/currencies', [CurrencyController::class, 'index']);
