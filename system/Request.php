<?php

class Request
{
	protected array $get = [];
	protected array $post = [];
	protected array $args = [];

	public function __construct(array $args = [])
	{
		$this->get = $this->clean($_GET);
		$this->post = $this->clean($_POST);
		$this->args = $this->clean($args);
	}

	public function __get(string $name): array
	{
		if (!property_exists($this, $name)) {
			return [];
		}
		return $this->{$name};
	}

	public function setArgs(array $args = []): void
	{
		$this->args = $this->clean($args);
	}

	protected function clean(mixed $data): mixed
	{
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				unset($data[$key]);

				$data[$this->clean($key)] = $this->clean($value);
			}
		} else {
			$data = trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
		}

		return $data;
	}
}