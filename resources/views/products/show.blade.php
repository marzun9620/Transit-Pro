@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Show Bus Details</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('products.index') }}">Back</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Bus Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="bus_id"><strong>Bus Id:</strong></label>
                            <span id="bus_id">{{ $product->id }}</span>
                        </div>


                        <div class="form-group">
                            <label for="bus-type"><strong>Bus Type:</strong></label>
                            <span id="bus-type">{{ $product->bus_type }}</span>
                        </div>

                        <div class="form-group">
                            <label for="bus-capacity"><strong>Bus Capacity:</strong></label>
                            <span id="bus-capacity">{{ $product->bus_capacity }}</span>
                        </div>
                        <div class="form-group">
                            <label for="registration-no"><strong>Registration No:</strong></label>
                            <span id="registration-no">{{ $product->reg_no }}</span>
                        </div>
                        <div class="form-group">
                            <label for="bus-fitness"><strong>Fitness:</strong></label>
                            <span id="bus-fitness">{{ $product->bus_fitness }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
