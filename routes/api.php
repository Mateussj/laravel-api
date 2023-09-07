<?php

use App\Http\Controllers\ApiExternaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MatrizController;
use App\Http\Controllers\PostsController;
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
Route::middleware(['auth.bearer'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/matriz', [MatrizController::class, 'get']);
    Route::get('/posts-externo', [ApiExternaController::class, 'getAll']);
    Route::get('/posts-externo/{id}', [ApiExternaController::class, 'findApiExterna']);
    Route::resource('/users', UsusarioController::class);
    Route::get('/fake', function () {
        FakeUsersJob::dispatch();
        return response()->json(["message" => 'Tarefa colocada na fila de execução, você pode acompanhar a quantidade de usuarios criada pelo indicador abaixo!'], 200);
    });
    Route::resource('/posts', PostsController::class);
    Route::get('/posts-personalizado/{perPage}', [PostsController::class, 'findAll']);
});

Route::post('/register', [UsusarioController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);