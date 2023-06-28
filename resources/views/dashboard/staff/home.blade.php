@extends('layout')

@section('content')
    <div class="card">

        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h2 class="card-title">Welcome {{ Auth::guard('staff')->user()->first_name }}</h2>
            <td>
                <form action="{{ route('staff.logout') }}" method="POST" id="logout-form">
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
                            <h5 class="card-title">Assigned Trips</h5>
                            <p class="card-text">{{ Auth::guard('staff')->user()->first_name }} Assigned Trips.</p>
                            <a href="{{ route('staff.assignedTrip') }}" class="btn btn-primary btn-lg btn-block">ASSIGNED</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Completed Trips</h5>
                            <p class="card-text">{{ Auth::guard('staff')->user()->first_name }} your Completed Trips</p>
                            <a href="{{ route('staff.prevAssignedTrip') }}" class="btn btn-success btn-lg btn-block">COMPLETED</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">View Payments</h5>
                            <p class="card-text">{{ Auth::guard('staff')->user()->first_name }} your payment history and transaction details.</p>
                            <a href="" class="btn btn-info btn-lg btn-block">Go to Payments</a>
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
                            <a href="{{ route('staff.profile',['id'=>Auth::guard('staff')->user()->id]) }}" class="btn btn-warning btn-lg btn-block">Go to Profile</a>
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
                            <h5 class="card-title">Maintenances</h5>
                            <p class="card-text">Add Maintenances of a bus.</p>
                            <a href="{{ route('staff.maintenance') }}" class="btn btn-dark btn-lg btn-block">ADD</a>
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
