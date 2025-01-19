@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <div class="row h100">
        <div class="d-flex w-100 justify-content-center">
            <div class="card w-50">
                <div class="card-header text-center fw-bolder">
                    Tambah Kategori
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name">Nama Kategori</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
