@extends('layout')

@section('content')
    <div class="container">
        <h1>Booking Details - Staff</h1>

        <div class="row">
            @foreach ($data as $staff)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $staff->first_name }} {{ $staff->last_name }}</h5>
                            <p class="card-text">Email: {{ $staff->email }}</p>
                            <p class="card-text">Staff ID: {{ $staff->id }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
