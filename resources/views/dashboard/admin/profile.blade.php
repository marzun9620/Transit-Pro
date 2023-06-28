<!DOCTYPE html>
<html>
<head>
    <title>Transit Pro - Admin Profile Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding-top: 3rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #333;
            color: #fff;
            padding: 1.5rem;
        }

        .card-title {
            margin-bottom: 0;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 0;
        }

        .btn-register {
            background-color: #6f42c1;
            border-color: #6f42c1;
            border-radius: 0;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .btn-register:hover {
            background-color: #5a32a5;
            border-color: #5a32a5;
        }

        .text-danger {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            margin-top: 4rem;
        }

        footer p {
            margin-bottom: 0;
        }

        .headline {
            background-color: #000;
            color: #fff;
            padding: 1rem;
            border: 2px solid #000;
            margin-bottom: 2rem;
        }

        .headline h1 {
            margin: 0;
        }

        .profile {
            background-color: #fff;
            padding: 2rem;
            border-radius: 5px;
        }

        .profile .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .profile .profile-header .profile-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .profile .profile-header .profile-logout {
            text-decoration: none;
            color: #dc3545;
            font-size: 0.875rem;
        }

        .profile .profile-info {
            margin-bottom: 2rem;
        }

        .profile .profile-info .info-label {
            font-weight: bold;
        }

        .profile .profile-info .info-value {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<!-- Content -->
<div class="container">
    <div class="headline">
        <h1>Transit Pro</h1>
    </div>

    <div class="profile">
        <div class="profile-header">
            <h4 class="profile-title">Admin Profile Dashboard</h4>
            <a href="{{ route('admin.logout') }}" class="profile-logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
            <form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form>
        </div>

        <div class="profile-info">
            <div class="info-label">Name:</div>
            <div class="info-value">{{ Auth::guard('admin')->user()->first_name }}</div>

            <div class="info-label">Email:</div>
            <div class="info-value">{{ Auth::guard('admin')->user()->email }}</div>

            <div class="info-label">Phone:</div>
            <div class="info-value">{{ Auth::guard('admin')->user()->phone }}</div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center">
    <div class="container">
        <p>&copy; {{ date('Y') }} Transit Pro. All rights reserved.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
