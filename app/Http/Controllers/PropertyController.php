<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PropertyRequest;

use App\User;
use App\Company;
use App\Property;

use Alert;
use Session;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::paginate(25);
        return view('properties.index')->withProperties($properties);
    }

    /**
     * Search users
     *
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $properties = Property::search($request->keyword)->paginate(25)->appends(['keyword' => $request->keyword]);
        return view('properties.index')->withProperties($properties);
    }

    public function searchajax(Request $request)
    {
        $properties = Property::search($request->keyword)->get();
        // return $companies;
        $data = array();
        foreach ($properties as $index => $property) {
            $data[$index] = [
                'id' => $property->id,
                'value' => $property->property_name
            ];
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        $companies = Company::all();
        return view('properties.create')->withCompanies($companies)->withCompany_id($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
        $property = new Property;
        $property->property_name = $request->property_name;
        $property->first_name    = $request->first_name;
        $property->last_name     = $request->last_name;
        $property->phone_number  = $request->phone_number;
        $property->address       = $request->address;
        $property->city          = $request->city;
        $property->province      = $request->province;
        $property->postalcode    = $request->postalcode;

        $property->company_id    = $request->company_id;

        $property->save();

        Session::flash('success','The Property was successfully saved');

        return redirect()->route('properties.show',$property->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::find($id);
        return view('properties.show')->withProperty($property);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::find($id);
        $companies = Company::all();
        return view('properties.edit')->withCompanies($companies)->withProperty($property);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyRequest $request, $id)
    {
        $property = Property::find($id);
        $property->property_name = $request->property_name;
        $property->first_name    = $request->first_name;
        $property->last_name     = $request->last_name;
        $property->phone_number  = $request->phone_number;
        $property->address       = $request->address;
        $property->city          = $request->city;
        $property->province      = $request->province;
        $property->postalcode    = $request->postalcode;

        $property->company_id    = $request->company_id;

        $property->save();

        Session::flash('success','The Property was successfully updated');

        return redirect()->route('properties.show',$property->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::find($id);
        $property->delete();

        Alert::success('The Property and related data have been deleted', 'Successful' )->persistent("Close");

        return redirect()->route('properties.index');
    }
}
