<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
        $check = [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', Rule::unique('suppliers', 'phone')->ignore(request('id'), 'id')],
            'email' => ['required', 'string', 'regex:/^.+@.+$/', Rule::unique('suppliers', 'email')->ignore(request('id'), 'id')],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'district' => ['required', 'string'],
            'country' => ['required', 'string'],
        ];
        return $check;
    }
}
