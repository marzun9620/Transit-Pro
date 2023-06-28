<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transit Pro - Invoice</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding-top: 3rem;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo img {
            max-width: 200px;
            height: auto;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .invoice-header h1 {
            margin: 0;
            color: #000;
        }

        .invoice-details {
            margin-bottom: 2rem;
        }

        .invoice-details p {
            margin: 0.2rem 0;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 0.5rem;
        }

        .invoice-total {
            text-align: right;
            font-weight: bold;
        }

        .signature {
            margin-top: 2rem;
            text-align: right;
        }

        .signature p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="path/to/logo.png" alt="Transit Pro Logo">
        </div>

        <div class="invoice-header">
            <h1>Transit Pro - Ticket</h1>
        </div>

        <div class="invoice-details">
            <p><strong>Booking Id:</strong> {{ $bookingId}}</p>
            <p><strong>Agency:</strong> {{ $data->name }}</p>
            <p><strong>Journey Date:</strong> {{ $data->travel_date }}</p>
            <p><strong>From:</strong> {{ $data->starting_point }}</p>
            <p><strong>To:</strong> {{ $data->ending_point }}</p>
            <p><strong>Passenger Name:</strong> {{ $data->first_name }}  {{ $data->last_name }}</p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Seat Numbers</th>
                    <th>Per Seat Cost</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @foreach($bookedSeats as $seat)
                            {{ $seat->seat_number }},
                        @endforeach
                    </td>
                    <td>{{ $taka / count($bookedSeats) }} Tk</td>

                </tr>
            </tbody>
        </table>



        <div class="invoice-total">
            <p><strong>Total:</strong>{{ count($bookedSeats) * $taka / count($bookedSeats) }} Tk</p>
        </div>

        <div class="signature">
            <p>Authorized Signature</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
