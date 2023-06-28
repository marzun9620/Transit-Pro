@extends('layout')

@section('content')
    <div class="container">
        <h1>Individual Booking Details</h1>
        <table class="table">
            <thead>
            <tr>

                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>User ID</th>
                <th>Booking ID</th>
               >
                <th>Seat Details</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->contact_no }}</td>
                    <td>{{ $row->user_id }}</td>
                    <td>{{ $row->booking_id }}</td>

                    <td><a href="{{ route('admin.booking.seats',$row->booking_id) }}">View</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
@endsection
