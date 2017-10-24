<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AlmarufTransactionRequest extends FormRequest
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
        $id = $this->id ?: NULL;

        if ($this->credit == 'no'){
            return [
                'student_id' => 'required',
                'amount' => 'numeric|required',
                'transaction_type_id' =>'required',
                'tuition_month' => 'required_if:transaction_type_id,4',                
                'tuition_month_ymd' => 'nullable|unique:almaruf_transactions,tuition_month,'.$id.',id,student_id,'.$this->student_id,
            ];
        } elseif ($this->credit == 'yes'){
            return [
                'amount' => 'numeric|required',
                'transaction_type_id' =>'required',
            ];                        
        }
    }

    public function messages()
    {
        if ($this->credit == 'no'){
            return [
                'student_id.required' => 'Nama siswa harus diisi...',
                'amount.required' => 'Jumlah transaksi harus diisi...',
                'amount.numeric' => 'Hanya boleh diisi angka...',
                'transaction_type_id.required' => 'Jenis transaksi harus diisi...',
                'tuition_month_ymd.unique' => 'SPP bulan tersebut sudah dibayar...',
                'tuition_month.required_if' => 'Bulan SPP harus diisi...',
            ];
        } elseif ($this->credit == 'yes'){
            return [
                'amount.required' => 'Jumlah transaksi harus diisi...',
                'amount.numeric' => 'Hanya boleh diisi angka...',
                'transaction_type_id.required' => 'Jenis transaksi harus diisi...',
            ];
        }
    }   
    
}
