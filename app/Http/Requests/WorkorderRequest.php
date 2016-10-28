<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class WorkorderRequest extends Request
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
            'description'         => 'required',
            'workorder_number'    => '',

            'tenant_first_name'   => 'max:255',
            'tenant_last_name'    => 'max:255',
            'tenant_phone_number' => 'digits:10',

            'property_id'         => 'required|numeric',
        ];
    }
}
