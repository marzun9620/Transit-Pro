@extends('layout')

@section('content')
    <div class="container">

        <h1>User booking Info</h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>User ID</th>
                <th>Booking Id</th>
                <th>Travel Id</th>
                <th>Bus Id</th>
                <th>From</th>
                <th>To</th>
                <th>Payment</th>
                <th>Date</th>

            </tr>
            </thead>
            <tbody>
            @foreach($query as $row)
                <tr>
                    <td>{{ $row->user_id }}</td>
                    <td>{{ $row->booking_id }}</td>
                    <td>{{ $row->travel_id }}</td>
                    <td>{{ $row->bus_id }}</td>
                    <td>{{ $row->starting_point }}</td>
                    <td>{{ $row->ending_point }}</td>
                    <td>{{ $row->payment }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->allocation_date)) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
