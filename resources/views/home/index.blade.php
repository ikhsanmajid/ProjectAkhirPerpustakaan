@extends('layouts.app')

@section('content')
<div class="container border bg-light rounded">
        <h1>Selamat Datang </h1>
        <h1>{{Auth::user()->email}}</h1>
        <h1>Ini adalah Halaman Admin</h1>
    </div>
@endsection
