@extends('layout')

@section('title', 'Thank You')

@section('content')
    <h1>Thank You!</h1>
    <p>Thank you for booking the tickets!</p>
    <a href="{{ route('user.home') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
