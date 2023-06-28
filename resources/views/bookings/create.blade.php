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
            border-color: #080809;
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

        .bus-layout {
            display: flex;
            justify-content: center;
            max-width: 400px;
            margin: 0 auto;
            padding-top: 20px;
            flex-wrap: wrap;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 10px;
        }

        .seat {
            flex: 0 0 50px;
            height: 50px;
            margin: 5px;
            border: 1px solid #ccc;
            text-align: center;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            background-color: #28a745;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .seat:not(.available) {
            background-color: #dc3545;
            color: #fff;
            cursor: not-allowed;
        }

        .seat.selected {
            background-color: #5a32a5;
        }

        .gap {
            flex: 0 0 20px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
        }

        .modal-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
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

        <!-- Sidebar -->
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Selected Seats</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Number of Seats:</strong> <span id="selectedSeatCount">0</span></p>
                        <p><strong>Price:</strong> <span id="selectedSeatPrice">0</span> Tk</p>
                        <p><strong>Selected:</strong></p>
                        <ul id="selectedSeatList"></ul>
                    </div>
                </div>

            </div>

            <!-- Bus Layout -->
            <div class="col-md-9">
                <h2 class="text-center my-4"></h2>

                <form id="bookingForm" action="{{ route('bookings.store',['tarvelId'=>$tarvelId ,'travel_date'=>$travelDate])}}"
                    method="POST">
                    @csrf
                    <div class="bus-layout" style="margin-top: -70px;">
                        @for ($row = 1; $row <= 7; $row++)
                            <div class="row">
                                <div class="seat @if ($bookedSeats && in_array('A' . $row, $bookedSeats)) booked @elseif ($bookedSeats && in_array('A' . $row, $bookedSeats)) selected @else available @endif"
                                    onclick="toggleSeatSelection(this, 'A{{ $row }}')">
                                    <input type="checkbox" name="selected_seats[]" value="A{{ $row }}"
                                        @if ($bookedSeats && in_array('A' . $row, $bookedSeats)) disabled @endif>
                                    A{{ $row }}
                                </div>
                                <!-- Gap after the first column -->
                                @for ($column = 1; $column <= 3; $column++)
                                    <div class="seat @if ($bookedSeats && in_array('B' . $row . $column, $bookedSeats)) booked @elseif ($bookedSeats && in_array('B' . $row . $column, $bookedSeats)) selected @else available @endif"
                                        onclick="toggleSeatSelection(this, 'B{{ $row . $column }}')">
                                        <input type="checkbox" name="selected_seats[]"
                                            value="B{{ $row . $column }}"
                                            @if ($bookedSeats && in_array('B' . $row . $column, $bookedSeats)) disabled
                                        @endif>
                                        B{{ $row . $column }}
                                    </div>
                                    @if ($column == 1 and $column != 0)
                                        <div class="gap"></div>
                                        <!-- Smaller gap after every 2nd column except the last column -->
                                    @endif
                                @endfor
                            </div>
                            <div class="gap"></div>
                            <!-- Gap after every row -->
                        @endfor
                    </div>
                    <button class="btn btn-register" id="bookButton">Book</button>
                </form>
            </div>
        </div>

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; {{ date('Y') }} Transit Pro. All rights reserved.</p>
        </div>
    </footer>

     <!-- Popup Modal -->
     <div id="popupModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h2>Selected Seats</h2>
            <p><strong>Number of Seats:</strong> <span id="selectedSeatCountModal">0</span></p>
            <p><strong>Price:</strong> <span id="selectedSeatPriceModal">0</span> Tk</p>
            <p><strong>Selected:</strong></p>
            <ul id="selectedSeatListModal"></ul>
            <p><strong>Payment Amount:</strong> <span id="paymentAmount">0 Tk</span></p>
            <button class="btn btn-register" id="confirmButton">Confirm and generate Ticket</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <!-- Scripts -->
<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Per seat cost in taka
    var seatCost = 50;

    // Update selected seat count and price
    function updateSelectedSeatInfo() {
        var selectedSeats = $("input[name='selected_seats[]']:checked");
        var seatCount = selectedSeats.length;
        var seatPrice = seatCount * {{ $taka }};

        $("#selectedSeatCount").text(seatCount);
        $("#selectedSeatPrice").text(seatPrice);

        // Update payment information
        var paymentAmount = seatCount > 0 ? {{ $taka }} + " Tk" : "0 Tk";
        $("#paymentAmount").text(paymentAmount);
    }

    // Toggle seat selection
    function toggleSeatSelection(seat, seatNumber) {
        if ($(seat).hasClass("available")) {
            $(seat).toggleClass("selected");
            $(seat).find("input[type='checkbox']").prop("checked", function (i, value) {
                return !value;
            });

            // Add/remove seat number to/from the sidebar
            var selectedSeatList = $("#selectedSeatList");
            if ($(seat).hasClass("selected")) {
                selectedSeatList.append("<li>" + seatNumber + "</li>");
            } else {
                selectedSeatList.find("li:contains('" + seatNumber + "')").remove();
            }

            updateSelectedSeatInfo();
        }
    }

    // Listen for checkbox change events
    $(document).ready(function () {
        $("input[name='selected_seats[]']").change(function () {
            updateSelectedSeatInfo();
        });
    });

    function showPopupModal() {
        var selectedSeats = $("input[name='selected_seats[]']:checked");
        var seatCount = selectedSeats.length;
        var seatPrice = seatCount * {{ $taka }};
        var paymentAmount = seatCount > 0 ? seatPrice + " Tk" : "0 Tk";

        $("#selectedSeatCountModal").text(seatCount);
        $("#selectedSeatPriceModal").text(seatPrice);
        $("#paymentAmount").text(paymentAmount);

        selectedSeats.each(function () {
            var seatNumber = $(this).val();
            $("#selectedSeatListModal").append("<li>" + seatNumber + "</li>");
        });

        $("#popupModal").css("display", "block");
    }

    // Close the popup modal
    $(".modal-close").click(function () {
        $("#popupModal").css("display", "none");
        $("#selectedSeatListModal").empty(); // Clear the selected seat list
    });

    // Trigger the showPopupModal function when the book button is clicked
    $("#bookButton").click(function (event) {
        event.preventDefault(); // Prevent the default form submission
        showPopupModal();
    });

    // Handle the confirmation button click
    $("#confirmButton").click(function () {
        // Submit the form with the post method
        $("form").submit();
    });

</script>


</body>
