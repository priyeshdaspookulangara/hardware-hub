<?php
// Database configuration
define('DB_SERVER', getenv('DB_SERVER') ?: '127.0.0.1');
define('DB_USERNAME', getenv('DB_USERNAME') ?: 'ecommerce_user');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'password');
define('DB_NAME', getenv('DB_NAME') ?: 'ecommerce');

// Attempt to connect to MySQL database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
