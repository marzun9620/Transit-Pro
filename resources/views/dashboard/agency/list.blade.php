@extends('layout')

@section('content')
    <div class="container">

        <h1>User Data</h1>
        <div class="mb-3">
            <a href="{{ route('agency.add') }}" class="btn btn-primary">Add Agency</a>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Agency Id</th>
                <th>Agency Name</th>
                <th>Contact No</th>
                <th>Email</th> <!-- New column -->
            </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->contact_no }}</td>
                    <td>{{ $row->email }}</td>
                    <td>
                        <a href="{{ route('admin.individualAgency1',['id'=>$row->id]) }}" class="btn btn-primary">View Details</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
@endsection
