<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserStore extends FormRequest
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
        // dd(request()->all());
        // dd(Rule::unique('users')->ignore(request()->get('user')));
        return [
            'name' => 'required',
            'email' =>  ['required', Rule::unique('users')->ignore($this->user)],
            'password' => 'confirmed',
            'roles.*' => '',
            'powerbi_url' => '',
            'company_id' => '',
            'CRM_COREN' => ''
        ];
    }
}
