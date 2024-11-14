<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class CatalogController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->get(); // Retrieve books with category data
        return view('index', compact('books'));
    }
}
