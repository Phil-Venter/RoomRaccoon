<?php

require_once __DIR__ . '/../bootstrap.php';

Router::get(   '/',       ['ShoppingController', 'index' ]);
Router::post(  '/create', ['ShoppingController', 'create']);
Router::put(   '/put',    ['ShoppingController', 'put'   ]);
Router::delete('/delete', ['ShoppingController', 'delete']);

echo Router::run(['ErrorController', 'error']);