<?php

namespace ProjectBuilder;

class Output
{
	public static function outputString($string)
	{
		echo $string ."\n";
	}

	public static function outputError($num, $message, $file = 'project-builder', $line = 1)
	{
		echo '----------------------------- Error -----------------------------';
		echo "ERR$num: $message on $file, line $line";
	}
}