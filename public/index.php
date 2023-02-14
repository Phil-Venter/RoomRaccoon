<?php

require_once __DIR__ . '/../bootstrap.php';

Router::get('/',          ['ShoppingConroller', 'index' ]);
Router::post('/create',   ['ShoppingConroller', 'create']);
Router::put('/put',       ['ShoppingConroller', 'put'   ]);
Router::delete('/delete', ['ShoppingConroller', 'delete']);

echo Router::run(['ErrorController', 'error']);