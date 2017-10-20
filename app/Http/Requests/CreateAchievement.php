<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateAchievement extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'stage_id' => 'unique:achievements,stage_id,NULL,id,student_id,'.$request->student_id
        ];
    }

    public function messages()
    {
        return [
            'stage_id.unique' => 'Sudah pernah ujian kelas ini !',
        ];
    } 
}
