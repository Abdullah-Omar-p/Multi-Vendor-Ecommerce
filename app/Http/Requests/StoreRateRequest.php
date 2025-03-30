<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rate' => 'required|integer|min:1|max:5',
            'product_id' => 'required|exists:products,id',
            'comment_id' => 'nullable|exists:comments,id',
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
