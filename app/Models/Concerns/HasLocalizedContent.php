<?php

namespace App\Models\Concerns;

trait HasLocalizedContent
{
    public function localized(string $field, ?string $locale = null): mixed
    {
        $locale = $locale ?: app()->getLocale();
        $translations = $this->translations ?? [];

        return $translations[$locale][$field] ?? $this->{$field};
    }
}
