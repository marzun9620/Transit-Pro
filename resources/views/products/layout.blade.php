<!DOCTYPE html>
<html>
<head>
    <title>Transit Pro</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding-top: 3rem;
            margin: 0;
        }

        .navbar {
            background-color: #333;
            color: #fff;
            padding: 1rem;
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: #fff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0;
        }

        .mt-4 {
            margin-top: 4rem;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .section {
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .section-content {
            font-size: 1.2rem;
            color: #666;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            margin-top: 3rem;
        }

        .footer p {
            margin-bottom: 0;
        }

        .login-section {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            margin-top: 3rem;
            text-align: center;
        }

        .login-section .btn {
            margin-right: 1rem;
        }

        .bus-theme {
            background-image: url("egor-litvinov-RlHI0cCNThY-unsplash.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #efefef;
        }

        .bus-theme h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .bus-theme p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .bus-theme a {
            font-size: 1.2rem;
            color: #4f3b3b;
            text-decoration: underline;
        }

        .bus-routes {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .bus-routes .bus-route {
            width: 30%;
            background-color: #ecd3d3;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .bus-routes .bus-route h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .bus-routes .bus-route p {
            font-size: 1.2rem;
            color: #666;
        }
        @media (max-width: 767px) {
    /* Reduce font size of the navigation links for smaller screens */
    .navbar-nav .nav-link {
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    /* Reduce font size of the brand name for smaller screens */
    .navbar-brand {
        font-size: 1.2rem;
    }
}
    </style>
</head>
<body>

<!-- Navigation -->
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="">Transit Pro</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('bus-routes1.search') }}">Search Routes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    @auth('web')
                        <a class="nav-link dropdown-toggle" href="{{ route('user.login') }}" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::guard('web')->user()->first_name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <!-- Dropdown menu items -->
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                    @else
                        <a class="nav-link" href="{{ route('user.login') }}" id="userDropdown" role="button">
                            Register/Login
                        </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- Content -->
<div class="container">
    <div class="bus-theme">
        <div>
            <h2>Welcome to Transit Pro</h2>
            <p>Combine everyone. Make a pro one -- Transit_Pro.</p>
            <p>...An Ultimate guidance for your Trip...</p>
            <a href="#bus-routes">Explore Bus Routes</a>
        </div>
    </div>

    <div class="section" id="bus-routes">
        <h2 class="section-title">Bus Routes</h2>
        <div class="bus-routes">
            <div class="bus-route">
                <h3>Everyday Trips</h3>
                <p>...</p>
                <a href="{{ route('bus-routes1.search') }}">View Details</a>
            </div>
            <div class="bus-route">
                <h3>Never Missed Schedule</h3>
                <p>...</p>
                <a href="{{ route('bus-routes1.search') }}">View Details</a>
            </div>
            <div class="bus-route">
                <h3>Reliable</h3>
                <p>...</p>
                <a href="{{ route('bus-routes1.search') }}">View Details</a>
            </div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Ticket Booking</h2>
        <div class="section-content">
            <p>Need Tickets? Where You want to go???</p>

        </div>
    </div>


    <div class="section">
        <h2 class="section-title">Bus Timetable</h2>
        <div class="section-content">
            <p>Tight Schedule??? No problem The solution is Transit Pro</p>

        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-4 text-center">
    <div class="container">
        <p>&copy; 2023 Transit Pro. All rights reserved.</p>
    </div>
</footer>

<!-- Login Section -->
<div class="login-section">
    <div class="container">
        <h5>Login as:</h5>
        <a class="btn btn-success" href="{{ route('admin.dashboard') }}">Admin</a>
        <a class="btn btn-success" href="{{ route('staff.login') }}">Staff</a>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
