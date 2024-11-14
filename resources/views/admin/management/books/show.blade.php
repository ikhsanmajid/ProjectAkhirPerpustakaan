@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class=""> Detail - {{ $book->title }}</h1>

        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Buku</a>
        <div class="row">
            <!-- Left Column: Image -->
            <div class="col-md-4 d-flex justify-content-center align-items-center">
                <img class="img-fluid" src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" style="width: 80%; height: auto; object-fit: cover;">
            </div>

            <!-- Right Column: Description -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title h1">{{ $book->title }}</h5>
                        <p class="card-text">
                            <p><strong>Author:</strong> {{ $book->author }}</p>
                            <p><strong>Category:</strong> {{ $book->category->name }}</p>
                            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                            <p><strong>Publisher:</strong> {{ $book->publisher }}</p>
                            <p><strong>Published Year:</strong> {{ $book->publication_year }}</p>
                            <p><strong>Description:</strong> <br>{{ $book->description }}</p>
                        </p>
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
