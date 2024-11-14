@extends('layouts.main')

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Filter</h5>
                </div>
                <div class="card-body">
                    <!-- Filter Kategori -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All Categories</option>
                            <!-- Loop through categories here -->
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tahun -->
                    <div class="mb-3">
                        <label for="year" class="form-label">Publication Year</label>
                        <select class="form-select" id="year" name="year">
                            <option value="">All Years</option>
                            <!-- Loop through years here -->
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Apply Filter Button -->
                    <button class="btn btn-primary w-100" id="apply-filter">Apply Filter</button>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="col-md-4">
                <form method="GET" action="{{-- {{ route('catalog.index') }} --}}" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search books..." value="{{ request()->query('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="row">
                @foreach($books as $book)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" style="width: 100%; height: 300px; object-fit: cover;">
                        <div class="card-body p-2">
                            <h5 class="card-title" style="font-size: 1rem;">{{ $book->title }}</h5>
                            <p class="card-text" style="font-size: 0.85rem;">
                                Author: {{ $book->author }} <br>
                                Category: {{ $book->category->name }} <br>
                                ISBN: {{ $book->isbn }} <br>
                                Published: {{ $book->publication_year }}
                            </p>
                            <a href="{{ route('catalog.show', $book->id) }}" class="btn btn-primary btn-sm">Detail Buku</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
