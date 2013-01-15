<?php

namespace ProjectBuilder;

class Folder
{
	private $name;
	private $path;

	public function __construct($path, $name)
	{
		if (!$path) {
			throw new \InvalidArgumentException("The path {$path} is not valid.");
		} else if (!is_writable($path)) {
			throw new \RunTimeException("Directory {$name} is not writable.");
		}

		$realpath = $path .DIRECTORY_SEPARATOR. $name;
		if(is_dir($realpath)) {
			throw new \RunTimeException("Directory {$name} already exists.");
		}

		mkdir($realpath);

		$this->path = $path;
		$this->name = $name;
	}

	public function getPath()
	{
		return $this->path .DIRECTORY_SEPARATOR. $this->name;
	}
}