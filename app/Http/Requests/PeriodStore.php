<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PeriodStore
 * @package App\Http\Requests
 */
class PeriodStore extends FormRequest
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
            'from' => 'required|regex:/([0-9]{4})-([0-9]{2})-([0-9]{2})/i',
            'to' => 'required|regex:/([0-9]{4})-([0-9]{2})-([0-9]{2})/i'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'from.regex' => 'Date parameter "from" must be in 20XX(year)-XX(mouth)-XX(day) format',
            'to.regex' => 'Date parameter "to" must be in 20XX(year)-XX(mouth)-XX(day) format'
        ];
    }
}
