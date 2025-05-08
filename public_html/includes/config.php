<?php
// Error reporting - temporarily enabled for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Site configuration
define('SITE_URL', 'https://darkseagreen-ferret-989166.hostingersite.com');
define('SITE_NAME', 'Gatita Bakes');
define('SITE_EMAIL', 'orders@gatitabakes.com');
define('IMAGES_PATH', 'images');

// Social media
define('VENMO_HANDLE', '@katvalderrama');

// Product configuration
$PRODUCTS = [
    'plain-sourdough' => [
        'name' => 'Plain Sourdough',
        'price' => 8.00,
        'image' => 'Plain-Sourdough-Loaf.jpg'
    ],
    'everything-sourdough' => [
        'name' => 'Everything Sourdough',
        'price' => 9.00,
        'image' => 'Everything-Sourdough-Loaf.jpg'
    ],
    'plain-bagels' => [
        'name' => 'Plain Bagels',
        'price' => 3.00,
        'image' => 'Plain-Bagels.png'
    ],
    'rosemary-sourdough' => [
        'name' => 'Rosemary Sourdough',
        'price' => 9.00,
        'image' => 'Rosemary-Sourdough-Loaf.png'
    ],
    'jalapeno-cheese-bagels' => [
        'name' => 'Jalapeño Cheese Bagels',
        'price' => 3.50,
        'image' => 'Plain-Bagels.png'
    ],
    'other-sourdough' => [
        'name' => 'Other Sourdough',
        'price' => 9.00,
        'image' => 'Other-Sourdough-Loaf.jpg'
    ]
];

// Pickup locations
$PICKUP_LOCATIONS = [
    'location1' => 'Location 1',
    'location2' => 'Location 2'
];

// Time zone setting
date_default_timezone_set('America/Los_Angeles');

// Database configuration (if needed later)
// define('DB_HOST', 'localhost');
// define('DB_USER', 'username');
// define('DB_PASS', 'password');
// define('DB_NAME', 'database'); 