<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function despesas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Despesa::class, 'users_id', 'id');
    }

    public static function validate(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if ($request->method() === 'PUT') {
            return Validator::make($request->all(), User::rulesUpdate($request->id), User::messages());
        }
        return Validator::make($request->all(), User::rulesStore(), User::messages());
    }

    /**
     * Array de regras de validação
     *
     * @return array
     */
    public static function rulesStore(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => 'required',
        ];
    }

    /**
     * Array de regras de validação
     *
     * @return array
     */
    public static function rulesUpdate(int $userId): array
    {
        return [
            'email' => 'required|email|unique:users,email,' . $userId,
            'name' => 'required',
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
            'email.required' => 'Informe o e-mail do usuário',
            'email.email' => 'Informe um e-mail válido',
            'email.unique' => 'E-mail já cadastrado',
            'password.required' => 'Informe uma senha',
            'name.required' => 'Informe o nome do usuário',
        ];
    }
}
