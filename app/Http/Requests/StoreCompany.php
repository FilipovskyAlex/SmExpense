<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class StoreCompany
 * @package App\Http\Requests
 */
class StoreCompany extends FormRequest
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
            'name' => 'required|unique:companies,name,'.Auth::user()->id.',user_id'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'A company name is required',
            'name.unique' => 'A company name must be unique'
        ];
    }
}
