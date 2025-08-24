<?php

namespace App\Constants;

class CacheKeys
{
    public const TASKS_INDEX = 'tasks_index';
    public const TASK = 'task_:id';

    public static function make(string $key, array $replacements = []): string
    {
        foreach ($replacements as $field => $value) {
            $key = str_replace(":$field", $value, $key);
        }
        return $key;
    }
}
