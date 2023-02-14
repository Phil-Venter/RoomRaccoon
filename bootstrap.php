<?php

include_once 'config.php';

foreach (glob(__DIR__ . '/system/*.php') as $file) {
	include_once $file;
}

foreach (glob(__DIR__ . '/models/*.php') as $file) {
	include_once $file;
}

foreach (glob(__DIR__ . '/controllers/*.php') as $file) {
	include_once $file;
}

$template = new Template(TEMPLATE_DIR, TEMPLATE_EXTENSION);

$request = new Request();
$response = new Response($template);

Router::init($request, $response);