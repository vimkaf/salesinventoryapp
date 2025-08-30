<?php

if (!function_exists('setting')) {
    function setting(string $key, $fromDB = false): string|null
    {
        $key = strtoupper($key);
        if ($fromDB === false && defined($key)) {
            return constant($key);
        }

        $query = "SELECT * FROM settings WHERE setting_name = :setting_name";
        return null;
    }
}