@extends('layout')

@section('content')
    <div class="container">
        <h1>Bus Id- {{ $busId }}</h1>
        <div class="payment">
            <h2>Trips</h2>
            <p>{{ $data->travel_count }}</p>
        </div>


        <div class="payment">
            <h2>Payment Amount</h2>
            <p>{{ $data->total_payment }}</p>
        </div>

    </div>
@endsection
