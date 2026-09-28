<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/books', function () {
//     return 'Daftar buku';
// });

Route::get('/books', [BookController::class, 'index']);