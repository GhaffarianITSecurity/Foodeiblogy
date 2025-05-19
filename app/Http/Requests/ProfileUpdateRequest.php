<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
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
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'user_avatar' => ['nullable', 'image', 'max:1024'], // max 1MB
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'نام کامل الزامی است',
            'email.required' => 'ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل نامعتبر است',
            'email.unique' => 'این ایمیل قبلا ثبت شده است',
            'user_avatar.image' => 'فایل باید تصویر باشد',
            'user_avatar.max' => 'حجم تصویر نباید بیشتر از 1 مگابایت باشد',
        ];
    }
}
