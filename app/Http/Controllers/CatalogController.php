<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class CatalogController extends Controller
{
    public function index()
    {
        // Mengambil semua buku beserta data kategori yang terhubung
        $books = Book::with('category')->get();

        // Mengambil semua kategori untuk filter
        $categories = Category::all();

        // Mengambil daftar tahun publikasi unik
        $years = Book::distinct()->orderBy('publication_year', 'desc')->pluck('publication_year');

        // Mengirim data buku, kategori, dan tahun ke view
        return view('index', compact('books', 'categories', 'years'));
    }

    public function show(Book $book)
    {
        // Fetch the book data along with its associated category
        return view('show', compact('book'));
    }
}
