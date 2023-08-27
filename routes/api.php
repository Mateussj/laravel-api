<?php

use App\Http\Controllers\ApiExternaController;
use App\Http\Controllers\MatrizController;
use App\Http\Controllers\UsusarioController;
use App\Jobs\FakeUsersJob;
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

Route::get('/posts', [ApiExternaController::class, 'getAll']);
Route::get('/posts/{id}', [ApiExternaController::class, 'findApiExterna']);
Route::resource('/users', UsusarioController::class);
Route::get('/matriz', [MatrizController::class, 'get']);
Route::get('/fake', function () {
    FakeUsersJob::dispatch();
    return response()->json(["message" => 'Tarefa colocar na fila de execução!'], 200);
});