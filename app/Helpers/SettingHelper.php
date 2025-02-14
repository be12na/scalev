<?php

use App\Models\Websetting;

if (!function_exists('setting')) {
    function setting($key, $default = null) {
        return Websetting::getValue($key, $default);
    }
}