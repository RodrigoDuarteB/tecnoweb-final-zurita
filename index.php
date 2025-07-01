<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// mantenimiento
if (file_exists(__DIR__.'/storage/framework/maintenance.php')) {
    require __DIR__.'/storage/framework/maintenance.php';
}

require __DIR__.'/vendor/autoload.php';

(require __DIR__.'/bootstrap/app.php')->handleRequest(
    Request::capture()
);
