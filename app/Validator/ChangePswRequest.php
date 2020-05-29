<?php

namespace App\Validator;

use App\Http\Requests\Request;

class ChangePswRequest extends Request
{
    protected $rules = [
        'oldPsw'=>'reqiured',
        'newPsw'=>'reqiured',
        'confirmPsw'=>'reqiured'
    ];

    protected $strings_key = [
        'oldPsw'=>'舊密碼',
        'newPsw'=>'新密碼',
        'confirmPsw'=>'新密碼確認'
    ];

    protected $strings_val = [
        'reqiured'=>'為必填項'
    ];

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
            'oldPsw'=>'reqiured',
            'newPsw'=>'reqiured',
            'confirmPsw'=>'reqiured'
        ];
    }

    protected function formatErrors(Validator $validator) 
    {
        
    }
}
