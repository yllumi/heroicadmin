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
    ],

    // [Add Feed]
    "/feeds/add" => [
        'template' => [
            '/feeds/add/template',
            '/_components/bottommenu',
        ],
    ],

    // [Feed Detail]
    "/feeds/detail/:id" => [
        'template' => [
            '/feeds/detail/template',
            '/_components/bottommenu',
        ],
        // 'handler' => ['isLoggedIn', 'anotherHandler'],
    ],
];


/**
 * Render Router
 * 
 **/
 
helper('heroic');
echo ltrim(renderRouter($router));
