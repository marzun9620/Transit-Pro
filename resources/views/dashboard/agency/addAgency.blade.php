@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Add Agency</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('agencies.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Agency Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" name="contact_no" id="contact_no" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Agency</button>
                            </div>
                        </form>
                        <a href="{{ route('admin.agency.list') }}" class="btn btn-secondary mt-3">Back</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
