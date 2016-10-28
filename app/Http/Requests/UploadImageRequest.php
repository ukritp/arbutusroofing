<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UploadImageRequest extends Request
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
            'images.*'     => 'max:2048|required|image|mimes:jpeg,png,jpg,gif,svg',
            'description'  => '',

            'workorder_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'images.*.required' => 'Please select images to be upload 2MB max size',
            'images.*.image'    => 'Uploaded files must be an image.',
            'images.*.mimes'    => 'Accepted files type: jpeg, png, jpg, gif and svg',
        ];
    }
}
