<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     *
     */
    public function authorize(): bool
    {
        return true;
    }
}
