<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class ProductRequest extends FormRequest
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
            'name' => ['required',],
            'description' => ['required', 'string', 'min:1'],
            'category' => ['required', 'numeric'],
            'priceImport' => ['required', 'numeric', 'min:1', 'lte:priceSell'],
            'priceSell' => ['required', 'numeric', 'min:1', 'gte:priceImport'],
            'gender' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
            'brand' => ['required', 'numeric'],
            'photo' => request('id') ? '' : ['required', 'file'],
            'code' => ['required', Rule::unique('products', 'code')->ignore(request('id'), 'id'),],
            'status' => ['required', 'numeric'],
            'featured' => ['required', 'numeric'],
        ];
    }
}
