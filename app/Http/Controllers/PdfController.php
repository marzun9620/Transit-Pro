<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{


    public function generate_pdf(Request $request)
{
    $bookingId = $request->id;

    $bookedSeats = DB::select("SELECT distinct s.SEAT_NUMBER
        FROM JOURNEYS j
        INNER JOIN SEATS s ON j.BOOKING_ID = s.BOOKING_ID
        INNER JOIN CONFIRMATIONS C ON C.BOOKING_ID = s.BOOKING_ID
        WHERE j.BOOKING_ID = $bookingId");
        //dd($bookedSeats);

    $data = DB::select("SELECT DISTINCT
        ag.NAME ,
        t.STARTING_POINT,
        t.ENDING_POINT,
        u.FIRST_NAME,
        u.last_name,
        a.travel_date
    FROM
        AGENCIES ag,
        BUSES b,
        USERS u,
        SEATS s,
        BOOKINGS bo,
        JOURNEYS j,
        OWNERSHIPS o,
        TRAVEL t,
        ALLOCATIONS a,
        CONFIRMATIONS c
    WHERE
        j.BOOKING_ID = s.BOOKING_ID
        AND j.TRAVEL_ID = a.TRAVEL_ID
        AND a.TRAVEL_ID = t.ID
        AND c.BOOKING_ID = j.BOOKING_ID
        AND c.USER_ID = u.ID
        AND a.BUS_ID = b.ID
        AND o.BUS_ID = b.ID
        AND o.AGENCY_ID = ag.ID
        AND j.BOOKING_ID = $bookingId");
        $data = $data[0];

    $taka = DB::select("SELECT payment FROM bookings WHERE id = $bookingId");
    $taka = $taka[0]->payment;

    //$bookedSeats = array_column($bookedSeats, 'SEAT_NUMBER');

    $pdf = Pdf::loadView('pdf_invoice', compact('bookedSeats', 'taka', 'data','bookingId'));

    $headers = [
        'Content-Type' => 'application/pdf',
    ];
        //dd($bookedSeats);

    return response()->make($pdf->output(), 200, $headers);
}

    public function download_pdf(){

        $pdf = Pdf::loadView('pdf_invoice');
        return $pdf->download('billing-invoice.pdf');
    }
}
