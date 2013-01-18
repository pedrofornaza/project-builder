<?php

function showError($num, $message)
{
	echo "\n----------------------------- A error was occurred --------------------------\n";
	echo "- ". $message;
	echo "\n-----------------------------------------------------------------------------\n";
}

set_error_handler('showError');

if (!isset($argv[1])) {
	showError(0, "A namespace must be specified.");
	exit;
}

$namespace = strtolower($argv[1]);
$namespace = ucfirst($namespace);

$path = isset($argv[2]) ? $argv[2] : shell_exec('pwd');
$path = realpath($path);

define("DS"            , DIRECTORY_SEPARATOR);
define("ROOT_FOLDER"   , $path .DS. strtolower($namespace));
define("BIN_FOLDER"    , ROOT_FOLDER .DS. 'bin');
define("PUBLIC_FOLDER" , ROOT_FOLDER .DS. 'public');

define("SRC_FOLDER"    , ROOT_FOLDER .DS. 'src');
define("PROJECT_FOLDER", SRC_FOLDER .DS. $namespace);

define("TESTS_FOLDER"  , ROOT_FOLDER .DS. 'tests');
define("TESTS_SRC_FOLDER"  , TESTS_FOLDER .DS. 'src');
define("PROJECT_TESTS_FOLDER", TESTS_SRC_FOLDER .DS. $namespace);



echo "Stating...\n";
mkdir(ROOT_FOLDER);

$composer = fopen(ROOT_FOLDER .DS. 'composer.json', 'w');
fputs($composer,
<<<FILE
{
	"autoload" : {
		"psr-0" : { "$namespace" :  "src/" }
	},
	"require" : {

	}
}
FILE
);
fclose($composer);



echo "Bin Folder...\n";
mkdir(BIN_FOLDER);

echo "Downloading bin/composer.phar...\n";
$ch = curl_init('http://getcomposer.org/composer.phar');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$composer = curl_exec($ch);
curl_close($ch);

file_put_contents(BIN_FOLDER .DS. 'composer.phar', $composer);



echo "Public folder...\n";
mkdir(PUBLIC_FOLDER);
$index = fopen(PUBLIC_FOLDER .DS. 'index.php', 'w');
fputs($index,
<<<FILE
<?php

echo "Hello $namespace!";
FILE
);
fclose($index);

$index = fopen(PUBLIC_FOLDER .DS. '.htaccess', 'w');
fclose($index);



echo "Source Folder...\n";
mkdir(SRC_FOLDER);
mkdir(PROJECT_FOLDER);

$app = fopen(PROJECT_FOLDER .DS. 'Application.php', 'w');
fputs($app,
<<<FILE
<?php

namespace $namespace;

class Application
{
	public function __construct()
	{

	}
}
FILE
);
fclose($app);



echo "Tests folder...\n";
mkdir(TESTS_FOLDER);
mkdir(TESTS_SRC_FOLDER);
mkdir(PROJECT_TESTS_FOLDER);

$app = fopen(PROJECT_TESTS_FOLDER .DS. 'ApplicationTest.php', 'w');
fputs($app,
<<<FILE
<?php

namespace $namespace;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
	public function setup()
	{

	}

	public function teardown()
	{

	}
}
FILE
);
fclose($app);



echo "Project {$namespace} is complete.\n";