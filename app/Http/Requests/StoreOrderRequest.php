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
            'product_id' => 'required_without:offer_id|exists:products,id',
            'offer_id'   => 'required_without:product_id|exists:offers,id',
            'price' => 'required|integer',
            'store_id' => 'required|exists:stores,id',
            'location' => 'required|string',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
