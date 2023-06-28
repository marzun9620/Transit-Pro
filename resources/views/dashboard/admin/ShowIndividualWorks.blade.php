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
                        @else
                            <p>No trip assigned to this staff.</p>
                        @endif
                        <a href="{{ route('staff.CompletedassignedTrip',['bus_id'=>$assignedTrip->bus_id]) }}" class="btn btn-primary mt-3">Completed</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
