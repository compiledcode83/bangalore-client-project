<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAddressRequest extends FormRequest {

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
            'governorate' => 'required|not_in:0',
            'area'        => 'required|not_in:0',
            'street'      => 'required',
            'block'       => 'required',
            'building'    => 'required',
        ];
    }
}
