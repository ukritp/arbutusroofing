<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\WorkorderRequest;

use App\Company;
use App\Property;
use App\Workorder;
use App\UploadImage;

use Alert;
use Session;

class WorkorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workorders = Workorder::paginate(25);
        $companies = Company::all();
        return view('workorders.index')->withWorkorders($workorders)->withCompanies($companies);
    }

    /**
     * Search workorders
     *
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $workorders = Workorder::search($request->keyword)->paginate(25)->appends(['keyword' => $request->keyword]);
        $companies = Company::all();
        return view('workorders.index')->withWorkorders($workorders)->withCompanies($companies);
    }


    public function searchajax(Request $request)
    {
        $workorders = Workorder::search($request->keyword)->get();
        // return $companies;
        $data = array();
        foreach ($workorders as $index => $workorder) {
            $data[$index] = [
                'id' => $workorder->id,
                'value' => 'Work Order#: '.$workorder->workorder_number.' - '.$workorder->property->property_name,
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
        $properties = Property::all();
        return view('workorders.create')->withProperties($properties)->withProperty_id($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkorderRequest $request)
    {
        $workorder = new Workorder;
        $workorder->description         = $request->description;
        $workorder->workorder_number    = $request->workorder_number;
        $workorder->tenant_first_name   = $request->tenant_first_name;
        $workorder->tenant_last_name    = $request->tenant_last_name;
        $workorder->tenant_phone_number = $request->tenant_phone_number;

        $workorder->property_id         = $request->property_id;

        $workorder->save();

        Session::flash('success','The Work Order was successfully saved');

        return redirect()->route('workorders.show',$workorder->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workorder = Workorder::find($id);
        return view('workorders.show')->withWorkorder($workorder);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $workorder = Workorder::find($id);
        $properties = Property::all();
        return view('workorders.edit')->withWorkorder($workorder)->withProperties($properties);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $workorder = Workorder::find($id);
        $workorder->description         = $request->description;
        $workorder->workorder_number    = $request->workorder_number;
        $workorder->tenant_first_name   = $request->tenant_first_name;
        $workorder->tenant_last_name    = $request->tenant_last_name;
        $workorder->tenant_phone_number = $request->tenant_phone_number;

        $workorder->property_id         = $request->property_id;

        $workorder->save();

        Session::flash('success','The Work Order was successfully updated');

        return redirect()->route('workorders.show',$workorder->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workorder = Workorder::find($id);
        $workorder->delete();

        Alert::success('The Workorder and related data have been deleted', 'Successful' )->persistent("Close");

        return redirect()->route('workorders.index');
    }
}
