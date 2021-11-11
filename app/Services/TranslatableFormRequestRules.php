<?php

declare(strict_types=1);

namespace App\Services;

class TranslatableFormRequestRules
{
    public static function make(string $model, array $input): array
    {
        $model = app($model);

        $rules = collect();

        foreach ($input as $key => $rule) {
            // Check for nested array keys
            $parts = \explode('.', $key);
            if (count($parts) > 1) {
                $key = end($parts);
            }

            if ($model->isTranslatableAttribute($key)) {
                locales()->each(fn ($locale) => $rules->put("$key.$locale", $rule));
            } else {
                $rules->put($key, $rule);
            }
        }

        return $rules->all();
    }
}
