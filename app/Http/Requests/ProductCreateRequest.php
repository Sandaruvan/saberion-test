<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'name' => 'required',
            'category' => 'required',
            'code' => 'required|alpha_num|unique:products',
            'selling_price' => 'required|numeric|gt:0',
            'special_price' => 'nullable|numeric|gt:0',
            'status' => 'required',
            'is_delivery_available' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
