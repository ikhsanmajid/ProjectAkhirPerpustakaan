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

                            <div class="row mb-3">
                                <div class="col-6">
                                    <div">
                                        <label for="first_name" class="form-label">Nama Depan</label>
                                        <input type="text" class="form-control" name="first_name"
                                            value={{ $user->first_name }} id="first_name" required>
                                </div>

                                <div class="col-6">
                                    <div">
                                        <label for="last_name" class="form-label">Nama Belakang</label>
                                        <input type="text" class="form-control" name="last_name"
                                            value={{ $user->last_name }} id="last_name">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-3">
                                    <div">
                                        <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                                        <select class="form-select" name="jenis_identitas" id="jenis_identitas"
                                            value={{ $user->jenis_identitas }}>
                                            <option value="ktp">KTP</option>
                                            <option value="sim">SIM</option>
                                            <option value="kartu_pelajar">Kartu Pelajar</option>
                                            <option value="passport">Passport</option>
                                        </select>
                                </div>

                                <div class="col-9">
                                    <div">
                                        <label for="nomor_identitas" class="form-label">Nomor Kartu Identitas</label>
                                        <input type="text" class="form-control" id="nomor_identitas"
                                            value={{ $user->nomor_identitas }} required>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                    required value={{ $user->email }} required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password">
                            </div>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. Hp</label>
                                <input type="tel" class="form-control" id="no_hp" value={{ $user->no_hp }}
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat">{{ $user->alamat }}</textarea>
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

@section('script-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
            });
        @endif
    </script>
@endsection
