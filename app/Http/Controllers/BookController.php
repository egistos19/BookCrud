<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Bookstore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('author')->orderBy('name')->get();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::orderBy('name')->get();
        $bookstores = Bookstore::orderBy('name')->get();
        return view('books.create', compact('authors', 'bookstores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

            if ($request->hasFile('cover_image')) {
                $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
            }
            if ($request->filled('new_author')) {
                $author = Author::firstOrCreate(['name' => $request->input('new_author')]);
                $validated['author_id'] = $author->id;
            }

        $book = Book::create($validated);

        $bookstores = $request->input('bookstores', []);
        $book->bookstores()->sync($bookstores);
        return redirect()->route('books.index')->with('success', 'Kitap eklendi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::orderBy('name')->get();
        $bookstores = Bookstore::orderBy('name')->get();
        return view('books.edit', compact('book', 'authors', 'bookstores'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();
        if ($request->has('remove_cover_image')) {
            if ($book->cover_image && $book->cover_image != 'default/book.png') {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = null;
        }
        if ($request->filled('new_author')) {
            $author = Author::firstOrCreate(['name' => $request->input('new_author')]);
            $validated['author_id'] = $author->id;
        }        

        if ($request->hasFile('cover_image')) {
            
            if ($book->cover_image && $book->cover_image!='default/book.png') {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($validated);
        $bookstores = $request->input('bookstores', []);
        $book->bookstores()->sync($bookstores);
        return redirect()->route('books.show', $book)->with('success', 'Kitap başarıyla güncellendi.');
    }


    public function destroy(Book $book)
    {
        
        if ($book->cover_image && $book->cover_image!='default/book.png') {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Kitap başarıyla silindi.');
    }
}
