<?php

if (!function_exists('destinationImage')) {

    function destinationImage($code)
    {
        $code = strtolower(trim($code));

        $path = public_path("images/destinations/{$code}.avif");

        if (file_exists($path)) {
            return asset("images/destinations/{$code}.avif");
        }

        return asset("images/destinations/default.avif");
    }
}