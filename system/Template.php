<?php

class Template
{
	protected $directory = '';
	protected $extension = '.tpl';

	public function __construct(string $directory, string $extension = '.tpl')
	{
		$this->directory = $directory;
		$this->extension = $extension;
	}

	public function build(string $file, array $data = []): string
	{
		$_file = $this->directory . $file . $this->extension;

		if (!is_file($_file)) {
			return '';
		}

		ob_start();
		extract($data);
		include $_file;
		return ob_get_clean();
	}
}