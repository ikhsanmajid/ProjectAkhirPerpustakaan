<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Book::query();

        //Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('isbn', 'like', '%' . $request->search . '%')
                    ->orWhere('publisher', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filter by year
        $years = Book::distinct()->orderBy('publication_year', 'desc')->pluck('publication_year');
        if ($request->filled('year')) {
            $query->where('publication_year', $request->year);
        }

        // Paginate results and keep filters in the query string
        $books = $query->paginate(12)->appends($request->query());

        // Mengirim data buku, kategori, dan tahun ke view
        return view('index', ['books' => $books, 'categories' => $categories, 'years' => $years]);
    }

    public function show(Book $book)
    {
        // Fetch the book data along with its associated category
        return view('show', compact('book'));
    }
}
