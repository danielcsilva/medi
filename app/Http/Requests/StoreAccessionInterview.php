<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccessionInterview extends FormRequest
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
            'interviewed_name' => '', 
            'interview_date' => '', 
            'interviewed_by' => '', 
            'interview_comments' => '', 
            'interview_validated' => '', 
            'user_id' => '', 
            'accession_id' => '',
            'inconsistency_id' => ''
        ];
    }
}
