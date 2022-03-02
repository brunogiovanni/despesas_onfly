<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DespesaRequest
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
            'descricao' => 'required|max:191',
            'valor' => 'required|numeric|gt:0',
            'data' => 'required|date',
            'users_id' => 'required|integer|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'descricao.required' => 'Descreva a despesa',
            'descricao.max' => 'Limite máximo de descrição é de 191 caracteres',
            'valor.required' => 'Informe o valor da despesa',
            'valor.numeric' => 'Somente números devem ser informados',
            'valor.gt' => 'Valor deve ser maior que zero',
            'data.required' => 'Informe a data da despesa',
            'data.date' => 'Informe uma data válida (ano-mes-dia)',
            'users_id.required' => 'Informe o usuário',
            'users_id.integer' => 'Id do usuário deve ser um número',
            'users_id.exists' => 'Usuário não encontrado',
        ];
    }
}
