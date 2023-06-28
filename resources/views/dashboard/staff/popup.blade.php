@extends('layout')

@section('content')
    <!-- Your existing HTML code -->

    @if (is_null($assignedTrip))
        <script>
            window.onload = function() {
                alert('No assigned trips.');
            };
        </script>
    @endif
@endsection
