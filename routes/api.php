<?php

use App\Http\Controllers\Api\AssociateController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SuperAdminController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ZaloController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/add-transaction', [TransactionController::class, 'store']);
Route::post('/deduct-money-from-user-wallet/{id}/{deductionMoney}', [TransactionController::class, 'deductMoneyFromAdminWallet']);
<<<<<<< HEAD
Route::post('/add-associate', [AssociateController::class, 'store']);
Route::post('delete-associate', [AssociateController::class, 'delete']);
Route::post('update-associate', [AssociateController::class, 'update']);
Route::post('add-zalo', [ZaloController::class, 'addZalo']);
Route::post('add-message', [MessageController::class, 'addMessage']);
Route::get('/get-banners', [SuperAdminController::class, 'getBanner']);
=======
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
