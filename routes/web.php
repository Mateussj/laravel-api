<?php

use App\Http\Controllers\MatrizController;
use App\Http\Controllers\UsusarioController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/matriz', [MatrizController::class, 'get']);
Route::resource('crud/users', UsusarioController::class);

Route::get('/fake', function () {
    Artisan::call('db:seed', [
        '--class' => 'UserSeeder',
        '--force' => true,
    ]);

    return 'Seeder executado!';
});
