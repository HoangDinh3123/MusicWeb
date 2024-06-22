<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'max:255',
                'unique:users,email'
            ],
            'name' => [
                'required',
                'max:255',
            ],
            'gender' => [
                'required',
                'numeric',
                'max:3'
            ],
            'location' => [
                'max:255',
            ],
            'social_network' => [
                'max:255',
            ],
            'password' => [
                'required',
                'confirmed'
            ]
        ];
    }
}
