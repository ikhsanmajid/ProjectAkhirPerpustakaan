@extends('layouts.app')

@section('content')
    <div class="col-12 mt-5">
        <div class="row h100">
            <div class="d-flex w-100 justify-content-center">
                <div class="card w-50">
                    <div class="card-header text-center fw-bolder">
                        Edit Buku
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title', $book->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="author">Pengarang</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" name="author" id="author" value="{{ old('author', $book->author) }}" required>
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="isbn">ISBN</label>
                                <input type="text" class="form-control @error('isbn') is-invalid @enderror" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" required>
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="publisher">Penerbit</label>
                                <input type="text" class="form-control @error('publisher') is-invalid @enderror" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}" required>
                                @error('publisher')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="publication_year">Tahun Terbit</label>
                                <input type="number" class="form-control @error('publication_year') is-invalid @enderror" name="publication_year" id="publication_year" value="{{ old('publication_year', $book->publication_year) }}" required>
                                @error('publication_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="total_quantity">Jumlah Total</label>
                                <input type="number" class="form-control @error('total_quantity') is-invalid @enderror" name="total_quantity" id="total_quantity" value="{{ old('total_quantity', $book->total_quantity) }}" required>
                                @error('total_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="available_quantity">Jumlah Tersedia</label>
                                <input type="number" class="form-control @error('available_quantity') is-invalid @enderror" name="available_quantity" id="available_quantity" value="{{ old('available_quantity', $book->available_quantity) }}" required>
                                @error('available_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description">Sinopsis</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" required>{{ old('description', $book->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" name="image" id="image">
                                @if ($book->image)
                                    <p>Current Image:</p>
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image" style="width: 150px;">
                                @endif
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">Ubah Buku</button>
                                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
