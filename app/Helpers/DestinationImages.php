<?php

if (!function_exists('destinationImage')) {

    function destinationImage($code)
    {

        $images = [

            'DXB' => 'https://upload.wikimedia.org/wikipedia/commons/9/93/Dubai_Marina_Skyline.jpg',
            'IST' => 'https://upload.wikimedia.org/wikipedia/commons/e/e3/Istanbul_asv2020-02_img61_Hagia_Sophia.jpg',
            'DOH' => 'https://upload.wikimedia.org/wikipedia/commons/1/1c/Doha_Skyline.jpg',
            'CDG' => 'https://upload.wikimedia.org/wikipedia/commons/a/a8/Paris_Night.jpg',

        ];

        return $images[$code] ?? 'https://upload.wikimedia.org/wikipedia/commons/6/6e/World_map_blank_without_borders.svg';
    }

}