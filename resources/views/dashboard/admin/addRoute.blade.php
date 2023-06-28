<!DOCTYPE html>
<html>
<head>
    <title>Bus Reservation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f2f2f2;
            padding-top: 40px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #6c757d;
        }

        .form-label {
            color: #6c757d;
        }

        .form-control {
            background-color: #f8f9fa;
            border-color: #6c757d;
            color: #495057;
        }

        .btn-primary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .bus-view {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
        }

        .bus-seat {
            width: 30px;
            height: 30px;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            margin: 2px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .bus-seat.selected {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Bus Reservation</h1>

    <form class="row g-3"  id="bus_reserve" action="{{ route('buses.save') }}" method="POST">
        @csrf
        <div class="col-md-6">
            <label for="starting_point" class="form-label">Departure:</label>
            <select id="starting_point" name="starting_point" class="form-select" required>
                <option value="">Select departure city</option>
                <option value="Dhaka">Dhaka</option>
                <option value="Chattrogram">Syhlet</option>
                <option value="Syhlet">Chattogram</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="ending_point" class="form-label">Destination:</label>
            <select id="ending_point" name="ending_point" class="form-select" required>
                <option value="">Select destination city</option>
                <option value="Dhaka">Dhaka</option>
                <option value="Chattrogram">Chattrogram</option>
                <option value="syhlet">syhlet</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="travel_date" class="form-label">Date:</label>
            <input type="date" id="travel_date" name="travel_date" class="form-control" required>
        </div>


        <div class="col-12">
            <button type="submit" class="btn btn-primary">Reserve Bus</button>
        </div>
    </form>
</div>

</body>
</html>
