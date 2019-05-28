<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:3|max:191|string',
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|min:6|max:191|confirmed',
            'address' => 'required|string|min:6|max:191',
            'phone' => 'regex:/(0)[0-9]{9}/',
            'birth_day' => 'nullable|date'
        ];
    }
}
