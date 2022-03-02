<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DespesasController;
use App\Http\Controllers\UsersController;
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

Route::get('login', ['as' => 'login', function () {
    return response(['error' => 'Não autorizado'], 401);
}]);
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [UsersController::class, 'store']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('despesas', [DespesasController::class, 'index']);
    Route::get('despesa/{id}', [DespesasController::class, 'show']);
    Route::post('despesa', [DespesasController::class, 'store']);
    Route::put('despesa/{id}', [DespesasController::class, 'update']);
    Route::delete('despesa/{id}', [DespesasController::class, 'destroy']);

    Route::get('users', [UsersController::class, 'index']);
    Route::get('user/{id}', [UsersController::class, 'show']);
    Route::put('user/{id}', [UsersController::class, 'update']);
    Route::delete('user/{id}', [UsersController::class, 'destroy']);
});
