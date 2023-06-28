@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            @forelse ($bookings as $booking)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Agency Name: {{ $booking->name }}</p>
                            <p class="card-text">Starting Point: {{ $booking->starting_point }}</p>
                            <p class="card-text">Ending Point: {{ $booking->ending_point }}</p>
                            <p class="card-text">Travel Date: {{ $booking->travel_date }}</p>
                            <p class="card-text">Bus Type: {{ $booking->bus_type }}</p>
                            <span class="badge bg-success">Completed</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p>No assigned trips</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
