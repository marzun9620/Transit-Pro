<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AddBusRoute extends Controller
{
    function reserve(){
        return view('dashboard.admin.addRoute');
    }

    public function save(Request $request){

        Travel::create([
            'starting_point'=>$request['starting_point'],
            'ending_point'=>$request['ending_point'],
            'travel_date'=>$request['travel_date'],
        ]);

    }
}
