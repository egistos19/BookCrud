<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'author' => 'required|string',
            'isbn' => 'required|string|regex:/^\d{10}(\d{3})?$/|unique:books',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }else{
            $validated['cover_image']='default/book.png';
        }

        Book::create($validated);

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
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'author' => 'required|string',
            'isbn' => 'required|string|regex:/^\d{10}(\d{3})?$/|unique:books,isbn,' . $book->id,
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($request->has('remove_cover_image')&& $book->cover_image!='default/book.png') {
            Storage::disk('public')->delete($book->cover_image);
            $validated['cover_image']='default/book.png';
        }

        if ($request->hasFile('cover_image')) {
            
            if ($book->cover_image && $book->cover_image!='default/book.png') {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.show', $book)->with('success', 'Kitap başarıyla güncellendi.');
    }


    public function destroy(Book $book)
    {
        
        if ($book->cover_image!='default/book.png') {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Kitap başarıyla silindi.');
    }
}
