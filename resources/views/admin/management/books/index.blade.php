@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">List Buku</h1>

        <!-- Menampilkan pesan sukses atau error -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.books.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Ordinary serial number -->
                        <td>
                            <!-- Make the title clickable and redirect to the show page -->
                            <a href="{{ route('admin.books.show', $book->id) }}">{{ $book->title }}</a>
                        </td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->category->name }}</td>
                        <td>
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image" width="50">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Tombol Delete -->
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Publisher</th>
                    <th>Publication Year</th>
                    <th>Category</th>
                    <th>Total Quantity</th>
                    <th>Available Quantity</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->publication_year }}</td>
                        <td>{{ $book->category->name }}</td>
                        <td>{{ $book->total_quantity }}</td>
                        <td>{{ $book->available_quantity }}</td>
                        <td>{{ $book->description }}</td>
                        <td>
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image" width="50">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Tombol Delete -->
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
@endsection
