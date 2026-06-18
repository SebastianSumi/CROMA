<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use App\Models\Cliente;

trait ProfileValidationRules
{
    /**
     * Get the validation rules used to validate user profiles.
     *
     * @return array<string, array<int, ValidationRule|array<mixed>|string>>
     */
    protected function profileRules(?int $userId = null, ?int $clienteId = null): array
    {
        return [
            'name' => $this->nameRules(),
            'paterno' => $this->paternoRules(),
            'materno' => $this->maternoRules(),
            'email' => $this->emailRules($userId, $clienteId),
            'telefono' => $this->telefonoRules($clienteId),
        ];
    }

    /**
     * Get the validation rules used to validate user names.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function nameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * Get the validation rules used to validate user paterno.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function paternoRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * Get the validation rules used to validate user materno.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function maternoRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * Get the validation rules used to validate user emails.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function emailRules(?int $userId = null, ?int $clienteId = null): array
    {
        return [
            'required',
            'string',
            'email',
            'max:255',
            // Verificar unicidad en users
            $userId === null
                ? Rule::unique(User::class)
                : Rule::unique(User::class)->ignore($userId),
            // Verificar unicidad en clientes también
            $clienteId === null
                ? Rule::unique(Cliente::class, 'email')
                : Rule::unique(Cliente::class, 'email')->ignore($clienteId),
        ];
    }

    /**
     * Get the validation rules used to validate user telefono.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function telefonoRules(?int $clienteId = null): array
    {
        return [
            'required',
            'string',
            'max:20',
            $clienteId === null
                ? Rule::unique(Cliente::class, 'telefono')
                : Rule::unique(Cliente::class, 'telefono')->ignore($clienteId),
        ];
    }
}
