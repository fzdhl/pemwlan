<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController2 extends Controller
{
   public function index() 
    { 
        $books = Book::latest()->get(); 
 
        return view('books.index', compact('books')); 
    } 
 
    public function create() 
    {
        return view('books.create'); 
    }

    public function store(Request $request) 
    { 
        // Diisi pada tahap berikutnya. 
    } 
 
    public function show(Book $book) 
    { 
        return view('books.show', compact('book')); 
    } 
 
    public function edit(Book $book) 
    { 
        // Diisi pada tahap update. 
    } 
 
    public function update(Request $request, Book $book) 
    { 
        // Diisi pada tahap update. 
    } 
 
    public function destroy(Book $book) 
    { 
        // Diisi pada tahap delete. 
    } 
}