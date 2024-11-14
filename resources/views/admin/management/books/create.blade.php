@extends('layouts.app')

@section('content')
    <div class="col-12 mt-5">
        <div class="row h100">
            <div class="d-flex w-100 justify-content-center">
                <div class="card w-50">
                    <div class="card-header text-center fw-bolder">
                        Tambah Buku
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="author">Pengarang</label>
                                <input type="text" class="form-control" name="author" id="author" required>
                            </div>

                            <div class="mb-3">
                                <label for="isbn">ISBN</label>
                                <input type="text" class="form-control" name="isbn" id="isbn" required>
                            </div>

                            <div class="mb-3">
                                <label for="publisher">Penerbit</label>
                                <input type="text" class="form-control" name="publisher" id="publisher" required>
                            </div>

                            <div class="mb-3">
                                <label for="publication_year">Tahun Terbit</label>
                                <input type="number" class="form-control" name="publication_year" id="publication_year" required>
                            </div>

                            <div class="mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="total_quantity">Jumlah Total</label>
                                <input type="number" class="form-control" name="total_quantity" id="total_quantity" required>
                            </div>

                            <div class="mb-3">
                                <label for="available_quantity">Jumlah Tersedia</label>
                                <input type="number" class="form-control" name="available_quantity" id="available_quantity" required>
                            </div>

                            <div class="mb-3">
                                <label for="description">Sinopsis</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan Buku</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
