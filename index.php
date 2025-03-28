<?php
/**
 * Main entry point that handles URL routing
 * This redirects to the appropriate page based on the URL
 */

// Define the base URL for this application
$base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$base_url .= "://" . $_SERVER['HTTP_HOST'];

// Get the current request path
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Remove trailing slashes except for the root path
if ($path !== '/' && substr($path, -1) === '/') {
    $path = rtrim($path, '/');
    header("Location: $base_url$path");
    exit;
}

// Remove any "dashboard" from the path
$path = str_replace('/dashboard', '', $path);

// Debugging - log request information
error_log("Request URI: " . $request_uri);
error_log("Processed Path: " . $path);

// Define main routes
$routes = [
    '/' => 'home.php',
    '/login' => 'login.php',
    '/register' => 'register.php',
    '/home' => 'home.php',
    '/get1' => 'get1.php',
    '/host' => 'host.php',
    '/update_profile' => 'update_profile.php',
];

// Check if the path exists in routes, otherwise default to home
$target_file = isset($routes[$path]) ? $routes[$path] : 'home.php';

// Load the target file
include_once($target_file);
exit;
?>
