<?php

class Router
{
	protected static array $routes = [];

	public static function __callStatic($method, $args): void
	{
		$route = null;
		if ((isset($args['route']) && is_string($args['route']))
			|| (isset($args[0]) && is_string($args[0]))) {
			$route = $args['route'] ?? $args[0];
		}

		$callable = null;
		if ((isset($args['callable']) && is_callable($args['callable']))
			|| (isset($args[1]) && is_callable($args[1]))) {
			$callable = $args['callable'] ?? $args[1];
		}

		if (is_null($route) || is_null($callable)) {
			return;
		}

		$_route = '/^' . str_replace('/', '\/', trim(preg_replace('/\+/', '/', $route), '/')) . '$/';

		static::$routes[$_route][$method] = $callable;
	}

	public static function run($error): mixed
	{
		$request_uri = explode('?', trim(rawurldecode($_SERVER['REQUEST_URI']), '/'))[0];
		$request_method = $_SERVER['REQUEST_METHOD'];

		$request = new Request();
		$response = new Response();

		foreach (static::$routes as $route => $method_callable) {
			if (preg_match($route, $request_uri, $params)) {
				if (array_key_exists($request_method, $method_callable)) {
					array_shift($params);
					$request->setArgs($params);
					return call_user_func_array($method_callable[$request_method], [$request, $response]);
				} else {
					$request->setArgs(['error' => 403]);
					$response->code = 403;
					return call_user_func_array($error, [$request, $response]);
				}
			}
		}

		$request->setArgs(['error' => 403]);
		$response->code = 404;
		return call_user_func_array($error, [$request, $response]);
	}
}