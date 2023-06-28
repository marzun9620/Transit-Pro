@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Transit_pro</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('products.create') }}">Add New Bus</a>
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                @if ($errors->any())
                    $('#errorModal').modal('show');
                @endif
            });
        </script>

<div class="modal" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('products.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search by Bus ID" value="{{ $search }}">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">Search</button>
                            @if ($search)
                                <a class="btn btn-secondary" href="{{ route('products.index') }}">Clear</a>
                            @endif
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Bus Id</th>
                    <th>Agency Name</th>
                    <th>Agency ID</th>
                    <th>Bus Type</th>
                    <th>Bus Capacity</th>
                    <th>Bus Registration No</th>
                    <th>Bus Fitness</th>
                    <th>Bus Status</th>
                    <th>Action</th>
                    <th>Individual Details</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $product->bus_id }}</td>
                        <td>{{ $product->agency_name }}</td>
                        <td>{{ $product->agency_id }}</td>
                        <td>{{ $product->bus_type }}</td>
                        <td>{{ $product->bus_capacity }}</td>
                        <td>{{ $product->reg_no }}</td>
                        <td>{{ $product->bus_fitness }}</td>
                        <td>{{ $product->status }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-info" href="{{ route('products.show',$product->bus_id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('products.edit',$product->bus_id) }}">Edit</a>
                                <form action="{{ route('products.destroy',$product->bus_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-secondary" href="{{ route('admin.individual.bus.details', $product->bus_id) }}">View Individual Details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
@endsection
