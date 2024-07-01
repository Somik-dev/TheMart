<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRre extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
          'category'=>'required',
          'subcategory'=>'required',
          'product_name'=>'required',
          'price'=>'required',
          'long_desp'=>'required',
          'preview'=>'required|image',
          'gallery'=>'required|image',
        ];
    }
    public function messages(): array
    {
        return [
          'category.required'=>'Select the category',
          'subcategory.required'=>'Select the SubCategory',
        ];
    }
}
