<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasOriginalFilterScope
{
    protected static function applyOriginalFilterScope(string $qualifiedColumn): void
    {
        $originalFilter = static::resolveOriginalFilter();

        if ($originalFilter === null) {
            return;
        }

        static::addGlobalScope('original_only', function (Builder $builder) use ($qualifiedColumn, $originalFilter) {
            $builder->where($qualifiedColumn, $originalFilter);
        });
    }

    protected static function resolveOriginalFilter(): ?int
    {
        $originalFilter = config('original_filter.value', true);

        if (is_string($originalFilter)) {
            $normalizedFilter = strtolower(trim($originalFilter));

            if ($normalizedFilter === 'all') {
                return null;
            }

            if (in_array($normalizedFilter, ['true', '1'], true)) {
                return 1;
            }

            if (in_array($normalizedFilter, ['false', '0'], true)) {
                return 0;
            }
        }

        if (is_bool($originalFilter)) {
            return $originalFilter ? 1 : 0;
        }

        if (is_numeric($originalFilter)) {
            return (int) $originalFilter === 1 ? 1 : 0;
        }

        return 1;
    }
}
