<?php

/**
 * This helpers adds more functionality to trongate's existing URL Helper
 * 
 * @version 1.0.0
 * 
 * @author ThaOracle <vimkaf@gmail.com>
 */

if (!function_exists('base_url')) {

    function base_url(string $uri = '', $protocol = null): string
    {
        $fullPath = '';

        // Set your base URL 
        $baseURL = BASE_URL;

        // Add trailing slash to $baseURL if not present
        $baseURL = rtrim($baseURL, '/') . '/';

        $url = parse_url($baseURL);

        //get the protocol as defined in the baseURL config
        $defaultProtocol = $url['scheme'];

        $host = $url['host'];

        $path = $url['path'];
        $path = rtrim($path, '/') . '/';

        // Remove leading slash from $uri if present
        $uri = ltrim($uri, '/');

        if ($protocol !== null) {
            $fullPath = $protocol . "://" . $host . $path;
        } else {
            $fullPath = $defaultProtocol . "://" . $host . $path;
        }

        if (!empty($uri)) {
            $fullPath .= $uri;
        }

        return $fullPath;
    }
}
