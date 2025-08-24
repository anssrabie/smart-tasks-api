<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait AutoFlushCache
{
    protected static function bootAutoFlushCache(): void
    {
        static::updated(fn ($model) => static::flushCacheIfPossible($model));
        static::deleted(fn ($model) => static::flushCacheIfPossible($model));
    }

    protected static function flushCacheIfPossible($model): void
    {
        if (!property_exists($model, 'cacheKeys') && !property_exists($model,'primaryCacheKeys')) {
            throw new \RuntimeException("Missing or invalid cacheKeys or primaryCacheKeys property in " . static::class);
        }

        // Flush primary cache keys
        if (property_exists($model,'primaryCacheKeys')){
            $primaryCacheKeys = $model->primaryCacheKeys;
            foreach (self::resolveCacheKeys($model, $primaryCacheKeys) as $finalKey) {
                Cache::forget($finalKey);
            }
        }

        // Flush other cache keys
        if (property_exists($model, 'cacheKeys')){
            $keys = $model->cacheKeys ?? [];
            if (is_string($keys)) {
                $keys = [$keys];
            }

            foreach ($keys as $key) {
                Cache::forget($key);
            }
        }
    }

    protected static function resolveCacheKeys($model, array $keys): array
    {
        return array_map(function ($key) use ($model) {
            return preg_replace_callback('/:(\w+)/', function ($matches) use ($model) {
                $field = $matches[1];
                return $model->{$field} ?? '';
            }, $key);
        }, $keys);
    }
}
