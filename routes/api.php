<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\LoanController;
use Illuminate\Support\Facades\Route;

## public api routes
Route::post('login',[AuthController::class, 'login']);
Route::get('books', [BookController::class, 'index']);
Route::get('books/{book}', [BookController::class, 'show']);
Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/{author}', [AuthorController::class, 'show']);

## protected api routes
Route::middleware('auth:sanctum')->group(function (){

    // 1. Rutas de Autenticación
    Route::post('/logout',[AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);

    // 2. Gestión de Préstamos (Clientes y Administradores)
    
    Route::get('/loans/me', [LoanController::class, 'indexClient']); // Listar préstamos
    Route::post('/loans', [LoanController::class, 'store']); // Pedir prestado
    Route::put('/loans/{loan}', [LoanController::class, 'returnLoan']); // Devolver (el cliente)

    // 3. Rutas sólo para Administradores
    Route::middleware('abilities:admin')->group(function () {

        // CRUD de Libros (Admin)
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{book}', [BookController::class, 'update']);
        Route::delete('/books/{book}', [BookController::class, 'destroy']);

        // CRUD de Autores (Admin)
        Route::post('/authors', [AuthorController::class, 'store']);
        Route::put('/authors/{author}', [AuthorController::class, 'update']);
        Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

        // Acciones Admin de Préstamos
        Route::get('/loans/{user_id}',[LoanController::class, 'indexUser']);
        Route::get('/loans/all', [LoanController::class, 'indexAdmin']); // Listar préstamos
        //Route::post('/loans/{loan}/return-admin', [LoanController::class, 'returnLoanAdmin']);
    });
});
