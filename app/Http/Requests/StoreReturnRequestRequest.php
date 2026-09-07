<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReturnRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'order_item_id' => ['required', 'integer', 'exists:order_items,id'],

            'request_type' => [
                'required',
                Rule::in(['return', 'exchange']),
            ],

            'exchange_variant_id' => [
                'nullable',
                'integer',
                'exists:product_variants,id',
                Rule::requiredIf($this->input('request_type') === 'exchange'),
            ],

            'quantity' => ['required', 'integer', 'min:1'],

            'reason' => ['required', 'string', 'max:2000'],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }
}
