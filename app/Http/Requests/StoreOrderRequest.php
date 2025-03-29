<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'prohibited_unless:offer_id,null, required_without:offer_id',
            'offer_id'   => 'prohibited_unless:product_id,null, required_without:product_id',
            'price'      => 'required|integer',
            'store_id'   => 'required|exists:stores,id',
            'location'   => 'required|string',
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
