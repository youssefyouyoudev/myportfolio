<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadFinderSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'city' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:120'],
            'country' => ['required', 'string', 'max:120'],
            'max_results' => ['required', 'integer', 'min:1', 'max:25'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $fields = ['city', 'category', 'country'];
        $normalized = [];

        foreach ($fields as $field) {
            $value = $this->input($field);
            $normalized[$field] = is_string($value) ? trim($value) : $value;
        }

        $normalized['max_results'] = (int) $this->input('max_results', 10);

        $this->merge($normalized);
    }
}
