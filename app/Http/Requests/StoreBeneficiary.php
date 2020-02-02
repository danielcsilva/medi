<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiary extends FormRequest
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
            'name' => 'required',
            'email' => '',
            'birth_date' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'imc' => 'required',
            'gender' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Campo obrigatório'
        ];
    }
}
