<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $product = $this->route('product');

        return [
            'name' => [
                'required', 'string', 'min:5', 'max:30',
                Rule::unique('products', 'name')
                    ->where(fn ($query) => $query->where('shop_id', $product->shop_id))
                    ->ignore($product->id)
                ],
            'description' => ['sometimes', 'string', 'max:3000'],
            'base_price' => ['required', 'numeric'],
            'category' => ['required', 'string'], //temporary
            'stocks' => ['required', 'integer', 'min:0'], 
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => "Duplicate product name. Product name already exists in your shop. Please choose a unique product name. "
        ];
    }
}
