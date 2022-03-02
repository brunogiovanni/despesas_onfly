<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest
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
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Informe o e-mail do usuário',
            'email.email' => 'Informe um e-mail válido',
            'password.required' => 'Informe uma senha',
            'name.required' => 'Informe o nome do usuário',
        ];
    }
}
