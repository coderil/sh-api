<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:shops,name', 'min:5', 'max:30', 'regex:/^[a-zA-Z0-9 ]+$/'],
            'description' => ['sometimes', 'string'],
            'logo' => ['sometimes', 'file', 'mimes:jpg,png']
        ];
    }
}
