<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
   public function index() 
    { 
        $books = Book::latest()->get(); 
 
        return view('books.index2', compact('books')); 
    } 
 
    public function create() 
    {
        return view('books.create'); 
    }

    public function store(Request $request) 
    { 
        $validated = $request->validate([ 
            'title' => ['required', 'string', 'max:255'], 
            'author' => ['required', 'string', 'max:150'], 
            'year' => ['required', 'integer', 'between:1900,2100'], 
        ]); 
    
        Book::create($validated); 
    
        return redirect() 
            ->route('books.index') 
            ->with('success', 'Buku berhasil ditambahkan.'); 
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