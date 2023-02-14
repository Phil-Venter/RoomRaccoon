<?php

class Response
{
	protected int $code = 200;
	protected array $header = [];
	protected ?Template $template = null;

	public function __construct($template)
	{
		$this->template = $template;
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

	public function view(string $file, array $data = []): string
	{
		http_response_code($this->code);
		foreach ($this->header as $header) {
			header($header);
		}
		return $this->template->build($file, $data);
	}

	public function redirect(string $url, int $status = 302): void
	{
		$_url = str_replace(['&amp;', "\n", "\r"], ['&', '', ''], $url);
		$_status = preg_match('/^30[1237]$/', $status) > 0 ? $status : 301;
		header('Location: ' . $_url, true, $_status);
		exit();
	}
}