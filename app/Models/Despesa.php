<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;

class Despesa extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descricao',
        'data',
        'valor',
        'users_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public static function validate(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), Despesa::rules(), Despesa::messages());
    }

    /**
     * Array de regras de validação
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'descricao' => 'required|max:191',
            'valor' => 'required|numeric|gt:0',
            'data' => 'required|date',
        ];
    }

    /**
     * Array de mensagens de erro de validação
     *
     * @return array
     */
    public static function messages(): array
    {
        return [
            'descricao.required' => 'Descreva a despesa',
            'descricao.max' => 'Limite máximo de descrição é de 191 caracteres',
            'valor.required' => 'Informe o valor da despesa',
            'valor.numeric' => 'Somente números devem ser informados',
            'valor.gt' => 'Valor deve ser maior que zero',
            'data.required' => 'Informe a data da despesa',
            'data.date' => 'Informe uma data válida (ano-mes-dia)',
        ];
    }
}
