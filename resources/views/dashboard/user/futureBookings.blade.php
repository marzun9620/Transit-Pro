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
                        <div class="card rounded">
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
                                <div class="col-md-6">

                                    <a href="{{ route('user.thanks',['id'=>$booking->booking_id]) }}" class="btn btn-secondary">View Seats</a>
                                </div>
                                <div class="countdown-wrapper">
                                    <span id="countdown-{{ $booking->booking_id }}" class="badge bg-danger rounded-pill countdown"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <style>
        .countdown-wrapper {
            text-align: center;
            margin-top: 1rem;
        }

        .countdown {
            font-size: 2rem;
            padding: 0.5rem 1rem;
        }

        .card {
            font-family: 'Arial', sans-serif;
        }
    </style>

    <script>
        // Update countdown for each booking
        @foreach ($bookings as $booking)
            // Set the travel date and booking ID
            var travelDate{{ $booking->booking_id }} = new Date('{{ $booking->travel_date }}').getTime();
            var countdownElement{{ $booking->booking_id }} = document.getElementById('countdown-{{ $booking->booking_id }}');

            // Update the countdown every second
            var countdown{{ $booking->booking_id }} = setInterval(function() {
                // Get current date and time
                var now = new Date().getTime();

                // Calculate the remaining time
                var distance = travelDate{{ $booking->booking_id }} - now;

                // Calculate days, hours, minutes, and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Format the countdown
                var countdownText = "";
                if (days > 0) countdownText += days + "d ";
                if (hours > 0) countdownText += hours + "h ";
                if (minutes > 0) countdownText += minutes + "m ";
                countdownText += seconds + "s";

                // Display the countdown
                countdownElement{{ $booking->booking_id }}.textContent = countdownText;

                // Check if the countdown has ended
                if (distance < 0) {
                    clearInterval(countdown{{ $booking->booking_id }});
                    countdownElement{{ $booking->booking_id }}.innerHTML = "Expired";
                }
            }, 1000);
        @endforeach
    </script>
@endsection
