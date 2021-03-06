<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompanyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'company_name' => 'max:255',
            'label'        => '',

            'first_name'   => 'required|max:255',
            'last_name'    => 'required|max:255',
            'address'      => 'max:255',
            'city'         => 'max:50',
            'province'     => '',
            'postalcode'   => 'max:6',
            'phone_number' => 'digits:10',

            'user_id'      => 'required|numeric',
        ];
    }
}
