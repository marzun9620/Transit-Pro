@extends('products.layout')

@section('content')
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to Transit Pro</h1>
        <p class="lead">A Bus Management System</p>
        <a href="#" class="btn btn-success btn-lg">Get Started</a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">About Us</h3>
                        <p class="card-text">We are Online Bus Management System. We are Here To simplify Your Journey</p>
                        <a href="#" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Our Services</h3>
                        <p class="card-text">Online Ticketing ,Bus,Train,Aeroplane</p>
                        <a href="#" class="btn btn-primary">View Services</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Contact Us</h3>
                        <p class="card-text">Contact us</p>
                        <a href="#" class="btn btn-primary">Contact Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
