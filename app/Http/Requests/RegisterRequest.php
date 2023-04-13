<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:1'],
            'username' => ['string', 'min:1', Rule::unique('users', 'username')->ignore(request('id'), 'id')],
            'phone' => ['required', 'numeric', Rule::unique('users', 'phone')->ignore(request('id'), 'id'),],
            'password' => ['required'],
            'email' => ['required', 'string', 'regex:/^.+@.+$/', Rule::unique('users', 'email')->ignore(request('id'), 'id'),],
            'role' => ['required',],
        ];
    }
}
