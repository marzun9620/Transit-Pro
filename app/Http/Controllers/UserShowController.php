<?php

namespace App\Http\Controllers;
use App\Models\Staff;
use App\Models\User;
use DB;

use Illuminate\Http\Request;


class UserShowController extends Controller
{

    public function fulllist(Request $request)
    {
        $search = $request->input('search');

        $userList = User::query();

        if ($search) {
            if (is_numeric($search)) {
                $userList->where('id', $search);
            } else {
                $searchTerm = '%' . strtolower($search) . '%';

                $userList->where(function ($query) use ($searchTerm) {
                    $query->whereRaw("LOWER(first_name) LIKE ?", [$searchTerm])
                        ->orWhereRaw("LOWER(last_name) LIKE ?", [$searchTerm]);
                });
            }
        }

        $userList = $userList->paginate(10);
        return view('dashboard.admin.AllUser', compact('userList', 'search'));
    }

    function allbookings(Request $request){

        $userid = $request->input('id');
        $query=DB::select("select confirmations.user_id,confirmations.booking_id,allocation.allocation_date,journeys.bus_id,starting_point,ending_point,payment,allocation.travel_id
from
    USERS,CONFIRMATIONS,BOOKINGS,JOURNEYS,TRAVEL,BUSES,STAFF,ALLOCATION
where
    users.ID= :userid
    and
    users.ID=CONFIRMATIONS.USER_ID
    and
    CONFIRMATIONS.BOOKING_ID=BOOKINGS.ID
    and
    BOOKINGS.ID=JOURNEYS.BOOKING_ID
    and
    JOURNEYS.TRAVEL_ID=TRAVEL.ID
    and
    JOURNEYS.BUS_ID=BUSES.ID
    and
    BUSES.ID = ALLOCATION.bus_id
    and
    ALLOCATION.TRAVEL_ID=TRAVEL.ID
    and
    ALLOCATION.STAFF_ID=STAFF.ID", ['userid' => $userid]);
        return view('dashboard.admin.UserBooking',compact('query'));
    }
}
