<?php

class Router
{
	protected static array $routes = [];
	protected static ?Request $request = null;
	protected static ?Response $response = null;

	public static function init(Request $request, Response $response)
	{
		static::$request = $request;
		static::$response = $response;
	}

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

		static::$routes[$_route][strtoupper($method)] = $callable;
	}

	public static function run($error): mixed
	{
		$request_uri = explode('?', trim(rawurldecode($_SERVER['REQUEST_URI']), '/'))[0];
		$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

		foreach (static::$routes as $route => $method_callable) {
			if (preg_match($route, $request_uri, $params)) {
				if (array_key_exists($request_method, $method_callable)) {
					array_shift($params);
					static::$request->setArgs($params);
					return (string)call_user_func_array($method_callable[$request_method], [
						static::$request,
						static::$response
					]);
				} else {
					static::$request->setArgs(['error' => 403]);
					$response->code = 403;
					return (string)call_user_func_array($error, [
						static::$request,
						static::$response
					]);
				}
			}
		}

		static::$request->setArgs(['error' => 403]);
		static::$response->code = 404;
		return (string)call_user_func_array($error, [
			static::$request,
			static::$response
		]);
	}
}