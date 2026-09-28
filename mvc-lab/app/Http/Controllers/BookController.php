<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = ['Clean Code', 'Refactoring'];

        return view('books.index', [
            'books' => $books
        ]);
    }
}
