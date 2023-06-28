@extends('layout')

@section('content')
    <div class="container">
        <h1>User List</h1>
        <form action="{{ route('admin.allStaff') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name or ID"
                       value="{{ $search }}">
                <button type="submit" class="btn btn-primary">Search</button>
                @if ($search)
                    <a href="{{ route('admin.allStaff') }}" class="btn btn-secondary">Clear</a>
                @endif
            </div>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($userList as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('admin.showIndividualStaffDetails', ['id' => $user->id]) }}" class="btn btn-primary">View Details</a>
                    </td>
                </tr>
            @endforeach
            @if ($userList->isEmpty())
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            @endif
            </tbody>
        </table>

        {{ $userList->links() }}
    </div>
@endsection
