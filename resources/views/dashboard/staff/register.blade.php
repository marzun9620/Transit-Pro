@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Staff Register</div>

                <div class="card-body">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif

                    <form action="{{ route('staff.create') }}" method="post" class="row g-3">
                        @csrf

                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input class="form-control" type="text" id="first_name" name="first_name" placeholder="Enter your First Name" required value="{{ old('first_name') }}">
                            <span class="text-danger">@error('first_name'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input class="form-control" type="text" id="last_name" name="last_name" placeholder="Enter your Last Name" required value="{{ old('last_name') }}">
                            <span class="text-danger">@error('last_name'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" type="email" id="email" name="email" placeholder="Enter your Email" required value="{{ old('email') }}">
                            <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option disabled selected>Choose option</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Others</option>
                            </select>
                            <span class="text-danger">@error('gender'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="contact_no" class="form-label">Contact No</label>
                            <input class="form-control" type="text" id="contact_no" name="contact_no" placeholder="Enter your Contact No" required value="{{ old('contact_no') }}">
                            <span class="text-danger">@error('contact_no'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="district" class="form-label">District</label>
                            <input class="form-control" type="text" id="district" name="district" placeholder="Enter your District" required value="{{ old('district') }}">
                            <span class="text-danger">@error('district'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="ward_no" class="form-label">Ward No</label>
                            <input class="form-control" type="text" id="ward_no" name="ward_no" placeholder="Enter your Ward No" required value="{{ old('ward_no') }}">
                            <span class="text-danger">@error('ward_no'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="thana" class="form-label">Thana</label>
                            <input class="form-control" type="text" id="thana" name="thana" placeholder="Enter your Thana" required value="{{ old('thana') }}">
                            <span class="text-danger">@error('thana'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="house_no" class="form-label">House No</label>
                            <textarea class="form-control" id="house_no" name="house_no" placeholder="Enter your House No" required>{{ old('house_no') }}</textarea>
                            <span class="text-danger">@error('house_no'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Enter your Password" required value="{{ old('password') }}">
                            <span class="text-danger">@error('password'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-md-6">
                            <label for="cpassword" class="form-label">Confirm Password</label>
                            <input class="form-control" type="password" id="cpassword" name="cpassword" placeholder="Enter confirm password" value="{{ old('cpassword') }}">
                            <span class="text-danger">@error('cpassword'){{ $message }}@enderror</span>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                        <br>
                        <a href="{{ route('staff.login') }}">I already have an account, Login now</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
