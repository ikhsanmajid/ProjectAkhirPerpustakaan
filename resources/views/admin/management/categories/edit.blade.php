@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <div class="row h100">
        <div class="d-flex w-100 justify-content-center">
            <div class="card w-50">
                <div class="card-header text-center fw-bolder">
                    Edit Kategori
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
