@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Assigned Trip</h2>
                    </div>
                    <div class="card-body">
                        @if ($assignedTrip)
                            <p><strong>Bus ID:</strong> {{ $assignedTrip->bus_id }}</p>
                            <p><strong>Departure:</strong> {{ $assignedTrip->starting_point }}</p>
                            <p><strong>Destination:</strong> {{ $assignedTrip->ending_point }}</p>
                            <p><strong>Travel Date:</strong> {{ date('d/m/Y', strtotime($assignedTrip->travel_date)) }}</p>
                            <p><strong>Departure Time:</strong> {{ date('H:i:s', strtotime($assignedTrip->travel_date)) }}</p>
                            <p><strong>Trip Status:</strong> {{ $assignedTrip->status }}</p>

                            <div id="countdown" class="countdown">Trip starts in: <span id="countdown-timer"></span></div>
                        @else
                            <p>No trip assigned to this staff.</p>
                            <button class="btn btn-primary mt-3" onclick="showNoTripPopup()">OK</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showNoTripPopup() {
            alert('No assigned trips found.');
        }

        // Countdown timer
        document.addEventListener('DOMContentLoaded', function() {
            @if ($assignedTrip)
                var departureTime = new Date('{{ $assignedTrip->travel_date }}').getTime();
                var countdownElement = document.getElementById('countdown-timer');

                var countdownTimer = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = departureTime - now;

                    if (distance <= 0) {
                        clearInterval(countdownTimer);
                        countdownElement.innerHTML = 'Trip has started!';
                        document.getElementById('countdown').classList.remove('countdown');
                        document.getElementById('countdown').classList.add('countdown-started');
                        // You can perform any other action here when the trip starts
                    } else {
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countdownElement.innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
                    }
                }, 1000);
            @endif
        });
    </script>
@endsection

<style>
    .countdown {
        color: green;
    }

    .countdown-started {
        color: gray;
        font-weight: bold;
    }
</style>
