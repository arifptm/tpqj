<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudent extends FormRequest
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
            'fullname' => 'required',
            'nickname' => 'required',
            'gender' => 'required',
            'group_id' => 'required',
            'institution_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Harus diisi !',
            'nickname.required'  => 'Harus diisi !',
            'gender.required' => 'Pilih salah satu !',
            'group_id.required' => 'Pilih salah satu !',
            'institution_id.required' => 'Pilih salah satu !',
        ];
    } 

}
