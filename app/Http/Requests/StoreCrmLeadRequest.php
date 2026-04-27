<?php

namespace App\Http\Requests;

use App\Models\CrmLead;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCrmLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:160'],
            'category' => ['nullable', 'string', 'max:120'],
            'city' => ['nullable', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:180'],
            'website' => ['nullable', 'url', 'max:255'],
            'source' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:4000'],
            'status' => ['required', Rule::in(array_keys(CrmLead::statuses()))],
            'reply_count' => ['nullable', 'integer', 'min:0'],
            'estimated_revenue' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $fields = ['business_name', 'category', 'city', 'phone', 'email', 'website', 'source', 'notes', 'status', 'reply_count', 'estimated_revenue'];
        $normalized = [];

        foreach ($fields as $field) {
            $value = $this->input($field);
            $normalized[$field] = is_string($value) ? trim($value) : $value;
        }

        $this->merge($normalized);
    }
}
