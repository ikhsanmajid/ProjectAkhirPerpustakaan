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
                        <form method="GET" action="{{ route('index') }}" class="mb-3">
                            <!-- Search Field -->
                            <div class="mb-3">
                                <label for="search" class="form-label">Cari nama atau email</label>
                                <input type="text" id="search" name="search" class="form-control" placeholder="Cari Buku" value="{{ request('search') }}">
                            </div>

                            <!-- Category Field -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select id="category" name="category" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}"
                                            {{ request('category') == $category->name ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Year Field -->
                            <div class="mb-3">
                                <label for="year" class="form-label">Tahun Terbit</label>
                                <select id="year" name="year" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}"
                                            {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    @forelse ($books as $book)
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img class="card-img-top" src="{{ asset('storage/' . $book->image) }}"
                                    alt="{{ $book->title }}" style="width: 100%; height: 300px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <h5 class="card-title" style="font-size: 1rem;">{{ $book->title }}</h5>
                                    <p class="card-text" style="font-size: 0.85rem;">
                                        Author: {{ $book->author }} <br>
                                        Category: {{ $book->category->name }} <br>
                                        ISBN: {{ $book->isbn }} <br>
                                        Published: {{ $book->publication_year }}
                                    </p>
                                    <a href="{{ route('catalog.show', $book->id) }}" class="btn btn-primary btn-sm">Detail
                                        Buku</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-center">Tidak ada buku ditemukan.</p>
                        </div>
                    @endforelse
                </div>
                <div class="card-footer d-flex justify-content-center">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
