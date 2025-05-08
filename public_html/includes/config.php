<?php
// Error reporting - disabled for production
error_reporting(0);
ini_set('display_errors', 0);

// Site configuration
define('SITE_NAME', 'Gatita Bakes');
define('SITE_URL', 'https://darkseagreen-ferret-989166.hostingersite.com'); // Updated site URL
define('SITE_EMAIL', 'orders@gatitabakes.com');

// Time zone setting
date_default_timezone_set('America/Los_Angeles');

// Database configuration (if needed later)
// define('DB_HOST', 'localhost');
// define('DB_USER', 'username');
// define('DB_PASS', 'password');
// define('DB_NAME', 'database'); 