<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CompanyRequest;

use App\User;
use App\Company;

use Alert;
use Session;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate(25);
        return view('companies.index')->withCompanies($companies);
    }

    /**
     * Search users
     *
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $companies = Company::search($request->keyword)->paginate(25)->appends(['keyword' => $request->keyword]);
        return view('companies.index')->withCompanies($companies);
    }

    public function searchajax(Request $request)
    {
        $companies = Company::search($request->keyword)->get();
        // return $companies;
        $data = array();
        foreach ($companies as $index => $company) {
            $data[$index] = [
                'id' => $company->id,
                'value' => $company->company_name
            ];
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $users = User::all();
        return view('companies.create')->withUsers($users)->withUser_id($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $company = new Company;
        $company->company_name = $request->company_name;
        $company->label        = $request->label;
        $company->first_name   = $request->first_name;
        $company->last_name    = $request->last_name;
        $company->phone_number = $request->phone_number;
        $company->address      = $request->address;
        $company->city         = $request->city;
        $company->province     = $request->province;
        $company->postalcode   = $request->postalcode;

        $company->user_id      = $request->user_id;

        $company->save();

        Session::flash('success','The Company was successfully saved');

        return redirect()->route('companies.show',$company->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        return view('companies.show')->withCompany($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function client($id=null)
    {
        $user = User::find($id);
        foreach ($user->companies as $key => $company_id) {
            $company = Company::find($company_id->id);
        }
        return view('companies.client')->withCompany($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        $users = User::all();
        return view('companies.edit')->withCompany($company)->withUsers($users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        $company = Company::find($id);
        $company->company_name = $request->company_name;
        $company->label        = $request->label;
        $company->first_name   = $request->first_name;
        $company->last_name    = $request->last_name;
        $company->phone_number = $request->phone_number;
        $company->address      = $request->address;
        $company->city         = $request->city;
        $company->province     = $request->province;
        $company->postalcode   = $request->postalcode;

        $company->user_id      = $request->user_id;

        $company->save();

        Session::flash('success','The Company was successfully updated');

        return redirect()->route('companies.show',$company->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();

        Alert::success('The Company and related data have been deleted', 'Successful' )->persistent("Close");

        return redirect()->route('companies.index');
    }
}
