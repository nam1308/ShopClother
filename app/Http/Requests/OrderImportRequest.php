<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderImportRequest extends FormRequest
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
        $check = request('exists') ? ['idsupplier' => ['required', 'numeric', 'min:1'], 'ship' => ['required']] : [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', Rule::unique('suppliers', 'phone')],
            'email' => ['required', 'string', 'regex:/^.+@.+$/', Rule::unique('suppliers', 'email')],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'district' => ['required', 'string'],
            'country' => ['required', 'string'],
            'ship' => ['required'],
        ];
        return $check;
    }
}
