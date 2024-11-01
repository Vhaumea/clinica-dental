<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// USUARIO
Route::get('/configuracion',[UserController::class, 'config'])->name('config');
Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
Route::get('/user/avatar/{filename?}', [UserController::class,'getImage'])->name('user.avatar');

// USUARIOS
Route::get('users/listar', [UsersController::class, 'index'])->name('users.listar');
Route::get('users/crear', [UsersController::class, 'crear'])->name('users.crear');
Route::post('users/crear', [UsersController::class, 'store'])->name('users.store');

Route::get('users/configuracion/{id}', [UsersController::class, 'configuracion'])->name('users.configuracion');
Route::put('users/configuracion/{id}', [UsersController::class, 'update'])->name('users.update');
Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

//PACIENTES
use App\Http\Controllers\PacienteController;
Route::get('pacientes/crear', [PacienteController::class, 'crear'])->name('pacientes.crear');
Route::post('pacientes/crear', [PacienteController::class, 'store'])->name('pacientes.store');
Route::get('pacientes/listar', [PacienteController::class, 'index'])->name('pacientes.listar');
Route::put('/pacientes/update/{id}', [PacienteController::class, 'update'])->name('pacientes.update');
