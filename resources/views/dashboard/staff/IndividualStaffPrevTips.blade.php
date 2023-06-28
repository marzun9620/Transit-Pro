@extends('layout')

@section('content')
    <div class="container">
        <form action="{{ route('admin.showIndividualAllStaff',['id'=>$staff_id]) }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="starting_point" class="form-control" placeholder="Starting Point" value="{{ $startingPoint }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="ending_point" class="form-control" placeholder="Ending Point" value="{{ $endingPoint }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="agency_name" class="form-control" placeholder="Agency Name" value="{{ $agencyName }}">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3">
                    <input type="date" name="travel_date" class="form-control datepicker" placeholder="Date" value="{{ $date }}">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('admin.showIndividualAllStaff',['id'=>$staff_id]) }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <div class="row">
            @foreach ($bookings as $index => $booking)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">{{ $booking->name }}</div>
                        <div class="card-body">
                            <span class="card-number">{{ $index + 1 }}</span>
                            <p class="card-text">Starting Point: {{ $booking->starting_point }}</p>
                            <p class="card-text">Ending Point: {{ $booking->ending_point }}</p>
                            <p class="card-text">Travel Date: {{ $booking->travel_date }}</p>
                            <p class="card-text">Travel ID: {{ $booking->travel_id }}</p>
                            <a href="{{ route('admin.booking.details', ['travel_id' => $booking->travel_id]) }}" class="btn btn-primary">Details</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
    </div>

    <style>
        /* Add your custom CSS styles here */
        .form-control {
            /* Add your styles for form control elements */
        }
        .card-number {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>

    <script>
        // Datepicker initialization
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection
