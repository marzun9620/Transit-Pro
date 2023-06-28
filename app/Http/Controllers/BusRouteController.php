<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
class BusRouteController extends Controller
{
    public function index()
    {
        $busRoutes = Travel::all();


        return view('bus-routes.index', compact('busRoutes'));
    }


    public function search(Request $request)
    {
        $origin = $request->input('starting_point');
        $destination = $request->input('ending_point');
        $date = $request->input('travel_date');

        $busRoutes = DB::table('allocations as a')
            ->join('travel as t', 't.id', '=', 'a.travel_id')
            ->when($origin, function ($query) use ($origin) {
                return $query->whereRaw("LOWER(t.starting_point) LIKE ?", [strtolower($origin) . '%']);
            })
            ->when($destination, function ($query) use ($destination) {
                return $query->whereRaw("LOWER(t.ending_point) LIKE ?", [strtolower($destination) . '%']);
            })
            ->when($date, function ($query) use ($date) {
                $formattedDate = date('Y-m-d', strtotime($date));
                return $query->whereDate('a.travel_date', '=', $formattedDate);
            })
            ->select('t.starting_point', 't.ending_point', 'a.travel_date', 't.id')
            ->get();

        $busIds = $busRoutes->pluck('id')->toArray();
        $busData = [];


        foreach ($busIds as $busId) {
            $busInfo = DB::table('allocations')
                ->join('buses', 'allocations.bus_id', '=', 'buses.id')
                ->where('allocations.travel_id', $busId)
                ->where('allocations.status', 'Busy')
                ->select('buses.bus_type', 'allocations.seat_cost')
                ->first();

            if ($busInfo) {
                $busData[$busId] = $busInfo;
            }
        }

        return view('bus-routes.index', compact('busRoutes', 'busData'));
    }





}
