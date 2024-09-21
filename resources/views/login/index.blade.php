@extends('layouts.app')

@section('content')
    <div class="vh-100 vw-100" style="background-image: url({{asset('storage/images/background.png')}}); background-repeat: no-repeat; background-size: cover;">
        <div class="d-flex h-100 w-100 justify-content-center align-items-center">
            <div class="card w-25">
                <div class="card-header text-center fw-bolder">
                    Login
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            Tidak punya akun? <a href="/register">Register</a>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
