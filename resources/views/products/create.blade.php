@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Add New Bus</h2>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('products.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="agency">Agency:</label>
                                <select name="id" class="form-control">
                                    <option value="">Select Agency</option>
                                    @foreach ($data as $agency)
                                        <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="bus_type">Bus Type:</label>
                                <input type="text" name="bus_type" class="form-control" placeholder="Bus Type">
                            </div>

                            <div class="form-group">
                                <label for="bus_capacity">Bus Capacity:</label>
                                <input type="number" name="bus_capacity" class="form-control" placeholder="Capacity">
                            </div>

                            <div class="form-group">
                                <label for="reg_no">Registration No:</label>
                                <input type="text" name="reg_no" class="form-control" placeholder="Registration No">
                            </div>

                            <div class="form-group">
                                <label for="bus_fitness">Bus Fitness:</label>
                                <input type="text" name="bus_fitness" class="form-control" placeholder="Fitness">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
