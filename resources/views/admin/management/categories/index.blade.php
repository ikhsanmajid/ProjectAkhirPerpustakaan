@extends('layouts.app')

@section('content')
<div class="col-12 bg-white py-2 rounded-3">
    <div class="row p-3">
        <div class="col-12">
            <h2>Category Management</h2>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="row pb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header fw-bold">
                    Daftar Category
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Tambah Kategori Baru</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle table-striped border">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')">Delete</button>
                                            {{-- <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                    Apakah Anda yakin ingin menghapus kategori  <span class="fw-bold" id="categoryName"></span>?
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
        let deleteCategoryId;

        function confirmDelete(categoryId, categoryName) {
            deleteCategoryId = categoryId;
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/admin/categories/${categoryId}`;
            document.getElementById('categoryName').innerText = categoryName;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection
