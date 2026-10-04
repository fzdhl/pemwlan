@extends('layouts.app') 
 
@section('content') 
    <h1>Edit Buku</h1> 
 
    <form action="{{ route('books.update', $book) }}" method="POST"> 
        @csrf 
        @method('PUT') 
 
        <label for="title">Judul</label> 
        <input 
            id="title" 
            type="text" 
            name="title" 
            value="{{ old('title', $book->title) }}" 
        > 
        @error('title') 
            <div class="error">{{ $message }}</div> 
        @enderror 
 
        <label for="author">Penulis</label> 
        <input 
            id="author" 
            type="text" 
            name="author" 
            value="{{ old('author', $book->author) }}" 
        > 
        @error('author') 
            <div class="error">{{ $message }}</div> 
        @enderror 
 
        <label for="year">Tahun</label> 
        <input 
            id="year" 
            type="number" 
            name="year" 
            value="{{ old('year', $book->year) }}" 
        > 
        @error('year') 
            <div class="error">{{ $message }}</div> 
        @enderror 
 
        <label for="isbn">ISBN</label> 
        <input 
            id="isbn" 
            type="text" 
            name="isbn" 
            value="{{ old('isbn', $book->isbn) }}" 
        > 
        @error('isbn') 
            <div class="error">{{ $message }}</div> 
        @enderror 
 
        <button type="submit">Simpan Perubahan</button> 
        <a href="{{ route('books.index') }}">Batal</a> 
    </form> 
@endsection