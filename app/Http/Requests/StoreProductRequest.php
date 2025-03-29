<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'price'             => 'required|integer|min:0',
            'discount'          => 'nullable|integer|min:0|max:100',
            'available_pieces'  => 'required|integer|min:0',
            'weight'            => 'nullable|integer|min:0',
            'color'             => 'nullable|string|max:255',
            'col_1'             => 'nullable|string|max:255',
            'col_2'             => 'nullable|string|max:255',
            'col_3'             => 'nullable|string|max:255',
            'col_4'             => 'nullable|string|max:255',
            'sold'              => 'nullable|integer|min:0',
            'rate'              => 'nullable|integer|min:0|max:5',
            'description'       => 'nullable|string',
            'media'             => 'required|image|max:1024000',
            'about'             => 'nullable|string',
            'name'              => 'required|string|max:255',
            'brand'             => 'nullable|string|max:255',
            'store_id'          => 'required|exists:stores,id',
            'category_id'       => 'required|exists:categories,id',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            \App\Helpers\Helper::responseData(
                'Validation failed',
                false,
                $validator->errors(),
                422
            )
        );
    }
}
