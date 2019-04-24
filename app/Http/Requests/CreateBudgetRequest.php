<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBudgetRequest extends FormRequest
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
            'department' => 'required|integer|not_regex:/Choose department/i',
            'period' => 'required|integer|not_regex:/Choose period/i',
            'item' => 'required',
            'unit' => 'required|integer',
            'quantity' => 'required|integer',
            'budget' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'department:not_regex' => 'Department is required',
            'period:not_regex' => 'Period is required'
        ];
    }
}
