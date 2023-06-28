<?php

namespace App\Http\Controllers;

use App\Models\Confirmation;
use App\Models\Journey;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Seat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    public function create(Request $request)
{
    $tarvelId = $request->id;

    $travelDate = $request->travel_date;

    // Escape the values to prevent SQL injection
    $escapedTravelId = intval($tarvelId);
    $escapedTravelDate = date('Y-m-d', strtotime($travelDate));

        $query = "SELECT * FROM journeys WHERE travel_id = $escapedTravelId AND TRAVEL_DATE =  TO_DATE('$escapedTravelDate','YYYY-MM-DD')";
        $bus = DB::select($query);
        $taka = DB::select("select seat_cost from allocations where travel_id=$escapedTravelId");
        $taka = $taka[0]->seat_cost;


    if (!$bus) {
        $bookedSeats = ['A'];
        return view('bookings.create', compact('bus', 'tarvelId', 'bookedSeats', 'travelDate','taka'));
    }

    $query = "SELECT seat_number
        FROM travel, journeys, bookings, seats
        WHERE journeys.travel_id = :travelId
          AND bookings.id = journeys.booking_id
          AND bookings.id = seats.booking_id
          AND TRUNC(TRAVEL_DATE) = '$escapedTravelDate'";

    $bookedSeats = DB::select($query, ['travelId' => $tarvelId]);
    $bookedSeats = array_column($bookedSeats, 'seat_number');

    return view('bookings.create', compact('bus', 'bookedSeats', 'tarvelId', 'travelDate','taka'));
}


public function showIndivigualBookedSeats(){
        $userId=Auth::guard('web')->user()->id;
        $query="select
        unique SEAT_NUMBER
    from
        BUSES b,TRAVEL t,CONFIRMATIONS c, JOURNEYS j,
        BOOKINGS bo,USERS u,ALLOCATIONS a,SEATS s,OWNERSHIPS o,
        AGENCIES ag
        where
            s.BOOKING_ID=bo.ID
and
            bo.ID=c.BOOKING_ID
and
            c.USER_ID= :userId
and
           bo.ID=j.BOOKING_ID
and
            j.TRAVEL_ID=t.ID
and
            a.TRAVEL_ID=t.ID
and
            a.BUS_ID=b.ID
and
            b.ID=o.BUS_ID
and
            o.AGENCY_ID=ag.ID";

    $bookedSeats = DB::select($query, ['c.user_id' => $userId]);
    dd($bookedSeats);
}

public function prevBookings(){
    $userID=Auth::guard('web')->user()->id;
    $query = DB::select("SELECT DISTINCT
    c.BOOKING_ID, STARTING_POINT, ENDING_POINT, j.TRAVEL_DATE, BUS_TYPE, ag.NAME, (bo.PAYMENT / a.SEAT_COST) as Tickets, bo.PAYMENT, a.SEAT_COST
FROM
    BUSES b, TRAVEL t, CONFIRMATIONS c, JOURNEYS j,
    BOOKINGS bo, USERS u, ALLOCATIONS a, SEATS s, OWNERSHIPS o,
    AGENCIES ag
WHERE
    s.BOOKING_ID = bo.ID
    AND bo.ID = c.BOOKING_ID
    AND c.USER_ID = $userID
    AND bo.ID = j.BOOKING_ID
    AND j.TRAVEL_ID = t.ID
    AND a.TRAVEL_ID = t.ID
    AND a.BUS_ID = b.ID
    AND b.ID = o.BUS_ID
    AND o.AGENCY_ID = ag.ID
    AND a.STATUS = 'completed'");

    $bookings = collect($query);

    return view('dashboard.user.prevBookings', compact('bookings'));
}

    public function futureBookings(){
    $userID=Auth::guard('web')->user()->id;

    $query = DB::select("SELECT DISTINCT
    c.BOOKING_ID, STARTING_POINT, ENDING_POINT, a.TRAVEL_DATE, BUS_TYPE, ag.NAME, (bo.PAYMENT / a.SEAT_COST) as Tickets, bo.PAYMENT, a.SEAT_COST
FROM
    BUSES b, TRAVEL t, CONFIRMATIONS c, JOURNEYS j,
    BOOKINGS bo, USERS u, ALLOCATIONS a, SEATS s, OWNERSHIPS o,
    AGENCIES ag
WHERE
    s.BOOKING_ID = bo.ID
    AND bo.ID = c.BOOKING_ID
    AND c.USER_ID = $userID
    AND bo.ID = j.BOOKING_ID
    AND j.TRAVEL_ID = t.ID
    AND a.TRAVEL_ID = t.ID
    AND a.BUS_ID = b.ID
    AND b.ID = o.BUS_ID
    AND o.AGENCY_ID = ag.ID
    AND a.STATUS = 'Busy'");

        $bookings = collect($query);

        return view('dashboard.user.futureBookings', compact('bookings'));
    }








    public function store(Request $request)
{
    $selectedSeats = $request->input('selected_seats');
$travelID = $request->input('tarvelId');
$travelDate = $request->input('travel_date');
$escapedTravelDate = date('Y-m-d', strtotime($travelDate));
$busId = null;

$existingBooking = DB::select("
    SELECT  c.BOOKING_ID, a.bus_id
    FROM BOOKINGS b
    INNER JOIN JOURNEYS j ON j.BOOKING_ID = b.id
    INNER JOIN CONFIRMATIONS c ON c.BOOKING_ID = b.id
    INNER JOIN USERS u ON u.ID = c.USER_ID
    INNER JOIN allocations a ON a.travel_id = j.travel_id
    WHERE j.TRAVEL_ID = :travelId
    AND TRUNC(j.TRAVEL_DATE) = TO_DATE(:travelDate, 'YYYY-MM-DD')
    AND u.ID = :userId",
    [
        'travelId' => $travelID,
        'travelDate' => $escapedTravelDate,
        'userId' => Auth::guard('web')->user()->id
    ]
);



    // Check if a booking exists for the user, bus, and trip combination
    if ($existingBooking) {
        // Reuse the existing booking ID
        $booking = Booking::find($existingBooking[0]->booking_id);
        $busId = $existingBooking[0]->bus_id;
    } else {
        // Create a new booking
        $booking = new Booking();
        $booking->save();

        $journey = new Journey();
        $journey->booking_id = $booking->id;
        $journey->travel_id = $travelID;
        $journey->travel_date = $escapedTravelDate; // Set the travel date
        // Retrieve the bus ID for the given travel ID
        $result = DB::select("SELECT bus_id FROM allocations WHERE travel_id = :travelId", ['travelId' => $travelID]);

        if (!empty($result)) {
            $busId = $result[0]->bus_id;
        }
        $journey->bus_id = $busId;
        $journey->save();
    }

    // Book the selected seats
    foreach ($selectedSeats as $seatNumber) {
        $seat = new Seat();
        $seat->seat_number = $seatNumber;
        $seat->booking_id = $booking->id; // Assign the journey ID to the seat

        // Save the seat and associate it with the booking
        $booking->seats()->save($seat);
    }

    $query = DB::select("SELECT SEAT_COST FROM allocations WHERE TRAVEL_ID = :travelId", ['travelId' => $travelID]);
    $seatcost = $query[0]->seat_cost;
    $totalPayment = count($selectedSeats) * intval($seatcost);

    $booking->payment += $totalPayment;
    $booking->booking_time = now();
    $booking->save();

    $confirmation = new Confirmation();
    $confirmation->booking_id = $booking->id;
    $confirmation->user_id = Auth::guard('web')->user()->id;
    $confirmation->save();

    return redirect()->route('user.thanks',['id'=>$booking->id]);
}



    }

