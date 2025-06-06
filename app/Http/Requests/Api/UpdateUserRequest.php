<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|max:200',
            'last_name' => 'nullable|string|max:200',
            'is_admin' => 'nullable',
            'password' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg',
        ];
    }
}
