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
        $fileRule = [
            'file',
            'mimes:jpg,png,jpeg,webp,pdf,doc,docx,xls,xlsx,ppt,pptx',
            'max:10240' // 10MB
        ];
        if ($this->isMethod('post')) {
            array_unshift($fileRule, 'required');
        } else {
            array_unshift($fileRule, 'nullable');
        }
        $nameRule = ['string', 'min:6', 'max:30'];
        $unitIdRule = ['exists:units,id'];
        if ($this->isMethod('post')) {
            array_unshift($nameRule, 'required');
            array_unshift($unitIdRule, 'required');
        } else {
            array_unshift($nameRule, 'nullable');
            array_unshift($unitIdRule, 'nullable');
        }
        return [
            'name' => $nameRule,
            'description' => ['nullable', 'string'],
            'file_path' => $fileRule,
            'unit_id' => $unitIdRule,
        ];
    }
}
