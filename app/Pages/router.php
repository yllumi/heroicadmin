<?php

/** 
 * Alpine Router list
 * 
 **/
$router = [
    // [Home]
    "/" => [
        'template' => [
            '/home/template',
            '/_components/bottommenu',
        ],
        'preload' => true,
    ],

    // [Not Found]
    "notfound" => [
        'preload' => true,
    ],

    // [Feeds List]
    "/feeds" => [
        'preload' => true,
        'template' => [
            '/feeds/template',
            '/_components/bottommenu',
        ],
    ],

    // [Add Feed]
    "/feeds/add" => [
        'template' => [
            '/feeds/add/template',
            '/_components/bottommenu',
        ],
    ],

    // [Feed Detail]
    "/feeds/detail/:id",


    "coba" => [ ],

    "coba/lagi" => [ ],
];
/**
 * Render Router
 * 
 **/
helper('heroic');
echo ltrim(renderRouter($router));
