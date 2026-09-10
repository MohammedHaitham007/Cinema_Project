<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => ['nullable', 'regex:/^01[0125][0-9]{8}$/'],
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
