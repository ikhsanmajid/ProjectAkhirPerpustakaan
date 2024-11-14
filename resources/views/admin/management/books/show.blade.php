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
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $book->id }}, '{{ $book->title }}')">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-2" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus buku <span class="fw-bold" id="bookTitle"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form id="deleteForm" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-js')
    <script>
        let deleteBookId;

        function confirmDelete(bookId, bookTitle) {
            deleteBookId = bookId;
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/admin/books/${bookId}`;
            document.getElementById('bookTitle').innerText = bookTitle;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection
