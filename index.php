<?php
// header("Location: https://kgh.jmnmedicalcollege.co.in/");
// exit;

use Illuminate\Http\Request;


// Remove memory limit
ini_set('memory_limit', '-1');

// Remove execution time limit
set_time_limit(0);
ini_set('max_execution_time', 0);
ini_set('max_input_time', 0);

// Allow large post/upload size
ini_set('post_max_size', '512M');
ini_set('upload_max_filesize', '512M');

// Disable output buffering for faster direct processing
ini_set('output_buffering', 'Off');

// Enable garbage collection
gc_enable();

// Optional: increase realpath cache
ini_set('realpath_cache_size', '8096K');
ini_set('realpath_cache_ttl', '900');

// Optional: ignore user disconnect
ignore_user_abort(true);

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/bootstrap/app.php')
    ->handleRequest(Request::capture());
