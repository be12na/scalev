<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Websetting extends Model
{
    public static function getValue(string $key, $default = null)
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            return self::where('slug', $key)->value('content') ?? $default;
        });
        
    }

    public static function setValue(string $key, string $value)
    {
        Cache::forget("setting_{$key}");
        Cache::forever("setting_{$key}", $value);
    }
}
