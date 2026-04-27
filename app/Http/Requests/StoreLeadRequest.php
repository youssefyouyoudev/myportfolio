<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'company' => ['nullable', 'string', 'max:120'],
            'project_type' => ['nullable', 'string', 'max:80'],
            'budget' => ['nullable', 'string', 'max:60'],
            'timeline' => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
            'website' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $fields = ['name', 'email', 'company', 'project_type', 'budget', 'timeline', 'message', 'website'];
        $normalized = [];

        foreach ($fields as $field) {
            $value = $this->input($field);
            $normalized[$field] = is_string($value) ? trim($value) : $value;
        }

        $this->merge($normalized);
    }
}
