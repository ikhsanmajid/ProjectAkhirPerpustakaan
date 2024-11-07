@extends('layouts.app')

@section('content')
    <div class="col-12 mt-5">
        <div class="row h-100">
            <div class="d-flex w-100 justify-content-center">
                <div class="card w-50">
                    <div class="card-header text-center fw-bolder">
                        Edit User
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="nama" value="{{ $user->nama }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="is_active" class="form-label">Status Aktif</label>
                                <select id="is_active" name="is_active" class="form-control">
                                    <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" name="role" class="form-control">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>

                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection