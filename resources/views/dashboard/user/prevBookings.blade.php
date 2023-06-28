@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            @if ($bookings->isEmpty())
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert">
                        No bookings found.
                    </div>
                </div>
            @else
                @foreach ($bookings as $booking)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Booking ID: {{ $booking->booking_id }}</h5>
                                <p class="card-text">Starting Point: {{ $booking->starting_point }}</p>
                                <p class="card-text">Ending Point: {{ $booking->ending_point }}</p>
                                <p class="card-text">Travel Date: {{ $booking->travel_date }}</p>
                                <p class="card-text">Bus Type: {{ $booking->bus_type }}</p>
                                <p class="card-text">Agency Name: {{ $booking->name }}</p>
                                <p class="card-text">Tickets: {{ $booking->tickets }}</p>
                                <p class="card-text">Payment: {{ $booking->payment }}</p>
                                <p class="card-text">Seat Cost: {{ $booking->seat_cost }}</p>
                                <span class="badge bg-success">Completed</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
