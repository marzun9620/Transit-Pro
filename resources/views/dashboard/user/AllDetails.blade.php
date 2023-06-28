@extends('layout')
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <a href="{{ route('admin.showIndividualUsergTrip', ['id' => $user_id]) }}" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">All Previous Trips</h5>
                            <p class="card-text">Click here to view passenger details</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.showIndividualUserUpcomingTrip', ['id' => $user_id]) }}" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">All Upcoming Trips</h5>
                            <p class="card-text">Click here to view passenger details</p>
                        </div>
                    </div>
                </a>
            </div>


           
        </div>
    </div>
@endsection
