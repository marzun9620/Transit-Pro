@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Other Information</h2>
            </div>
            <div class="card-body">
                @foreach ($others as $other)
                    <p>Starting Point: {{ $other->starting_point }}</p>
                    <p>Ending Point: {{ $other->ending_point }}</p>
                    <p>Agency Name: {{ $other->name }}</p>
                    <p>Contact Number: {{ $other->contact_no }}</p>
                    <p>Travel Date: {{ $other->travel_date }}</p>
                    <p>Bus ID: {{ $other->bus_id }}</p>
                    <p>Bus Type: {{ $other->bus_type }}</p>
                @endforeach

                @foreach ($payment as $totalPayment)
                    <p>Total Payment: {{ $totalPayment->{'sum(payment)'} }}</p>
                @endforeach

                @foreach ($ticketCount as $count)
                    <p>Total Tickets: {{ $count->{'count(seat_number)'} }}</p>
                @endforeach
            </div>
        </div>
    </div>
@endsection
