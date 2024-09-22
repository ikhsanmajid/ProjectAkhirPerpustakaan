@extends('layouts.app')

@section('content')
    <div class="container border bg-light rounded">
        Haii {{Auth::user()->email}}
    </div>
@endsection