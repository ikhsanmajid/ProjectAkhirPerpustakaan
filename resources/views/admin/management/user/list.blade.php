@extends('layouts.app')

@section('content')
    <div class="col-12 bg-white">

        <div class="row p-3">
            <div class="col-12">
                <h2>Manajemen User</h2>
            </div>
        </div>

        <div class="row pb-3">
            <div class="col-12">
                <div class="accordion mb-3" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                                Filter User
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <form method="GET" action="{{ route('admin.users.list') }}" class="mb-3">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="search" class="form-label">Cari nama, email atau nomor identitas</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" id="search" name="search" class="form-control"
                                                        placeholder="Cari nama, email atau nomor identitas" value="{{ request('search') }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="is_active" class="form-label">Status Aktif</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <select id="is_active" name="is_active" class="form-control">
                                                        <option value="">Semua Status</option>
                                                        <option value="1"
                                                            {{ request('is_active') == '1' ? 'selected' : '' }}>Aktif
                                                        </option>
                                                        <option value="0"
                                                            {{ request('is_active') == '0' ? 'selected' : '' }}>Tidak
                                                            Aktif
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="role" class="form-label">Role</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <select id="role" name="role" class="form-control">
                                                        <option value="">Semua Role</option>
                                                        <option value="admin"
                                                            {{ request('role') == 'admin' ? 'selected' : '' }}>Admin
                                                        </option>
                                                        <option value="user"
                                                            {{ request('role') == 'user' ? 'selected' : '' }}>User
                                                        </option>
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
                        Daftar User
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle table-striped border">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">No Hp</th>
                                        <th scope="col">Identitas</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Status Aktif</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <th scope="row">
                                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                            </th>
                                            <td>{{ $user->first_name." ".$user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->no_hp }}</td>
                                            <td>{{ strtoupper($user->jenis_identitas)." ".$user->nomor_identitas }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                                            <td>
                                                <a href="/admin/users/{{ $user->id }}/edit"
                                                    class="btn btn-primary">Edit</a>
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $user->id }}, '{{ $user->email }}')">Delete</button>
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
                        {{ $users->links() }}
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
                    Apakah Anda yakin ingin menghapus user <span class="fw-bold" id="userEmail"></span>?
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
            });
        @endif


        let deleteUserId;

        function confirmDelete(userId, userEmail) {
            deleteUserId = userId;
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/admin/users/${userId}`;
            document.getElementById('userEmail').innerText = userEmail;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection