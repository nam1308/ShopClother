<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountRequest extends FormRequest
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
            'description' => ['required', 'string', 'min:1'],
            'type' => ['required'],
            'begin' => ['required', 'date', 'lte:end'],
            'end' => ['required', 'date', 'gte:begin'],
            'code' => ['required'],
            'persent' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'photo' => request('id') ? '' : ['required', 'file'],
            'code' => ['required', Rule::unique('discount', 'code')->ignore(request('id'), 'id'),],
            'product' => request('type') == 1 ? ['required', Rule::exists('discount', 'relation_id')] : '',

        ];
    }
}
