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
		}

		$realpath = $path .DIRECTORY_SEPARATOR. $name;
		mkdir($realpath);

		$this->path = $path;
		$this->name = $name;
	}

	public function getPath()
	{
		return $this->path .DIRECTORY_SEPARATOR. $this->name;
	}
}