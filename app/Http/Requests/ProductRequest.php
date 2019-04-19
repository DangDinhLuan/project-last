<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:200|unique:products,name,' . $this->route('product'),
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:1',
            'discount' => 'numeric|min:0|max:5',
            'category_id' => 'required',
            'image' => 'mimes:jpeg,jpg,png|image',
            'brief' => 'required|max:200',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is empty',
            'name.max' => 'Name is too long',
            'name.unique' => 'Name is taken',
            'price.required' => 'Price is empty',
            'price.numeric' => 'Price must be number',
            'price.min' => 'Price is too small',
            'discount.numeric' => 'Price is number',
            'discount.min' => 'Discount is too small',
            'quantity.required' => 'Quantity is empty',
            'quantity.numeric' => 'Quantity is number',
            'quantity.min' => 'Quantity is too small',
            'category_id.required' => 'Not choose cateogory',
            'image.required' => 'Image is not empty',
            'image.mimes' => 'Image is jpg, jpeg or png',
            'image.image' => 'Not image',
            'brief.required' => 'Brief is empty',
            'brief.max' => 'Brief is too long',
        ];
    }
}
