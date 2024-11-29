@extends('layouts.main')

@section('content')
    <div class="h-100 w-100 m mt-5">
        <div class="d-flex h-100 w-100 justify-content-center align-items-center">
            <div class="card-wrapper w-100 px-3">
                <div class="card mx-auto" style="max-width: 500px;">
                    <div class="card-header text-center fw-bolder">
                        Login
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                            @if (Session::has('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <div class="mb-3">
                                Tidak punya akun? <a href="/register">Register</a>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
