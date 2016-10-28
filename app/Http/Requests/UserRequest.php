<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'email'        => 'required|email|max:255|unique:users',
            'password'     => 'required|min:6|confirmed',

            'first_name'   => 'required|max:255',
            'last_name'    => 'required|max:255',
            'address'      => 'max:255',
            'city'         => 'max:50',
            'province'     => '',
            'postalcode'   => 'max:6',
            'phone_number' => 'digits:10',
            'status'       => '',
            'role'         => 'required',
        ];
    }
}
