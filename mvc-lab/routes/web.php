<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookController2;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/books', function () {
//     return 'Daftar buku';
// });

// Route::get('/books', BookController::class, 'index');
Route::resource('/books', BookController2::class);