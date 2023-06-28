@extends('layout') <!-- Assuming 'layouts.app' is the name of your layout file -->

@section('content')
   <head>
    <h2 class="text-center title">Create New Trip</h2>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card-body {
            padding: 20px;
        }
        .card-header h2 {
            margin-bottom: 0;
        }
        .sidebar {
            margin-top: 20px;
        }
        .sidebar table {
            width: 100%;
        }
        .sidebar th, .sidebar td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .sidebar-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .sidebar-content {
            flex-grow: 1;
            overflow-y: auto;
        }
        .sidebar-table {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
                 
                </div>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script>
                    $(document).ready(function() {
                        @if ($errors->any())
                            $('#errorModal').modal('show');
                        @endif
                    });
                </script>

                   <!-- Error Modal -->
    <div class="modal" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('buses.fixed.trip.create.added') }}">
                        @csrf
                        <div class="form-group">
                            <label for="starting_point">Departure:</label>
                            <select id="starting_point" name="starting_point" class="form-control" required>
                                <option value="">Select departure city</option>
                                <option value="Bagerhat">Bagerhat</option>
                                <option value="Bandarban">Bandarban</option>
                                <option value="Barguna">Barguna</option>
                                <option value="Barisal">Barisal</option>
                                <option value="Bhola">Bhola</option>
                                <option value="Bogra">Bogra</option>
                                <option value="Brahmanbaria">Brahmanbaria</option>
                                <option value="Chandpur">Chandpur</option>
                                <option value="Chapainawabganj">Chapainawabganj</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Chuadanga">Chuadanga</option>
                                <option value="Comilla">Comilla</option>
                                <option value="Cox's Bazar">Cox's Bazar</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Dinajpur">Dinajpur</option>
                                <option value="Faridpur">Faridpur</option>
                                <option value="Feni">Feni</option>
                                <option value="Gaibandha">Gaibandha</option>
                                <option value="Gazipur">Gazipur</option>
                                <option value="Gopalganj">Gopalganj</option>
                                <option value="Habiganj">Habiganj</option>
                                <option value="Jamalpur">Jamalpur</option>
                                <option value="Jessore">Jessore</option>
                                <option value="Jhalokati">Jhalokati</option>
                                <option value="Jhenaidah">Jhenaidah</option>
                                <option value="Joypurhat">Joypurhat</option>
                                <option value="Khagrachari">Khagrachari</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Kishoreganj">Kishoreganj</option>
                                <option value="Kurigram">Kurigram</option>
                                <option value="Kushtia">Kushtia</option>
                                <option value="Lakshmipur">Lakshmipur</option>
                                <option value="Lalmonirhat">Lalmonirhat</option>
                                <option value="Madaripur">Madaripur</option>
                                <option value="Magura">Magura</option>
                                <option value="Manikganj">Manikganj</option>
                                <option value="Meherpur">Meherpur</option>
                                <option value="Moulvibazar">Moulvibazar</option>
                                <option value="Munshiganj">Munshiganj</option>
                                <option value="Mymensingh">Mymensingh</option>
                                <option value="Naogaon">Naogaon</option>
                                <option value="Narail">Narail</option>
                                <option value="Narayanganj">Narayanganj</option>
                                <option value="Narsingdi">Narsingdi</option>
                                <option value="Natore">Natore</option>
                                <option value="Nawabganj">Nawabganj</option>
                                <option value="Netrokona">Netrokona</option>
                                <option value="Nilphamari">Nilphamari</option>
                                <option value="Noakhali">Noakhali</option>
                                <option value="Pabna">Pabna</option>
                                <option value="Panchagarh">Panchagarh</option>
                                <option value="Patuakhali">Patuakhali</option>
                                <option value="Pirojpur">Pirojpur</option>
                                <option value="Rajbari">Rajbari</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Rangamati">Rangamati</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Satkhira">Satkhira</option>
                                <option value="Shariatpur">Shariatpur</option>
                                <option value="Sherpur">Sherpur</option>
                                <option value="Sirajganj">Sirajganj</option>
                                <option value="Sunamganj">Sunamganj</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Tangail">Tangail</option>
                                <option value="Thakurgaon">Thakurgaon</option>
                                </select>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ending_point">Destination:</label>
                            <select id="ending_point" name="ending_point" class="form-control" required>
                                <option value="">Select departure city</option>
                                <option value="Bagerhat">Bagerhat</option>
                                <option value="Bandarban">Bandarban</option>
                                <option value="Barguna">Barguna</option>
                                <option value="Barisal">Barisal</option>
                                <option value="Bhola">Bhola</option>
                                <option value="Bogra">Bogra</option>
                                <option value="Brahmanbaria">Brahmanbaria</option>
                                <option value="Chandpur">Chandpur</option>
                                <option value="Chapainawabganj">Chapainawabganj</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Chuadanga">Chuadanga</option>
                                <option value="Comilla">Comilla</option>
                                <option value="Cox's Bazar">Cox's Bazar</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Dinajpur">Dinajpur</option>
                                <option value="Faridpur">Faridpur</option>
                                <option value="Feni">Feni</option>
                                <option value="Gaibandha">Gaibandha</option>
                                <option value="Gazipur">Gazipur</option>
                                <option value="Gopalganj">Gopalganj</option>
                                <option value="Habiganj">Habiganj</option>
                                <option value="Jamalpur">Jamalpur</option>
                                <option value="Jessore">Jessore</option>
                                <option value="Jhalokati">Jhalokati</option>
                                <option value="Jhenaidah">Jhenaidah</option>
                                <option value="Joypurhat">Joypurhat</option>
                                <option value="Khagrachari">Khagrachari</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Kishoreganj">Kishoreganj</option>
                                <option value="Kurigram">Kurigram</option>
                                <option value="Kushtia">Kushtia</option>
                                <option value="Lakshmipur">Lakshmipur</option>
                                <option value="Lalmonirhat">Lalmonirhat</option>
                                <option value="Madaripur">Madaripur</option>
                                <option value="Magura">Magura</option>
                                <option value="Manikganj">Manikganj</option>
                                <option value="Meherpur">Meherpur</option>
                                <option value="Moulvibazar">Moulvibazar</option>
                                <option value="Munshiganj">Munshiganj</option>
                                <option value="Mymensingh">Mymensingh</option>
                                <option value="Naogaon">Naogaon</option>
                                <option value="Narail">Narail</option>
                                <option value="Narayanganj">Narayanganj</option>
                                <option value="Narsingdi">Narsingdi</option>
                                <option value="Natore">Natore</option>
                                <option value="Nawabganj">Nawabganj</option>
                                <option value="Netrokona">Netrokona</option>
                                <option value="Nilphamari">Nilphamari</option>
                                <option value="Noakhali">Noakhali</option>
                                <option value="Pabna">Pabna</option>
                                <option value="Panchagarh">Panchagarh</option>
                                <option value="Patuakhali">Patuakhali</option>
                                <option value="Pirojpur">Pirojpur</option>
                                <option value="Rajbari">Rajbari</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Rangamati">Rangamati</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Satkhira">Satkhira</option>
                                <option value="Shariatpur">Shariatpur</option>
                                <option value="Sherpur">Sherpur</option>
                                <option value="Sirajganj">Sirajganj</option>
                                <option value="Sunamganj">Sunamganj</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Tangail">Tangail</option>
                                <option value="Thakurgaon">Thakurgaon</option>
                                </select>

                            </select>
                        </div>

                     <div class="form-group">
                            <label for="bus_id">Bus ID:</label>
                            <input type="number" class="form-control" id="bus_id" name="bus_id" required>
                        </div>

                        <div class="form-group">
                            <label for="staff_id">Staff ID:</label>
                            <input type="number" class="form-control" id="staff_id" name="staff_id" required>
                        </div>

                        <div class="form-group">
                            <label for="seat_cost">Seat Cost:</label>
                            <input type="number" class="form-control" id="seat_cost" name="seat_cost" required>
                        </div>

                        <div class="form-group">
                            <label for="travel_date">Travel Date:</label>
                            <input type="datetime-local" class="form-control" id="travel_date" name="travel_date" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Bus Status:</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="">Status</option>
                                <option value="free">Free</option>
                                <option value="Busy">Busy</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Trip</button>
                    </form>

                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card sidebar">
                <div class="card-header">
                    <h2>Free Buses</h2>
                </div>
                <div class="card-body sidebar-container">
                    <form action="{{ route('buses.fixed.trip.create.allocate') }}" method="GET">
                        <div class="form-group">
                            <label for="bus_type">Search Bus Type:</label>
                            <input type="text" class="form-control" id="bus_type" name="bus_type" placeholder="Enter bus type">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <div class="sidebar-content">
                        <table class="sidebar-table">
                            <thead>
                            <tr>
                                <th>Bus ID</th>
                                <th>Bus Type</th>
                                <th>Agency Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($freeBuses as $bus)
                                <tr>
                                    <td>{{ $bus->bus_id }}</td>
                                    <td>{{ $bus->bus_type }}</td>
                                    <td>{{ $bus->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card sidebar">
                <div class="card-header">
                    <h2>Free Staff</h2>
                </div>
                <div class="card-body sidebar-container">
                    <form action="{{ route('buses.trip.fixed.create.freeStaff') }}" method="GET">
                        <div class="form-group">
                            <label for="first_name">Search Staff Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Name">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <div class="sidebar-content">
                        <table class="sidebar-table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($freeStaff as $staff)
                                <tr>
                                    <td>{{ $staff->id }}</td>
                                    <td>{{ $staff->first_name }} {{ $staff->last_name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@if(session('error'))
<div id="error-popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <p>{{ session('error') }}</p>
    </div>
</div>
<style>
    /* Add CSS styles for the popup */
    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #f1f1f1;
        padding: 20px;
        border: 1px solid #ccc;
        z-index: 9999;
    }

    .popup-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .close {
        cursor: pointer;
    }
</style>
<script>
    function closePopup() {
        document.getElementById('error-popup').style.display = 'none';
    }
</script>
@endif




</body>
@endsection
