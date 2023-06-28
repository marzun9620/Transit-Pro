@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Staff Profile</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                @if ($user)
                                    <h4>{{ $user->first_name }}</h4>
                                    <p><strong>Email:</strong> {{ $user->email }}</p>
                                    <p><strong>Phone:</strong> {{ $user->contact_no }}</p>
                                    <p><strong>Address:</strong> {{ $user->district }}</p>
                                    <p><strong>City:</strong> {{ $user->thana }}</p>
                                    <p><strong>Country:</strong> {{ $user->house_no }}</p>
                                @else
                                    <p>Staff not found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
