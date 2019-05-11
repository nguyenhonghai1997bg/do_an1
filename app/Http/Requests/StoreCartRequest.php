<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
            'product_id' =>'required|numeric|exists:products,id',
            'name' => 'required|min:3|exists:products,name',
            'quantity' => 'required|min:1|max:8|numeric',
            'price' => 'required|min:1',
            'image_url' => 'required|min:3',
        ];
    }
}
