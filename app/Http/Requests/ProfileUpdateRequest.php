<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,webp',
                'max:4096',
            ],
            'nickname' => [
                'nullable',
                'string',
                'max:255',
            ],
            'birthdate' => [
                'nullable',
                'date',
            ],
            'academic_level' => [
                'nullable',
                'integer',
            ],
            'gender' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
