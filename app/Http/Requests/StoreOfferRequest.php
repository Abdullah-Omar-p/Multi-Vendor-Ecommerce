<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price'     => 'required|integer',
            'name'      => 'required|string',
            'about'     => 'required|string',
            'no_pieces' => 'required|integer',
            'store_id'  => 'required|exists:stores,id',
            'custom'    => 'required|in:public,for customers',
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
