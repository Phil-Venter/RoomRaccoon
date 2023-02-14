<?php

class DB
{
	protected static ?DB $instance = null;

	protected static $default_driv = 'mysql';
	protected static $default_host = 'localhost';
	protected static $default_port = 3306;
	protected static $default_name = 'default';
	protected static $default_user = 'root';
	protected static $default_pass = '';

	public static function instance(array $options = []): DB
	{
		if (is_null(static::$instance)) {
			static::$instance = new DB($options);
		}

		return static::$instance;
	}

	public static function escape(string $string): string
	{
		return str_replace(
			["\\", "\0", "\n", "\r", "\x1a", "'", '"'],
			["\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'],
			$str
		);
	}

	protected function __construct(array $options)
	{
		$hasDriv = isset($options['driv']) && is_string($options['driv']) && mb_strlen(trim($options['driv'])) > 0;
		$hasHost = isset($options['host']) && is_string($options['host']) && mb_strlen(trim($options['host'])) > 0;
		$hasPort = isset($options['port']) && is_string($options['port']) && mb_strlen(trim($options['port'])) > 0;
		$hasName = isset($options['name']) && is_string($options['name']) && mb_strlen(trim($options['name'])) > 0;
		$hasUser = isset($options['user']) && is_string($options['user']) && mb_strlen(trim($options['user'])) > 0;
		$hasPass = isset($options['pass']) && is_string($options['pass']) && mb_strlen(trim($options['pass'])) > 0;

		if (!$hasDriv) { $options['driv'] = static::$default_driv; }
		if (!$hasHost) { $options['host'] = static::$default_host; }
		if (!$hasPort) { $options['port'] = static::$default_port; }
		if (!$hasName) { $options['name'] = static::$default_name; }
		if (!$hasUser) { $options['user'] = static::$default_user; }
		if (!$hasPass) { $options['pass'] = static::$default_pass; }

		if(!in_array($options['driv'], PDO::getAvailableDrivers())) {
			throw new Exception($options['driv'] . ' driver not available, [' . implode(', ', PDO::getAvailableDrivers()) . '] available');
		}

		$dsn = $options['driv'] . ':host=' . $options['host'] . ';port=' . $options['port'] . ';dbname=' . $options['name'];

		$this->pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_PERSISTENT => true]);
	}
}