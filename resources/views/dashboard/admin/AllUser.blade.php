@extends('layout')

@section('content')
    <div class="container">
        <h1>User Data</h1>
        <form action="{{ route('admin.allUser') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name or ID"
                       value="{{ $search }}">
                <button type="submit" class="btn btn-primary">Search</button>
                @if ($search)
                    <a href="{{ route('admin.allUser') }}" class="btn btn-secondary">Clear</a>
                @endif
            </div>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>

                <th>Name</th>
                <th>Id</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>District</th>
                <th>Thana</th>
                <th>House No</th>
                <th>All Bookings</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($userList as $row)
                <tr>
                    <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->gender }}</td>
                    <td>{{ $row->contact_no }}</td>
                    <td>{{ $row->district }}</td>
                    <td>{{ $row->thana }}</td>
                    <td>{{ $row->house_no }}</td>
                    <td>
                        <a href="{{ route('admin.showAllUser', ['id' => $row->id]) }}" class="btn btn-primary">View Details</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
        {{ $userList->appends(['search' => $search])->links() }}
    </div>
@endsection
