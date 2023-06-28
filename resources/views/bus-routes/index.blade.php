@extends('layout')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Bus Routes</h2>
            <div class="row">
                @if ($busRoutes->isEmpty())
                <div class="col-md-12">
                    <script>
                        window.onload = function() {
                            showAlert();
                        };

                        function showAlert() {
                            alert('No Bus Routes Found');
                        }
                    </script>
                </div>
                @else
                    @foreach ($busRoutes as $busRoute)
                        @php
                            $busInfo = $busData[$busRoute->id] ?? null;
                        @endphp

                        @if ($busInfo)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $busRoute->starting_point }} to {{ $busRoute->ending_point }}</h5>
                                        <p class="card-text">Bus Type: {{ $busInfo->bus_type }}</p>
                                        <p class="card-text">Cost: {{ $busInfo->seat_cost }} Tk</p>
                                        <p class="card-text">Date: {{ date('d/m/Y', strtotime($busRoute->travel_date)) }}</p>
                                        <p class="card-text">Departure Time: {{ date('H:i:s', strtotime($busRoute->travel_date)) }}</p>

                                        <form action="{{ route('bookings.create') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $busRoute->id }}">
                                            <input type="hidden" name="travel_date" value="{{ $busRoute->travel_date}}">
                                            <button type="submit" class="btn btn-primary btn-block">Book Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
