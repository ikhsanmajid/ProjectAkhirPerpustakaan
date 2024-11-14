@extends('layouts.app')

@section('content')
    <div class="col-12 bg-white">

        <div class="row p-3">
            <div class="col-12">
                <h2>Manajemen Buku</h2>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row pb-3">
            <div class="col-12">
                <div class="accordion mb-3" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                                Filter Buku
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <form method="GET" action="{{ route('admin.books.index') }}" class="mb-3">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="search" class="form-label">Cari nama atau email</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" id="search" name="search" class="form-control"
                                                        placeholder="Cari Buku" value="{{ request('search') }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="category" class="form-label">Kategori</label>
                                                </div>
                                                <div class="col-md-10">
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
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="year" class="form-label">Tahun Terbit</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <select id="year" name="year" class="form-control">
                                                        <option value="">Semua Tahun</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-5">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header fw-bold">
                        Daftar Buku
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-success">Tambah Buku</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle table-striped border">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Penulis</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Tahun Terbit</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($books as $book)
                                        <tr>
                                            <th scope="row">
                                                {{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}
                                            </th>
                                            <td><a href="{{ route('admin.books.show', $book->id) }}">{{ $book->title }}</a></td>
                                            <td>{{ $book->author }}</td>
                                            <td>{{ $book->category->name }}</td>
                                            <td>{{ $book->publication_year }}</td>
                                            <td>
                                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-primary">Edit</a>
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $book->id }}, '{{ $book->title }}')">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
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
