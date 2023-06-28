@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @foreach($bookings as $booking)
                    <a href="{{ route('admin.booking.staff', ['travel_id' => $booking->travel_id]) }}" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Staff</h5>
                                <p class="card-text">Click here to view staff details</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="col-md-4">
                @foreach($bookings as $booking)
                    <a href="{{ route('admin.booking.passengers1', ['travel_id' => $booking->travel_id]) }}" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Passengers</h5>
                                <p class="card-text">Click here to view passenger details</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="col-md-4">
                @foreach($bookings as $booking)
                    <a href="{{ route('admin.booking.others', ['travel_id' => $booking->travel_id]) }}" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Others</h5>
                                <p class="card-text">Click here to view other details</p>
                            </div>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
            </div>
        </div>
    </div>
@endsection
