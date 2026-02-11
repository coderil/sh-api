<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'filter.minPrice' => [
                'sometimes',
                'nullable',
                'numeric',
                Rule::when($this->filled('filter.maxPrice'), 'lte:filter.maxPrice'),
            ],
            'filter.maxPrice' => [
                'sometimes',
                'nullable',
                'numeric',
                Rule::when($this->filled('filter.minPrice'), 'gte:filter.minPrice'),
            ]
        ];
    }

    public function messages()
    {
        return [
            'filter.minPrice' => 'The minimum price must not exceed the maximum price.',
            'filter.maxPrice' => 'The maximum price must not be less than the minimum price.'
        ];
    }
}
