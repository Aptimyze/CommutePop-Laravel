<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AlertRequest extends Request
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
            'email' => 'required|email',
            'stop' => 'required|numeric|digits_between:1,4',
            'route' => 'required|numeric|digits_between:1,3',
            'lead_time' => 'required|numeric|digits_between:1,3',
            'time_to_stop' => 'required|numeric|digits_between:1,3',
            'departure_time' => ['required', 'regex:/(^([01]\d|2[0-3]):?([0-5]\d)$)|(^(([1-9]{1})|([0-1][1-2])|(0[1-9])|([1][0-2])):([0-5][0-9])*\s?(([aA])|([pP]))[mM]$)/'],
            'monday' => 'boolean|required_without_all:tuesday,wednesday,thursday,friday,saturday,sunday',
            'tuesday' => 'boolean|required_without_all:monday,wednesday,thursday,friday,saturday,sunday',
            'wednesday' => 'boolean|required_without_all:monday,tuesday,thursday,friday,saturday,sunday',
            'thursday' => 'boolean|required_without_all:monday,tuesday,wednesday,friday,saturday,sunday',
            'friday' => 'boolean|required_without_all:monday,tuesday,wednesday,thursday,saturday,sunday',
            'saturday' => 'boolean|required_without_all:monday,tuesday,wednesday,thursday,friday,sunday',
            'sunday' => 'boolean|required_without_all:monday,tuesday,wednesday,thursday,friday,saturday'
        ];
    }
}
