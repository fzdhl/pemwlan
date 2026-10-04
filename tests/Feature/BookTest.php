<?php

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('migration adds isbn column that is required and unique', function () {
    $book = Book::create([
        'title' => 'Test Book',
        'author' => 'Author Name',
        'year' => 2024,
        'isbn' => '978-3-16-148410-0',
    ]);

    expect($book->isbn)->toBe('978-3-16-148410-0');

    // Test unique constraint at database level
    expect(fn () => Book::create([
        'title' => 'Test Book 2',
        'author' => 'Author Name 2',
        'year' => 2024,
        'isbn' => '978-3-16-148410-0',
    ]))->toThrow(Exception::class);
});

test('create page displays isbn input field', function () {
    $response = $this->get(route('books.create'));

    $response->assertStatus(200);
    $response->assertSee('name="isbn"', false);
});

test('edit page displays isbn input field with current value', function () {
    $book = Book::create([
        'title' => 'Existing Book',
        'author' => 'Existing Author',
        'year' => 2021,
        'isbn' => '123-456-789',
    ]);

    $response = $this->get(route('books.edit', $book));

    $response->assertStatus(200);
    $response->assertSee('name="isbn"', false);
    $response->assertSee('123-456-789');
});

test('isbn can be stored through create with validation and shows flash message', function () {
    $response = $this->post(route('books.store'), [
        'title' => 'New Book',
        'author' => 'New Author',
        'year' => 2023,
        'isbn' => '978-1-234-56789-0',
    ]);

    $response->assertRedirect(route('books.index'));
    $response->assertSessionHas('success', 'Buku berhasil ditambahkan.');

    $this->assertDatabaseHas('books', [
        'title' => 'New Book',
        'isbn' => '978-1-234-56789-0',
    ]);

    $followResponse = $this->get(route('books.index'));
    $followResponse->assertSee('Buku berhasil ditambahkan.');
    $followResponse->assertSee('978-1-234-56789-0');
});

test('storing book requires isbn and rejects duplicate isbn', function () {
    Book::create([
        'title' => 'Book 1',
        'author' => 'Author 1',
        'year' => 2020,
        'isbn' => 'DUP-ISBN-123',
    ]);

    // Test required
    $resMissing = $this->post(route('books.store'), [
        'title' => 'Book 2',
        'author' => 'Author 2',
        'year' => 2022,
        'isbn' => '',
    ]);
    $resMissing->assertSessionHasErrors('isbn');

    // Test unique
    $resDuplicate = $this->post(route('books.store'), [
        'title' => 'Book 2',
        'author' => 'Author 2',
        'year' => 2022,
        'isbn' => 'DUP-ISBN-123',
    ]);
    $resDuplicate->assertSessionHasErrors('isbn');
});

test('updating book allows keeping the same isbn without duplicate error and shows flash message', function () {
    $book = Book::create([
        'title' => 'Old Title',
        'author' => 'Old Author',
        'year' => 2019,
        'isbn' => 'SAME-ISBN-999',
    ]);

    $response = $this->put(route('books.update', $book), [
        'title' => 'Updated Title',
        'author' => 'Old Author',
        'year' => 2019,
        'isbn' => 'SAME-ISBN-999',
    ]);

    $response->assertRedirect(route('books.index'));
    $response->assertSessionHas('success', 'Buku berhasil diperbarui.');

    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'title' => 'Updated Title',
        'isbn' => 'SAME-ISBN-999',
    ]);

    $followResponse = $this->get(route('books.index'));
    $followResponse->assertSee('Buku berhasil diperbarui.');
});

test('updating book rejects isbn taken by another book', function () {
    $book1 = Book::create([
        'title' => 'Book 1',
        'author' => 'Author 1',
        'year' => 2020,
        'isbn' => 'ISBN-FIRST',
    ]);

    $book2 = Book::create([
        'title' => 'Book 2',
        'author' => 'Author 2',
        'year' => 2021,
        'isbn' => 'ISBN-SECOND',
    ]);

    $response = $this->put(route('books.update', $book2), [
        'title' => 'Book 2 Updated',
        'author' => 'Author 2',
        'year' => 2021,
        'isbn' => 'ISBN-FIRST',
    ]);

    $response->assertSessionHasErrors('isbn');
});

test('show page displays isbn', function () {
    $book = Book::create([
        'title' => 'Book to View',
        'author' => 'Author',
        'year' => 2022,
        'isbn' => 'VIEW-ISBN-555',
    ]);

    $response = $this->get(route('books.show', $book));

    $response->assertStatus(200);
    $response->assertSee('VIEW-ISBN-555');
});

test('deleting book shows flash message', function () {
    $book = Book::create([
        'title' => 'Book to Delete',
        'author' => 'Author',
        'year' => 2022,
        'isbn' => 'DEL-ISBN-777',
    ]);

    $response = $this->delete(route('books.destroy', $book));

    $response->assertRedirect(route('books.index'));
    $response->assertSessionHas('success', 'Buku berhasil dihapus.');

    $this->assertDatabaseMissing('books', [
        'id' => $book->id,
    ]);

    $followResponse = $this->get(route('books.index'));
    $followResponse->assertSee('Buku berhasil dihapus.');
});
