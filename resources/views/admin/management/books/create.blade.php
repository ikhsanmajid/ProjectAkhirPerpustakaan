@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Buku Baru</h2>
    <form action="books/store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>

        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" required>
        </div>

        <div class="mb-3">
            <label for="publisher" class="form-label">Penerbit</label>
            <input type="text" class="form-control" id="publisher" name="publisher" required>
        </div>

        <div class="mb-3">
            <label for="publication_year" class="form-label">Tahun Terbit</label>
            <input type="number" class="form-control" id="publication_year" name="publication_year" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <!-- Contoh opsi kategori, bisa disesuaikan dari database -->
                <option value="1">Fiksi</option>
                <option value="2">Non-Fiksi</option>
                <!-- Tambahkan opsi kategori lain sesuai data -->
            </select>
        </div>

        <div class="mb-3">
            <label for="copies_available" class="form-label">Jumlah Tersedia</label>
            <input type="number" class="form-control" id="copies_available" name="copies_available" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Buku</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Buku</button>
    </form>
</div>
@endsection
