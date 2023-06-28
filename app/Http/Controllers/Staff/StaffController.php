<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    function create(Request $request){
        //Validate Inputs
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users,email',
            'gender'=>'required',
            'district'=>'required',
            'thana'=>'required',
            'ward_no'=>'required',
            'house_no'=>'required',
            'password'=>'required|min:5|max:30',
            'cpassword'=>'required|min:5|max:30|same:password'
        ]);

        $admin = new Staff();
        $admin->first_name=$request->first_name;
        $admin->last_name=$request->last_name;
        $admin->email=$request->email;
        $admin->gender=$request->gender;
        $admin->contact_no=$request->contact_no;
        $admin->district=$request->district;
        $admin->ward_no=$request->ward_no;
        $admin->thana=$request->thana;
        $admin->house_no=$request->house_no;
        $admin->password=Hash::make($request->password);
        $save=$admin->save();

        if( $save ){
            return redirect()->back()->with('success','You are now registered successfully');
        }else{
            return redirect()->back()->with('fail','Something went wrong, failed to register');
        }
    }

    function check(Request $request){
        //Validate inputs
        $request->validate([
            'email'=>'required|email|exists:staff,email',
            'password'=>'required|min:5|max:30'
        ],[
            'email.exists'=>'This email is not exists on users table'
        ]);

        $creds = $request->only('email','password');
        if( Auth::guard('staff')->attempt($creds) ){
            return redirect()->route('staff.home');
        }else{
            return redirect()->route('staff.login')->with('fail','Incorrect credentials');
        }
    }

    function logout(){
        Auth::guard('staff')->logout();
        return redirect('/');
    }
    function completed(Request $request){

// Import the DB facade

// Update the 'completed' status in allocations table
        DB::table('allocations')
            ->where('staff_id', auth()->guard('staff')->user()->id)
            ->where('status', 'Busy')
            ->update(['status' => 'completed']);
        $busid = $request->bus_id;
// Update the 'free' status in buses table
        DB::table('buses')
            ->where('id', $busid)
            ->update(['status' => 'free']);

        return redirect()->route('staff.home');

    }
    function assignedTrips(){
        $staffId = Auth::guard('staff')->user()->id;
        $assignedTrip = DB::select("SELECT STARTING_POINT, ENDING_POINT, BUS_ID, TRAVEL_DATE, TRAVEL_ID, ALLOCATIONS.STATUS
        FROM BUSES, ALLOCATIONS, TRAVEL
        WHERE ALLOCATIONS.STAFF_ID = $staffId
        AND ALLOCATIONS.TRAVEL_ID = TRAVEL.ID
        AND ALLOCATIONS.BUS_ID = BUSES.ID
        AND ALLOCATIONS.STATUS = 'Busy'");

        if($assignedTrip){
            $assignedTrip = $assignedTrip[0];
            return view('dashboard.staff.assignedTrip', compact('assignedTrip'));
        } else {
            return view('dashboard.staff.popup', compact('assignedTrip'));
        }
    }

    function profile(Request $request){
        $id = $request->input('id');
        $user=DB::select("select * from staffprofileview where id= $id");
        $user=$user[0];
        return view('dashboard.user.profile',compact('user'));
        //dd($user);
    }

    public function prevBookings(){
        $staffId = Auth::guard('staff')->user()->id;
        $query = DB::table('ALLOCATIONS AS a')
        ->selectRaw("DISTINCT ag.NAME, b.ID, b.ID, STARTING_POINT, ENDING_POINT, ag.NAME, a.TRAVEL_DATE, b.BUS_TYPE")
        ->leftJoin('TRAVEL AS t', 'a.TRAVEL_ID', '=', 't.ID')
        ->leftJoin('JOURNEYS AS j', 'j.TRAVEL_ID', '=', 't.ID')
        ->leftJoin('BUSES AS b', 'a.BUS_ID', '=', 'b.ID')
        ->leftJoin('OWNERSHIPS AS o', 'b.ID', '=', 'o.BUS_ID')
        ->leftJoin('AGENCIES AS ag', 'o.AGENCY_ID', '=', 'ag.ID')
        ->leftJoin('CONFIRMATIONS AS c', 'j.booking_id', '=', 'c.BOOKING_ID')
        ->leftJoin('BOOKINGS AS bo', 'c.BOOKING_ID', '=', 'bo.ID')
        ->where('a.status', 'completed')
        ->where('a.staff_id', $staffId)
        ->groupBy('a.TRAVEL_ID', 'c.BOOKING_ID', 'STARTING_POINT', 'ENDING_POINT', 'a.TRAVEL_DATE', 'BUS_TYPE', 'ag.NAME', 'b.ID')
        ->get();

        $bookings = collect($query);

        return view('dashboard.staff.prevAssignedTrip', compact('bookings'));
    }

    public function maintenance (){
        return view('dashboard.staff.Maintenance');
    }

  public function maintenanceRecord (Request $request){
        $maintenance_type = $request->maintenance_type;
        $maintenance_cost = $request->maintenance_cost;
        $bus_id = $request->reg_no;

if (!empty($bus_id)) {

    $query = "BEGIN insert_maintenance(:maintenance_type, :maintenance_cost, :bus_id); END;";
    $params = [
        'maintenance_type' => $maintenance_type,
        'maintenance_cost' => $maintenance_cost,
        'bus_id' => $bus_id,
    ];

    DB::getPdo()->prepare($query)->execute($params);
    return redirect()->route('staff.home')->with('success', 'Complain Added To Database');
} else {

    return redirect()->route('staff.home')->with('error', 'Invalid Bus ID');
}

  }

}
