<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Allocation;
use App\Models\Staff;
use App\Models\Travel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
class AdminController extends Controller
{

    public function showDashboard()
{
    $userCount = User::count();

    $staffCount = Staff::count();
    $totalTrips= Allocation::where('status', 'completed')->count();


    $recentActivities = DB::select("SELECT DISTINCT * FROM recent_activity ORDER BY created_at DESC");



    return view('dashboard.admin.home', compact('recentActivities','userCount','staffCount','totalTrips'));
}

    function check(Request $request){
         //Validate Inputs
         $request->validate([
            'email'=>'required|email|exists:admins,email',
            'password'=>'required|min:5|max:30'
         ],[
             'email.exists'=>'This email is not exists in admins table'
         ]);

         $creds = $request->only('email','password');

         if( Auth::guard('admin')->attempt($creds) ){
             return redirect()->route('admin.dashboard');
         }else{
             return redirect()->route('admin.login')->with('fail','Incorrect credentials');
         }
    }

    function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }
    function agency_list(){
       $data=DB::select("select * from agencies ");
       return view('dashboard.agency.list',compact('data'));
    }
    function add_agency(){

        return view('dashboard.agency.addAgency');
    }
    function storeAgency(Request $request){
    $agency=new Agency();
    $agency->name=$request->name;
        $agency->contact_no=$request->contact_no;
        $agency->email=$request->email;
        $agency->save();
        return redirect()->route('admin.agency.list');

    }
    function indivdualBus(Request $request){
        $busId = $request->id;

        $data = DB::table('AGENCIES AS ag')
    ->join('OWNERSHIPS AS o', 'ag.ID', '=', 'o.AGENCY_ID')
    ->join('BUSES AS b', 'o.BUS_ID', '=', 'b.ID')
    ->join('ALLOCATIONS AS a', 'b.ID', '=', 'a.BUS_ID')
    ->join('JOURNEYS AS j', 'a.TRAVEL_ID', '=', 'j.TRAVEL_ID')
    ->join('CONFIRMATIONS AS c', 'j.BOOKING_ID', '=', 'c.BOOKING_ID')
    ->join('BOOKINGS AS bo', 'c.BOOKING_ID', '=', 'bo.ID')
    ->where('a.BUS_ID', $busId)
    ->where('a.status','completed')
    ->select(DB::raw('SUM( bo.PAYMENT) AS total_payment'), DB::raw('COUNT(DISTINCT a.TRAVEL_ID) AS travel_count'))
    ->first();

    if ($data) {
        return view('dashboard.admin.individualBus', compact('data','busId'));
    } else {
        // Handle the case when data is not found
        return view('noDataFound');
    }
}
    function indivdualAgency(Request $request)
    {
        $agencyId = $request->id;

        $data = DB::table('AGENCIES AS ag')
            ->join('OWNERSHIPS AS o', 'ag.ID', '=', 'o.AGENCY_ID')
            ->join('BUSES AS b', 'o.BUS_ID', '=', 'b.ID')
            ->join('ALLOCATIONS AS a', 'b.ID', '=', 'a.BUS_ID')
            ->join('JOURNEYS AS j', 'a.TRAVEL_ID', '=', 'j.TRAVEL_ID')
            ->join('CONFIRMATIONS AS c', 'j.BOOKING_ID', '=', 'c.BOOKING_ID')
            ->join('BOOKINGS AS bo', 'c.BOOKING_ID', '=', 'bo.ID')
            ->where('ag.ID', $agencyId)
            ->where('a.STATUS', 'completed')
            ->select('ag.NAME', DB::raw('SUM(bo.PAYMENT) AS payment'), DB::raw('COUNT(distinct a.TRAVEL_ID) AS travel_count'))
            ->groupBy('ag.NAME')
            ->first();

        if ($data) {
            return view('dashboard.agency.individualAgency', compact('data'));
        } else {
            // Handle the case when data is not found
            return view('noDataFound');
        }
    }



    function AllocateTripPage()
    {
        $freeBuses = DB::select('SELECT Bus_ID, Bus_Type, Agency_Name
    FROM agencyANDbus
    WHERE status = \'free\'');
        $freeStaff=DB::select("select FIRST_NAME,LAST_NAME,ID
    from STAFF
 where STATUS='free'");
        return view('dashboard.admin.AllocateATrip',compact('freeBuses','freeStaff'));

    }
    function AllocateFixedTripPage()
    {
        $freeBuses = DB::table('BUSES as b')
        ->select(DB::raw('DISTINCT aa.NAME, b.ID as Bus_ID, b.BUS_TYPE as Bus_Type, b.BUS_CAPACITY as Bus_Capacity, b.BUS_FITNESS as Bus_Fitness, b.REG_NO, b.STATUS as status, t.ID'))
        ->leftJoin('ALLOCATIONS as a', 'b.ID', '=', 'a.BUS_ID')
        ->leftJoin('TRAVEL as t', 't.ID', '=', 'a.TRAVEL_ID')
        ->leftJoin('OWNERSHIPS as o', 'o.BUS_ID', '=', 'b.ID')
        ->leftJoin('AGENCIES as aa', 'aa.ID', '=', 'o.AGENCY_ID')
        ->where('t.id', 'LIKE', '202114%')
        ->where('b.status', 'free')
        ->get();
        $freeStaff=DB::select("select FIRST_NAME,LAST_NAME,ID
    from STAFF
 where STATUS='free'");
        return view('dashboard.admin.AllocateFixedTrip',compact('freeBuses','freeStaff'));

    }

    function AlocateFixedTrip(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'starting_point' => 'required',
                'ending_point' => 'required',
                'bus_id' => 'required',
                'staff_id' => 'required',
                'seat_cost' => 'required',
                'travel_date' => 'required|date',
                'status' => 'required',
            ]);

            $nextValue = DB::selectOne('SELECT fixedtripid.nextval FROM dual')->nextval;


            $travel = new Travel();
            $travel->id =  $nextValue;
            $travel->starting_point = $request->starting_point;
            $travel->ending_point = $request->ending_point;
            $travel->save();

            $allocate = new Allocation();
            $allocate->bus_id = $request->bus_id;
            $allocate->travel_id = $nextValue;
            $allocate->staff_id = $request->staff_id;
            $allocate->seat_cost = $request->seat_cost;
            $allocate->travel_date = Carbon::parse($request->travel_date)->format('Y-m-d H:i:s');
            $allocate->status = $request->status;
            $allocate->save();

            DB::statement("
            UPDATE buses
            SET status = 'Busy'
            WHERE id = $request->bus_id
           ");
            DB::statement("
            UPDATE staff
            SET status = 'Busy'
            WHERE id = $request->staff_id
           ");
            return redirect()->route('admin.dashboard');
        }catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->withInput()->withErrors($errorMessage);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }

 }




    function freeBusSearch(Request $request)
    {
        $busType = $request->input('bus_type');

        // Fetch all free buses with regular bus type
        $freeBuses = DB::table('agencyandbus')
            ->where('status', 'free')
            ->whereRaw('LOWER(Bus_Type) LIKE ?', ['%' . strtolower($busType) . '%'])
            ->get();
        $freeStaff = DB::select("select FIRST_NAME,LAST_NAME,ID
    from STAFF
   where STATUS='free'");
   return view('dashboard.admin.AllocateATrip', compact('freeBuses','freeStaff'));

    }

  function freeFixedBusSearch(Request $request){
    $busType = $request->input('bus_type');

    // Fetch all free buses with regular bus type
    $freeBuses = DB::table('BUSES as b')
    ->select('aa.NAME', 'b.ID as Bus_ID', 'b.BUS_TYPE as Bus_Type', 'b.BUS_CAPACITY as Bus_Capacity', 'b.BUS_FITNESS as Bus_Fitness', 'b.REG_NO', 'b.STATUS as status')
    ->join('OWNERSHIPS as o', 'o.BUS_ID', '=', 'b.ID')
    ->join('AGENCIES as aa', 'aa.ID', '=', 'o.AGENCY_ID')
    ->whereRaw('LOWER(b.BUS_TYPE) LIKE ?', ['%' . strtolower($busType) . '%'])
    ->where('b.BUS_TYPE', 'LIKE', '%(Regular)')
    ->where('b.STATUS', 'free')
    ->get();

            $freeStaff=DB::select("select FIRST_NAME,LAST_NAME,ID
        from STAFF
   where STATUS='free'");


        // Fetch all free buses for the sidebar


        return view('dashboard.admin.AllocateFixedTrip', compact('freeBuses','freeStaff'));

    }
    function freeStaffSearch(Request $request){

        $firstName = $request->input('first_name');
        $freeStaff = DB::table('staff')
            ->where('status', 'free')
            ->whereRaw('LOWER(first_name) LIKE ?', ['%' . strtolower($firstName) . '%'])
            ->get();
        $freeBuses = DB::select('SELECT Bus_ID, Bus_Type, Agency_Name
    FROM agencyANDbus
    WHERE  Bus_Type  not LIKE \'%(Regular)\' and status = \'free\'');

        return view('dashboard.admin.AllocateATrip', compact('freeBuses','freeStaff'));

    }

    function freeFixedStaffSearch(Request $request){

        $firstName = $request->input('first_name');
        $freeStaff = DB::table('staff')
            ->where('status', 'free')
            ->whereRaw('LOWER(first_name) LIKE ?', ['%' . strtolower($firstName) . '%'])
            ->whereRaw('LOWER(last_name) LIKE ?', ['%' . strtolower($firstName) . '%'])
            ->get();
            $freeBuses = DB::table('BUSES as b')
            ->join('ALLOCATIONS as a', 'b.ID', '=', 'a.BUS_ID')
            ->join('TRAVEL as t', 't.ID', '=', 'a.TRAVEL_ID')
            ->join('OWNERSHIPS as o', 'o.BUS_ID', '=', 'b.ID')
            ->join('AGENCIES as aa', 'aa.ID', '=', 'o.AGENCY_ID')
            ->where('t.ID', 'LIKE', '202114%')
            ->where('b.status', 'free')
            ->select('aa.NAME', 'b.ID as Bus_ID', 'b.BUS_TYPE as Bus_Type', 'b.BUS_CAPACITY as Bus_Capacity', 'b.BUS_FITNESS as Bus_Fitness', 'b.REG_NO', 'b.STATUS as status', 't.ID')
            ->distinct()
            ->get();

        return view('dashboard.admin.AllocateFixedTrip', compact('freeBuses','freeStaff'));

    }


public function AlocateTrip(Request $request)
{
    try {
        $validatedData = $request->validate([
            'starting_point' => 'required',
            'ending_point' => 'required',
            'bus_id' => 'required',
            'staff_id' => 'required',
            'seat_cost' => 'required',
            'travel_date' => 'required|date',
            'status' => 'required',
        ]);

        $travel = new Travel();
        $travel->starting_point = $validatedData['starting_point'];
        $travel->ending_point = $validatedData['ending_point'];
        $travel->save();

        $allocation = new Allocation();
        $allocation->bus_id = $validatedData['bus_id'];
        $allocation->travel_id = $travel->id;
        $allocation->staff_id = $validatedData['staff_id'];
        $allocation->seat_cost = $validatedData['seat_cost'];
        $allocation->travel_date = Carbon::parse($validatedData['travel_date'])->format('Y-m-d H:i:s');
        $allocation->status = $validatedData['status'];
        $allocation->save();

        DB::statement("UPDATE buses SET status = 'Busy' WHERE id = ?", [$validatedData['bus_id']]);
        DB::statement("UPDATE staff SET status = 'Busy' WHERE id = ?", [$validatedData['staff_id']]);

        return redirect()->route('admin.dashboard');
    } catch (ValidationException $e) {
        $errorMessage = $e->getMessage();
        return redirect()->back()->withInput()->withErrors($errorMessage);
    } catch (\Exception $e) {
        $errorMessage = $e->getMessage();
        return redirect()->back()->withInput()->withErrors($errorMessage);
    }
}


   function showAllStaff(Request $request)
    {
        $search = $request->input('search');

        $userList = Staff::query();

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

        return view('dashboard.admin.showStaff', compact('userList', 'search'));
    }

    function showIndividualUsergAllTrip(Request $request){
        $user_id = $request->id;

        return view('dashboard.user.AllDetails', compact('user_id'));
    }


    public function allUpcomingBookings(Request $request)
{
    $startingPoint = $request->input('starting_point');
    $endingPoint = $request->input('ending_point');
    $agencyName = $request->input('agency_name');
    $date = $request->input('travel_date');

    $query = DB::table('allocations as a')
        ->leftJoin('travel as t', 'a.travel_id', '=', 't.id')
        ->leftJoin('journeys as j', 't.id', '=', 'j.travel_id')
        ->leftJoin('ownerships as o', 'a.bus_id', '=', 'o.bus_id')
        ->leftJoin('agencies as aa', 'o.agency_id', '=', 'aa.id')
        ->leftJoin('bookings as bo', 'j.booking_id', '=', 'bo.id')
        ->select('a.travel_id', DB::raw('SUM(bo.payment) as total_payment'), 't.starting_point', 't.ending_point', 'aa.name', 'a.travel_date','a.staff_id', DB::raw('COUNT(j.booking_id) as booking_count'))
        ->where('a.status', 'Busy')
        ->when($startingPoint, function ($query, $startingPoint) {
            return $query->whereRaw('LOWER(t.starting_point) LIKE ?', ['%' . strtolower($startingPoint) . '%']);
        })
        ->when($endingPoint, function ($query, $endingPoint) {
            return $query->whereRaw('LOWER(t.ending_point) LIKE ?', ['%' . strtolower($endingPoint) . '%']);
        })
        ->when($agencyName, function ($query, $agencyName) {
            return $query->whereRaw('LOWER(aa.name) LIKE ?', ['%' . strtolower($agencyName) . '%']);
        })
        ->when($date, function ($query, $date) {
            return $query->whereDate('a.travel_date', $date);
        })
        ->groupBy('a.travel_id', 't.starting_point', 't.ending_point', 'aa.name', 'a.travel_date','a.staff_id')
        ->get();

    $bookings = $query->all();

    return view('dashboard.admin.123', compact('bookings', 'startingPoint', 'endingPoint', 'agencyName', 'date'));
}

    function  showIndividualUserUpcomingTrip(Request $request){
        $startingPoint = $request->input('starting_point');
        $endingPoint = $request->input('ending_point');
        $agencyName = $request->input('agency_name');
        $date = $request->input('date');
            $user_id = $request->id;

            $query = DB::table('ALLOCATIONS AS a')
    ->leftJoin('TRAVEL AS t', 'a.TRAVEL_ID', '=', 't.ID')
    ->leftJoin('JOURNEYS AS j', 't.ID', '=', 'j.TRAVEL_ID')
    ->leftJoin('OWNERSHIPS AS o', 'a.BUS_ID', '=', 'o.BUS_ID')
    ->leftJoin('AGENCIES AS aa', 'o.AGENCY_ID', '=', 'aa.ID')
    ->leftJoin('BOOKINGS AS bo', 'j.BOOKING_ID', '=', 'bo.ID')
    ->select('a.TRAVEL_ID', DB::raw('SUM(bo.PAYMENT) AS total_payment'), 't.STARTING_POINT', 't.ENDING_POINT', 'aa.NAME', 'a.TRAVEL_DATE', DB::raw('COUNT(j.BOOKING_ID) AS booking_count'))
    ->where('a.STAFF_ID', $user_id)
    ->where('a.STATUS', 'Busy')
    ->when($startingPoint, function ($query, $startingPoint) {
        return $query->whereRaw('LOWER(t.starting_point) LIKE ?', ['%' . strtolower($startingPoint) . '%']);
    })
    ->when($endingPoint, function ($query, $endingPoint) {
        return $query->whereRaw('LOWER(t.ending_point) LIKE ?', ['%' . strtolower($endingPoint) . '%']);
    })
    ->when($agencyName, function ($query, $agencyName) {
        return $query->whereRaw('LOWER(aa.name) LIKE ?', ['%' . strtolower($agencyName) . '%']);
    })
    ->when($date, function ($query, $date) {
        return $query->whereDate('t.travel_date', $date);
    })
    ->groupBy('a.TRAVEL_ID', 't.STARTING_POINT', 't.ENDING_POINT', 'aa.NAME', 'a.TRAVEL_DATE')
    ->get();


        $bookings = collect($query);


        return view('dashboard.user.IndividualUserUpcomingTrips', compact('bookings', 'startingPoint', 'endingPoint', 'agencyName', 'date','user_id'));


    }

    function  showIndividualStaffUpcomingTrip(Request $request){
        $startingPoint = $request->input('starting_point');
        $endingPoint = $request->input('ending_point');
        $agencyName = $request->input('agency_name');
        $date = $request->input('date');
            $staff_id = $request->id;

            $query = DB::table('ALLOCATIONS AS a')
    ->leftJoin('TRAVEL AS t', 'a.TRAVEL_ID', '=', 't.ID')
    ->leftJoin('JOURNEYS AS j', 't.ID', '=', 'j.TRAVEL_ID')
    ->leftJoin('OWNERSHIPS AS o', 'a.BUS_ID', '=', 'o.BUS_ID')
    ->leftJoin('AGENCIES AS aa', 'o.AGENCY_ID', '=', 'aa.ID')
    ->leftJoin('BOOKINGS AS bo', 'j.BOOKING_ID', '=', 'bo.ID')
    ->select('a.TRAVEL_ID', DB::raw('SUM(bo.PAYMENT) AS total_payment'), 't.STARTING_POINT', 't.ENDING_POINT', 'aa.NAME', 'a.TRAVEL_DATE', DB::raw('COUNT(j.BOOKING_ID) AS booking_count'))
    ->where('a.STAFF_ID', $staff_id)
    ->where('a.STATUS', 'Busy')
    ->when($startingPoint, function ($query, $startingPoint) {
        return $query->whereRaw('LOWER(t.starting_point) LIKE ?', ['%' . strtolower($startingPoint) . '%']);
    })
    ->when($endingPoint, function ($query, $endingPoint) {
        return $query->whereRaw('LOWER(t.ending_point) LIKE ?', ['%' . strtolower($endingPoint) . '%']);
    })
    ->when($agencyName, function ($query, $agencyName) {
        return $query->whereRaw('LOWER(aa.name) LIKE ?', ['%' . strtolower($agencyName) . '%']);
    })
    ->when($date, function ($query, $date) {
        return $query->whereDate('a.travel_date', $date);
    })
    ->groupBy('a.TRAVEL_ID', 't.STARTING_POINT', 't.ENDING_POINT', 'aa.NAME', 'a.TRAVEL_DATE')
    ->get();


        $bookings = collect($query);

        return view('dashboard.admin.AllBookings', compact('bookings', 'startingPoint', 'endingPoint', 'agencyName', 'date','staff_id'));


    }
    function showIndividualUsergTrip(Request $request){

        $startingPoint = $request->input('starting_point');
        $endingPoint = $request->input('ending_point');
        $agencyName = $request->input('agency_name');
        $date = $request->input('date');
            $user_id = $request->id;

            $query = DB::table('TRAVEL AS t')
            ->join('ALLOCATIONS AS a', 't.ID', '=', 'a.TRAVEL_ID')
            ->join('JOURNEYS AS j', 't.ID', '=', 'j.TRAVEL_ID')
            ->join('BOOKINGS AS bo', 'j.BOOKING_ID', '=', 'bo.ID')
            ->join('CONFIRMATIONS AS c', 'bo.ID', '=', 'c.BOOKING_ID')
            ->join('USERS AS u', 'c.USER_ID', '=', 'u.ID')
            ->join('OWNERSHIPS AS o', 'j.BUS_ID', '=', 'o.BUS_ID')
            ->join('AGENCIES AS ag', 'o.AGENCY_ID', '=', 'ag.ID')
            ->join('BUSES AS b', 'o.BUS_ID', '=', 'b.ID')
            ->select(
                't.ENDING_POINT',
                'j.BOOKING_ID',
                't.STARTING_POINT',
                't.ID',
                'ag.NAME',
                'b.BUS_TYPE',
                'a.TRAVEL_DATE'

            )
            ->where('u.ID', $user_id)
            ->where('a.STATUS', 'completed')
            ->when($startingPoint, function ($query, $startingPoint) {
                return $query->where('t.STARTING_POINT', 'LIKE', '%' . $startingPoint . '%');
            })
            ->when($endingPoint, function ($query, $endingPoint) {
                return $query->where('t.ENDING_POINT', 'LIKE', '%' . $endingPoint . '%');
            })
            ->when($agencyName, function ($query, $agencyName) {
                return $query->where('ag.NAME', 'LIKE', '%' . $agencyName . '%');
            })
            ->when($date, function ($query, $date) {
                return $query->whereDate('a.TRAVEL_DATE', $date);
            })
            ->groupBy(
                't.ID',
                't.ENDING_POINT',
                'j.BOOKING_ID',
                't.STARTING_POINT',
                'ag.NAME',
                'b.BUS_TYPE',
                'a.TRAVEL_DATE'
            )
            ->get();

        $bookings = collect($query);

        return view('dashboard.user.IndividualUserAllTrips', compact('bookings', 'startingPoint', 'endingPoint', 'agencyName', 'date','user_id'));
    }


    function showIndividualAllStaff(Request $request){

    $startingPoint = $request->input('starting_point');
    $endingPoint = $request->input('ending_point');
    $agencyName = $request->input('agency_name');
    $date = $request->input('date');
        $staff_id = $request->id;

    $query = DB::table('ALLOCATIONS AS a')
        ->leftJoin('TRAVEL AS t', 'a.TRAVEL_ID', '=', 't.ID')
        ->leftJoin('JOURNEYS AS j', 't.ID', '=', 'j.TRAVEL_ID')
        ->leftJoin('OWNERSHIPS AS o', 'a.BUS_ID', '=', 'o.BUS_ID')
        ->leftJoin('AGENCIES AS aa', 'o.AGENCY_ID', '=', 'aa.ID')
        ->leftJoin('BOOKINGS AS bo', 'j.BOOKING_ID', '=', 'bo.ID')
        ->select('a.TRAVEL_ID', DB::raw('SUM(bo.PAYMENT) as total_payment'), 't.STARTING_POINT','aa.name', 't.ENDING_POINT', 'aa.NAME', 'a.TRAVEL_DATE', DB::raw('COUNT(j.BOOKING_ID) as booking_count'))
        ->where('a.STAFF_ID', $staff_id) // Add the condition for staff_id = 1
        ->where('a.STATUS', 'completed')
        ->when($startingPoint, function ($query, $startingPoint) {
            return $query->whereRaw('LOWER(t.starting_point) LIKE ?', ['%' . strtolower($startingPoint) . '%']);
        })
        ->when($endingPoint, function ($query, $endingPoint) {
            return $query->whereRaw('LOWER(t.ending_point) LIKE ?', ['%' . strtolower($endingPoint) . '%']);
        })
        ->when($agencyName, function ($query, $agencyName) {
            return $query->whereRaw('LOWER(aa.name) LIKE ?', ['%' . strtolower($agencyName) . '%']);
        })
        ->when($date, function ($query, $date) {
            return $query->whereDate('t.travel_date', $date);
        })
        ->groupBy('a.TRAVEL_ID', 't.STARTING_POINT', 't.ENDING_POINT', 'aa.NAME', 'a.TRAVEL_DATE')
        ->get();

    $bookings = collect($query);

    return view('dashboard.staff.IndividualStaffPrevTips', compact('bookings', 'startingPoint', 'endingPoint', 'agencyName', 'date','staff_id'));

    }

    function showIndividualStaff(){



    }

    function showIndividualStaffDetails(Request $request){
        $staff_id = $request->id;
        $count = DB::table('ALLOCATIONS')
        ->where('STAFF_ID', $staff_id)
        ->where('STATUS', 'completed')
        ->count();

        return view('dashboard.admin.individualStaffDetails', compact('staff_id', 'count'));
    }



     function AllBookins (Request $request)
    {
        $startingPoint = $request->input('starting_point');
        $endingPoint = $request->input('ending_point');
        $agencyName = $request->input('agency_name');
        $travelid = $request->input('travel_id');
        $date = $request->input('travel_date');

        $query = DB::table('ALLOCATIONS AS a')
            ->leftJoin('TRAVEL AS t', 'a.TRAVEL_ID', '=', 't.ID')
            ->leftJoin('JOURNEYS AS j', 't.ID', '=', 'j.TRAVEL_ID')
            ->leftJoin('OWNERSHIPS AS o', 'a.BUS_ID', '=', 'o.BUS_ID')
            ->leftJoin('AGENCIES AS aa', 'o.AGENCY_ID', '=', 'aa.ID')
            ->leftJoin('BOOKINGS AS bo', 'j.BOOKING_ID', '=', 'bo.ID')
            ->select('a.TRAVEL_ID', DB::raw('SUM(bo.PAYMENT) as total_payment'), 't.STARTING_POINT', 't.ENDING_POINT', 'aa.NAME', 'a.TRAVEL_DATE', DB::raw('COUNT(j.BOOKING_ID) as booking_count'))
            ->where('a.STATUS', 'completed')
            ->when($startingPoint, function ($query, $startingPoint) {
                return $query->whereRaw('LOWER(t.starting_point) LIKE ?', ['%' . strtolower($startingPoint) . '%']);
            })
            ->when($endingPoint, function ($query, $endingPoint) {
                return $query->whereRaw('LOWER(t.ending_point) LIKE ?', ['%' . strtolower($endingPoint) . '%']);
            })
            ->when($agencyName, function ($query, $agencyName) {
                return $query->whereRaw('LOWER(aa.name) LIKE ?', ['%' . strtolower($agencyName) . '%']);
            })
           // ->when($travelid, function ($query, $travelid) {
                //return $query->where('j.travel_id', $travelid);
           // })
            ->when($date, function ($query, $date) {
                return $query->whereDate('a.travel_date', $date);
            })
            ->groupBy('a.TRAVEL_ID', 't.STARTING_POINT', 't.ENDING_POINT', 'aa.NAME', 'a.TRAVEL_DATE')
            ->get();

        $bookings = collect($query);

        return view('dashboard.admin.AllBookings', compact('bookings', 'startingPoint', 'endingPoint', 'agencyName','date'));

    }

    function  individualBookinStaff($travel_id)
    {
        $travelid=$travel_id;
        $query = "SELECT FIRST_NAME, LAST_NAME, EMAIL, s.ID
        FROM travel j
        INNER JOIN ALLOCATIONS a ON j.ID = a.TRAVEL_ID
        INNER JOIN STAFF s ON a.STAFF_ID = s.ID
        WHERE j.ID = $travelid
          group by j.ID, FIRST_NAME, LAST_NAME, EMAIL, s.ID";

        $data = DB::select($query);





      return view('dashboard.admin.individualBookinStaff', compact('data'));
    }


    function individualBookinUser($travel_id)
    {
        $data = DB::select("SELECT u.ID as user_id, u.FIRST_NAME as first_name, u.LAST_NAME as last_name, u.CONTACT_NO as contact_no,
         bo.ID as booking_id, u.DISTRICT as district, u.GENDER as gender,u.email as email
                            FROM ALLOCATIONS a, TRAVEL t, JOURNEYS j, OWNERSHIPS o, AGENCIES aa, BOOKINGS bo, CONFIRMATIONS c, USERS u
                            WHERE a.TRAVEL_ID = $travel_id
                                AND a.TRAVEL_ID = j.TRAVEL_ID
                                AND j.BOOKING_ID = bo.ID
                                AND bo.ID = c.BOOKING_ID
                                AND c.USER_ID = u.ID
                            GROUP BY a.TRAVEL_ID, u.ID, u.FIRST_NAME, u.LAST_NAME, u.CONTACT_NO, bo.ID, u.DISTRICT, u.GENDER,u.email");

        return view('dashboard.admin.individualBookinUser', compact('data'));
    }


     function  individualBookinUserSeats($booking_id)
    {
        $bookedSeats = DB::select("SELECT s.SEAT_NUMBER
                                    FROM JOURNEYS j
                                    INNER JOIN SEATS s ON j.BOOKING_ID = s.BOOKING_ID
                                    WHERE j.BOOKING_ID = $booking_id");
        $taka = DB::select("select payment from bookings where id=$booking_id");
        $taka = $taka[0]->payment;
        $bookedSeats = array_column($bookedSeats, 'seat_number');


        return view('dashboard.admin.individualBookinUserSeats', compact('bookedSeats','taka','booking_id'));
    }
     function individualBookin($travel_id)
    {
        $query = DB::table('ALLOCATIONS AS a')
            ->leftJoin('TRAVEL AS t', 'a.TRAVEL_ID', '=', 't.ID')
            ->leftJoin('JOURNEYS AS j', 't.ID', '=', 'j.TRAVEL_ID')
            ->leftJoin('OWNERSHIPS AS o', 'a.BUS_ID', '=', 'o.BUS_ID')
            ->leftJoin('AGENCIES AS aa', 'o.AGENCY_ID', '=', 'aa.ID')
            ->leftJoin('BOOKINGS AS bo', 'j.BOOKING_ID', '=', 'bo.ID')
            ->leftJoin('CONFIRMATIONS AS c', 'j.BOOKING_ID', '=', 'c.BOOKING_ID')
            ->select('a.TRAVEL_ID', DB::raw('SUM(bo.PAYMENT) as total_payment'), 't.STARTING_POINT', 't.ENDING_POINT', 'aa.NAME', 'j.TRAVEL_DATE','a.staff_id')
            ->where('a.TRAVEL_ID', $travel_id)
            ->groupBy('a.TRAVEL_ID', 't.STARTING_POINT', 't.ENDING_POINT', 'aa.NAME', 'j.TRAVEL_DATE','a.staff_id')
            ->get();

        $bookings = collect($query);

        return view('dashboard.admin.IndividualBooking', compact('bookings'));
    }
     function OtherInfo($travel_id){
         $others=DB::select("
         SELECT
             STARTING_POINT,
             ENDING_POINT,
             aa.NAME,
             aa.CONTACT_NO,
             a.TRAVEL_DATE,
             a.BUS_ID,
             b.BUS_TYPE
         FROM
             JOURNEYS j
             INNER JOIN TRAVEL t ON j.TRAVEL_ID = t.ID
             INNER JOIN ALLOCATIONS a ON t.ID = a.TRAVEL_ID
             INNER JOIN BUSES b ON a.BUS_ID = b.ID
             INNER JOIN OWNERSHIPS o ON b.ID = o.BUS_ID
             INNER JOIN AGENCIES aa ON o.AGENCY_ID = aa.ID

         WHERE
             j.TRAVEL_ID = $travel_id
         group by j.TRAVEL_ID, STARTING_POINT, ENDING_POINT, aa.NAME, aa.CONTACT_NO, a.TRAVEL_DATE, a.BUS_ID, b.BUS_TYPE");


         $payment=DB::select("select sum(PAYMENT)
    from JOURNEYS j,BOOKINGS b
        where
    j.TRAVEL_ID=$travel_id
    and j.BOOKING_ID=b.ID");

        $ticketCount=DB::select("select count(SEAT_NUMBER)
    from JOURNEYS j,SEATS s
        where
    j.TRAVEL_ID=$travel_id
    and
     j.BOOKING_ID=s.BOOKING_ID");

        return view('dashboard.admin.showOtherInfo',compact('others','payment','ticketCount'));
    }

}


