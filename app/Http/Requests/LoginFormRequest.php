<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guest();
    }


    /**
     * Получить сообщения об ошибках для определенных правил валидации.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Поле "e-mail" должно быть заполнено',
            'email.email' => 'Поле "e-mail" неверный формат',
            'password.required' => 'Поле "Логин" должно быть заполнено',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
