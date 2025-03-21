<?php

$router = [
    // [Admin Dashboard]
    "/admin",

    // [Admin User Detail]
    "/admin/user/detail/:id" => [
        'template' => '/admin/user/detail/template/:id',
        'interpolate' => true,
    ],

    // [Admin User List with optional :page]
    "/admin/user/:page?" => [
        'template' => '/admin/user/template/:page',
        'interpolate' => true,
    ],

    // [Not Found]
    "notfound",
];


/**
 * Render Router
 * 
 **/
 
helper('heroic');
echo ltrim(renderRouter($router));
 