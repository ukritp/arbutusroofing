<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UserRequest;

use Auth;
use Hash;
use Validator;

use App\User;
use App\Role;
use App\Company;

use Alert;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::paginate(25);

        return view('users.index')->withUsers($users);
    }

    /**
     * Search users
     *
     * https://laracasts.com/discuss/channels/laravel/search-option-in-laravel-5?page=1
     * @param  string keyword
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $users = User::search($request->keyword)->paginate(25)->appends(['keyword' => $request->keyword]);
        //echo count($users);
        // if(count($users)==0){
        //     $users = User::search($request->keyword, ['mailing_address', 'billing_address'])->paginate(25)->appends(['keyword' => $request->keyword]);
        // }
        //echo count($users);

        // foreach($users as $users){
        //     echo $users->id;
        // }

        return view('users.index')->withUsers($users);
    }

    public function searchajax(Request $request)
    {
        $users = User::search($request->keyword)->get();
        // return $companies;
        $data = array();
        foreach ($users as $index => $user) {
            $data[$index] = [
                'id' => $user->id,
                'value' => $user->first_name.' '.$user->last_name.' - '.$user->email,
            ];
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User;
        $user->email        = $request->email;
        $user->password     = $request->password;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->address      = $request->address;
        $user->city         = $request->city;
        $user->province     = $request->province;
        $user->postalcode   = $request->postalcode;
        $user->status       = $request->status;

        $user->save();
        $user->roles()->attach(Role::where('id',$request->role)->first());

        Session::flash('success','The User was successfully saved');

        return redirect()->route('users.show',$user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit')->withUser($user);
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
        $this->validate($request, array(

            'first_name'   => 'required|max:255',
            'last_name'    => 'required|max:255',
            'address'      => 'max:255',
            'city'         => 'max:50',
            'province'     => '',
            'postalcode'   => 'max:6',
            'phone_number' => 'digits:10',
            'status'       => '',
            'role'         => 'required',

        ));

        $user = User::find($id);

        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->address      = $request->address;
        $user->city         = $request->city;
        $user->province     = $request->province;
        $user->postalcode   = $request->postalcode;
        $user->status       = $request->status;

        $user->save();

        $user->roles()->sync([$request->role]);

        Session::flash('success','The User was successfully updated');

        return redirect()->route('users.show',$user->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPassword($id)
    {
        $user = User::find($id);
        return view('users.edit_password')->withUser($user);
    }
    /**
     * Custom Validator: http://teamnik.org/how-to-update-user-password-in-laravel5/
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);

        $validation = Validator::make($request->all(), [
            // Here's how our new validation rule is used.
            'current_password' => 'required|hash:' . $user->password,
            'new_password'     => 'required|different:current_password|min:6|confirmed',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors());
        }

        $user->password = $request->new_password;
        $user->save();

        Session::flash('success','The Password was successfully updated');

        return redirect()->route('users.show',$user->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        Alert::success('The User and related data have been deleted', 'Successful' )->persistent("Close");

        return redirect()->route('users.index');
    }
}
