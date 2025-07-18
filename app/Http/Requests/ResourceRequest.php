<?php

namespace App\Http\Requests;

use App\Models\Resource;
use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->isMethod('post')) {
            return $this->user()->can('create', Resource::class);
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->user()->can('update', $this->route('resource'));
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:6', 'max:30'],
            'description' => ['nullable', 'string'],
            'file_path' => [
                'required',
                'file',
                'mimes:jpg,png,jpeg,webp,pdf,doc,docx,xls,xlsx,ppt,pptx',
                'max:10240' // 10MB
            ],
            'unit_id' => ['required', 'exists:units,id'],
        ];
    }
}
