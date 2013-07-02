<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 */

// include composer autoloader
require_once realpath(__DIR__ . '/../vendor') . '/autoload.php';

use BT\HTTP\Request;
use BT\Controller\Front;
use BT\Core\Settings;
use BT\Core\Log;
use BT\Session\Session;

$actualPath = realpath(__DIR__);

// initialize the request object from the PHP super globals
$request = new Request();
$request->initializeFromSuperGlobals();

// load the application routes
$routes = require $actualPath . '/routes.php';

// load application settings
$config = require $actualPath . '/settings.php';
$settings = new Settings($config);

// set default server timezone
date_default_timezone_set($settings->get('timezone'));

// create an application logger
$logSettings = $settings->get('log'); 
$log = new Log($logSettings['general'], uniqid(), Log::LEVEL_INFO);

// initialize session - note: must call Session::start() to actually start a session
$session = new Session($log);

// create a new front controller
$front = new Front($routes, $settings, $log);
// directory where application page controllers are located
$front->controllerPath($actualPath . '/controllers/');
// directory where view/layout files are located
$front->viewPath($actualPath '/views/');

// handle the request and get a response
$response = $front->handle($request);

// end the response
$response->end();