<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transit Pro</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding-top: 3rem;
        }

        .container {
            max-width: 1200px;
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



    #transitPro {
        cursor: pointer;
    }


    </style>
</head>
<body>
<!-- Content -->
<div class="container">
    <div class="headline">
        <h1 id="transitPro">Transit Pro</h1>
    </div>
    @yield('content')
</div>

<script>
    document.getElementById('transitPro').addEventListener('click', function() {
        window.location.href = "{{ route('home') }}";
    });
</script>


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
