<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassAccountRequest extends FormRequest
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
        // dd('day la use dang ki: ', request()->all());
        return [
            'username' => ['required',],
            'password' => ['required',],
            'newpassword' => ['required',],
            'newpassword_confirmation' => ['required',],
        ];
    }
}
