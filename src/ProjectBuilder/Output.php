<?php

namespace ProjectBuilder;

class Output
{
	public static function outputString($string)
	{
		echo $string . PHP_EOL;
	}

	public static function outputError($num, $message, $file = 'project-builder', $line = 1)
	{
		echo '----------------------------- Error -----------------------------' . PHP_EOL;
		echo "ERR$num: $message on $file, line $line" . PHP_EOL;
	}
}