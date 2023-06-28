<!DOCTYPE html>
<html>
<head>
    <title>Transit Pro - Transportation Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding-top: 3rem;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            margin: 0;
        }

        .header .logout-btn {
            background-color: transparent;
            border: none;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
        }

        .header .logout-btn:hover {
            text-decoration: underline;
        }

        .sidebar {
            background-color: #333;
            color: #fff;
            height: calc(100vh - 4rem);
            overflow-y: auto;
            padding: 1rem;
            width: 20%;
            float: left;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 0.5rem;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 0.75rem;
            transition: background-color 0.3s ease;
        }

        .sidebar ul li a:hover {
            background-color: #555;
        }

        .content {
            padding: 1rem;
            float: left;
            width: 80%;
        }

        .content h2 {
            margin-top: 0;
            margin-bottom: 1.5rem;
        }

        .dashboard-summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .summary-card {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .summary-card h3 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        .card-value {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .recent-activity {
            background-color: #fff;
            padding: 1rem;
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .recent-activity h3 {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-list li {
            margin-bottom: 1rem;
        }

        .activity-time {
            color: #888;
            font-size: 0.875rem;
        }

        .activity-description {
            margin-top: 0.25rem;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            clear: both;
        }

        footer p {
            margin: 0;
        }
        #transitPro {
        cursor: pointer;
    }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="container">
            <div class="headline">
                <h1 id="transitPro">Transit Pro - Transportation Management System</h1>
            </div>
            @yield('content')
        </div>

        <script>
            document.getElementById('transitPro').addEventListener('click', function() {
                window.location.href = "{{ route('home') }}";
            });
        </script>

        <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
    <div class="sidebar">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.allUser') }}">Users</a></li>
            <li><a href="{{ route('admin.allStaff') }}">Staff</a></li>
            <li><a href="{{ route('admin.allBookings') }}">All Completed Trips</a></li>
            <li><a href="{{ route('admin.allUpcomingBookings') }}">All Upcoming Trips</a></li>
            <li><a href="{{ route('buses.fixed.trip.create') }}">Allocate Fixed Trip</a></li>
            <li><a href="{{ route('buses.trip.create') }}">Allocate Special Trip</a></li>
            <li><a href="{{ route('products.index') }}">Buses</a></li>
            <li><a href="{{ route('staff.register') }}">Add Staff</a></li>
            <li><a href="{{ route('admin.agency.list') }}">Agencies</a></li>
            <li><a href="#">Maintenance</a></li>
            <li><a href="{{ route('buses.reserve') }}">Add Route</a></li>
            <li><a href="{{ route('home') }}">Home</a></li>
        </ul>
    </div>
    <div class="content">
        <h2>Welcome, {{ Auth::guard('admin')->user()->first_name }}!</h2>
        <div class="dashboard-summary">
            <div class="summary-card">
                <h3>Total Users</h3>
                <p class="card-value">{{ $userCount }}</p>
            </div>
            <div class="summary-card">
                <h3>Total Staff</h3>
                <p class="card-value">{{ $staffCount }}</p>
            </div>
            <div class="summary-card">
                <h3>Total Trips</h3>
                <p class="card-value">{{ $totalTrips }}</p>
            </div>
        </div>

        <div class="recent-activity">
            <h3>Recent Activity</h3>
            <ul class="activity-list">
                @php
                    $uniqueActivities = [];
                @endphp
                @foreach($recentActivities as $activity)
                    @if (!in_array($activity->activity, $uniqueActivities))
                        <li>
                            <span class="activity-time">{{ $activity->created_at }}</span>
                            <p class="activity-description">{{ $activity->activity }}</p>
                        </li>
                        @php
                            $uniqueActivities[] = $activity->activity;
                        @endphp
                    @endif
                @endforeach
            </ul>
        </div>

    </div>
</div>

<footer class="text-center">
    <div class="container">
        <p>&copy; {{ date('Y') }} Transit Pro. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
