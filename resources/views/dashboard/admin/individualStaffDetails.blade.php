@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('admin.showIndividualAllStaff', ['id' => $staff_id]) }}" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Previous Trips</h5>
                            <p class="card-text">Click here to view staff details</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.showIndividualStaffUpcomingTrip', ['id' => $staff_id]) }}" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Upcoming Any Trip</h5>
                            <p class="card-text">Click here to view passenger details</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Send Some Compensations</h5>
                            <p class="card-text">Click here to view passenger details</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Others</h5>
                            <p class="card-text">Click here to view other details</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Trips</h5>
                        <p class="card-text">{{ $count }}</p> <!-- Display total trips count -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
