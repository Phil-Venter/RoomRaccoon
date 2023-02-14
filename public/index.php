<?php

foreach (glob(__DIR__ . '/../system/*.php') as $file) { include_once $file; }
foreach (glob(__DIR__ . '/../models/*.php') as $file) { include_once $file; }
foreach (glob(__DIR__ . '/../controllers/*.php') as $file) { include_once $file; }

Router::get('/', ['Home', 'index']);

Router::run(['Error', 'error']);