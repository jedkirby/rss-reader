<?php

// Useful constants.
define('DS',          DIRECTORY_SEPARATOR);
define('BASE_PATH',   realpath(__DIR__.'/../').DS);
define('APP_PATH',    BASE_PATH.'App'.DS);
define('PUBLIC_PATH', BASE_PATH.'public'.DS);

// Include the core.
require_once APP_PATH.'Core.php';

// Register autoloader.
\App\Core::registerAutoloader();

// Create a new application.
$app = new App\Core();

// Routings.
$app->router->add('/', 'App\\Controllers\\Main@showIndex');
$app->router->add('feed', 'App\\Controllers\\Feed@showView');
$app->router->add('feed/add', 'App\\Controllers\\Feed@showAdd');
$app->router->add('feed/edit', 'App\\Controllers\\Feed@showEdit');
$app->router->add('feed/remove', 'App\\Controllers\\Feed@showRemove');

// Finally, run.
$app->run();
