<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;

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

Route::get('/', [EventoController::class, 'index']);
Route::get('/eventos/create', [EventoController::class, 'create'])->middleware('auth');
Route::get('/eventos/{id}', [EventoController::class, 'show']);
Route::post('/eventos', [EventoController::class, 'store']);
Route::delete('/eventos/{id}', [EventoController::class, 'destroy'])->middleware('auth');
Route::get('/eventos/edit/{id}', [EventoController::class, 'edit'])->middleware('auth');
Route::put('/eventos/update/{id}', [EventoController::class, 'update'])->middleware('auth');


Route::get('/contatos', function () {
    return view('contatos');
});


Route::get('/dashboard', [EventoController::class, 'dashboard'])->middleware('auth');
Route::post('/eventos/join/{id}', [EventoController::class, 'joinEvento'])->middleware('auth');
Route::delete('/eventos/leave/{id}', [EventoController::class, 'leaveEvent'])->middleware('auth');

Route::get('/produtos', function () {

    $busca = request('search');

    return view('produtos', ['busca' => $busca]);
});


Route::get('/produto/{id}', function ($id) {
    return view('produto', ['id' => $id]);
});