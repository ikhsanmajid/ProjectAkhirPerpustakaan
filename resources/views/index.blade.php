@extends('layouts.main')

@section('content')

<div class="container my-4">
    <div class="row">
        @foreach($books as $book)
        <div class="col-md-2 mb-4">
            <div class="card">
                <img class="card-img-top" src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" style="width: 100%; height: 250px; object-fit: cover;">
                <div class="card-body p-2">
                    <h5 class="card-title" style="font-size: 1rem;">{{ $book->title }}</h5>
                    <p class="card-text" style="font-size: 0.85rem;">
                        Author: {{ $book->author }} <br>
                        Category: {{ $book->category->name }} <br>
                        ISBN: {{ $book->isbn }} <br>
                        Published: {{ $book->publication_year }}
                    </p>
                    <a href="#" class="btn btn-primary btn-sm">Detail Buku</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
