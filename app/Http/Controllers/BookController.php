<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category')->get();
        return view('admin.management.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("admin.management.books.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $validated['image'] = $imagePath;
        }

        // Menyimpan buku ke database
        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('admin.management.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.management.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        // Validasi otomatis menggunakan UpdateBookRequest
        $validated = $request->validated();

        // Proses gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }

            $imagePath = $request->file('image')->store('books', 'public');
            $validated['image'] = $imagePath;
        }

        // Update data buku
        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {

        // Hapus gambar jika ada
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        // Hapus buku
        $book->delete();

        Book::destroy($book->id);
        return redirect()->route('admin.books.index')->with('success', 'Buku Berhasil Dihapus!');
    }
}
