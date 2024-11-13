@extends('layouts.app')
@section('content')

<div class="container">
    <h2 class="mb-4">Daftar Buku</h2>
    <a href="/books/create" class="btn btn-primary mb-3">Tambah Buku Baru</a>

    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection
