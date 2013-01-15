<?php

namespace ProjectBuilder;

class File
{
	private $name;
	private $path;

	public function __construct($path)
	{
		$path = realpath($path);
		if (!$path) {
			throw new \InvalidArgumentException("The path {$path} is invalid or the file {$path} does not exists.");
		}

		$info = pathinfo($path);
		$this->name = $info['filename'];
		$this->path = $info['dirname'];
	}

	public static function makeFileFromTemplate($template, $destiny, $name)
	{
		if (!is_writable($destiny)) {
			throw new \RunTimeException("Directory {$destiny} is not writable.");
		}

		$template = $template .DIRECTORY_SEPARATOR. $name;
		$destiny = $destiny .DIRECTORY_SEPARATOR. $name;

		copy($template, $destiny);
		return new File($destiny);
	}

	public static function makeFileFromUrl($url, $destiny, $name)
	{
		if (!is_writable($destiny)) {
			throw new \RunTimeException("Directory {$destiny} is not writable.");
		}

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$content = curl_exec($ch);
		curl_close($ch);

		$destiny = $destiny .DIRECTORY_SEPARATOR. $name;
		file_put_contents($destiny, $content);
		return new File($destiny);
	}
}