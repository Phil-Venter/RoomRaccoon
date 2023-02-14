<?php

class Response
{
	protected int $code = 200;
	protected array $header = [];
	protected string $output = '';

	public function redirect(string $url, int $status = 302): void
	{
		header('Location: ' . str_replace(['&amp;', "\n", "\r"], ['&', '', ''], $url), true, $status);
		exit();
	}

	public function __get(string $key): mixed
	{
		if (!property_exists($this, $key)) {
			return null;
		}

		return $this->{$key};
	}

	public function __set(string $key, mixed $val): void
	{
		if (!property_exists($this, $key)) {
			return;
		}

		if (is_array($this->{$key}) && is_string($val)) {
			$this->{$key}[] = $val;
		} elseif (gettype($this->{$key}) === gettype($val)) {
			$this->{$key} = $val;
		}
	}

	public function __toString()
	{
		http_response_code($this->code);
		foreach ($this->header as $header) {
			header($header);
		}
		return $this->output;
	}
}