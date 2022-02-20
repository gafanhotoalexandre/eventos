<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
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

Route::get('/', [EventController::class, 'index'])->name('events.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
});

Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

Route::middleware(['auth'])->group(function (){
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::delete('events/{id}', [EventController::class, 'destroy'])->name('events.destroy');  
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');

    Route::post('events/{id}/join', [EventController::class, 'joinEvent'])->name('events.join-events');
    Route::delete('events/{id}/leave', [EventController::class, 'leaveEvent'])->name('events.leave-events');
});

// Route::get('/dashboard', [EventController::class, 'dashboard'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', [EventController::class, 'dashboard'])->name('dashboard');
    

    
Route::fallback(function () {
    echo '<a href="'. route('events.index') .'">Clique aqui</a> para voltar à página inicial';
});