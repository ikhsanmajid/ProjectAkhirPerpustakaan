@extends('layouts.app')

@section('content')
<div class="container border bg-light rounded">
        <h1>{{Auth::user()->email}}</h1>
    </div>
@endsection
