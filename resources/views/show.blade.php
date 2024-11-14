@extends('layouts.main')

@section('content')
    <div class="container mt-4">
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
                        <!-- Borrow Button (conditionally displayed based on authentication) -->
                        @auth
                            @if (Auth::user()->role == 'user')  <!-- Assuming 'user' role is for book borrowers -->
                                <form action="{{-- {{ route('borrow.book', $book->id) }} --}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Pinjam Buku</button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning">Silahkan Login Untuk Pinjam</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
