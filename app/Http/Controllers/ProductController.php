<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Ownership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');

            $products = DB::table('agencyandbus')
                ->when($search, function ($query) use ($search) {
                    $query->where('bus_id', $search);
                })
                ->paginate(10);

            return view('products.index', compact('products', 'search'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->withInput()->withErrors($errorMessage);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=DB::select("select name,id from agencies");
        return view('products.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'bus_type' => 'required',
            'bus_capacity' => 'required',
            'reg_no' => 'required',
            'bus_fitness' => 'required',
        ]);
        $agency_id = $request->id;

        $bus=new Bus();
        $bus->bus_type=$request->bus_type;
        $bus->bus_capacity=$request->bus_capacity;
        $bus->reg_no=$request->reg_no;
        $bus->bus_fitness=$request->bus_fitness;
        $bus->status="free";
        $bus->save();
        $own=new Ownership();
        $own->bus_id=$bus->id;
        $own->agency_id=$agency_id;
        $own->save();
        return redirect()->route('products.index')
                        ->with('success','Bus created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Bus $product)
    {
        $bus=DB::select("select * from agencyandbus");
        return view('products.show',compact('product','bus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Bus $product)
    {
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bus $product)
    {
        $request->validate([
            'bus_type' => 'required',

            'bus_capacity' => 'required',
            'reg_no' => 'required',
            'bus_fitness' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
                        ->with('success','Bus updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bus $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                        ->with('success','Bus deleted successfully');
    }
}
