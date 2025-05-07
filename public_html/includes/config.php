<?php
// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Site configuration
define('SITE_NAME', 'Gatita Bakes');
define('SITE_URL', ''); // Add your site URL here
define('SITE_EMAIL', 'orders@gatitabakes.com');

// Time zone setting
date_default_timezone_set('America/Los_Angeles');

// Database configuration (if needed later)
// define('DB_HOST', 'localhost');
// define('DB_USER', 'username');
// define('DB_PASS', 'password');
// define('DB_NAME', 'database'); 