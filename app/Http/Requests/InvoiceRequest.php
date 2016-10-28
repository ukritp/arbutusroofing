<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InvoiceRequest extends Request
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
            'files.*'     => 'max:2048|required|mimes:pdf',
            'description'  => '',
            'invoiced_at'  => 'required',

            'workorder_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'files.*.required' => 'Please select PDF to be upload 2MB max size',
            'files.*.mimes'    => 'Accepted files type: pdf',
        ];
    }
}
