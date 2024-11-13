@extends('layouts.app')

@section('content')
    <h1>Add New Book</h1>
    <div class="col-lg-8">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" name="author" id="author" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" name="isbn" id="isbn" required>
            </div>

            <div class="form-group">
                <label for="publisher">Publisher</label>
                <input type="text" class="form-control" name="publisher" id="publisher" required>
            </div>

            <div class="form-group">
                <label for="publication_year">Publication Year</label>
                <input type="number" class="form-control" name="publication_year" id="publication_year" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="total_quantity">Total Quantity</label>
                <input type="number" class="form-control" name="total_quantity" id="total_quantity" required>
            </div>

            <div class="form-group">
                <label for="available_quantity">Available Quantity</label>
                <input type="number" class="form-control" name="available_quantity" id="available_quantity" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image" id="image">
            </div>

            <button type="submit" class="btn btn-primary">Save Book</button>
        </form>
    </div>
@endsection
