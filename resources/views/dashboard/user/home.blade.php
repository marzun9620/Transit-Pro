@extends('layout')

@section('content')
    <div class="card">

        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h2 class="card-title">Welcome {{ Auth::guard('web')->user()->first_name }}</h2>
            <td>
                <form action="{{ route('user.logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </td>


        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">View Trips</h5>
                            <p class="card-text">{{ Auth::guard('web')->user()->first_name }} make a Booking.</p>
                            <a href="{{ route('bus-routes1.search') }}" class="btn btn-primary btn-lg btn-block">Go to Trips</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">View Previous Bookings</h5>
                            <p class="card-text">{{ Auth::guard('web')->user()->first_name }} your existing bookings and check details.</p>
                            <a href="{{ route('user.prevBookings') }}" class="btn btn-success btn-lg btn-block">Go to Bookings</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">View Upcoming Bookings</h5>
                            <p class="card-text">
                                {{ Auth::guard('web')->user()->first_name }} Track your payment history and transaction details.</p>
                            <a href="{{ route('user.futureBookings') }}" class="btn btn-info btn-lg btn-block">Upcoming Bookings</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Profile</h5>
                            <p class="card-text">Manage your personal profile and update information.</p>
                            <a href="{{ route('user.profile',['id'=>Auth::guard('web')->user()->id]) }}" class="btn btn-warning btn-lg btn-block">Go to Profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Messages</h5>
                            <p class="card-text">Check your messages and communicate with support.</p>
                            <a href="}" class="btn btn-secondary btn-lg btn-block">Go to Messages</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Settings</h5>
                            <p class="card-text">Customize your account settings and preferences.</p>
                            <a href="" class="btn btn-dark btn-lg btn-block">Go to Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .card-text {
            margin-bottom: 1.5rem;
        }

        .btn-block {
            border-radius: 10px;
        }
    </style>
@endpush
