<?php

if (!isset($argv[1])) {
	echo "A namespace must be specified.";
	exit;
}

$namespace = strtolower($argv[1]);
$namespace = ucfirst($namespace);

$path = isset($argv[2]) ? $argv[2] : shell_exec('pwd');
$path = realpath($path);

define("DS"             , DIRECTORY_SEPARATOR);
define("TEMPLATE_FOLDER", dirname(__DIR__) .DS. 'templates');
define("SRC_FOLDER", dirname(__DIR__) .DS. 'src' .DS. 'ProjectBuilder');

include SRC_FOLDER .DS. 'Output.php';
include SRC_FOLDER .DS. 'Folder.php';
include SRC_FOLDER .DS. 'File.php';

try {
	ProjectBuilder\Output::outputString("Making root folder...");
	$rootFolder = new ProjectBuilder\Folder($path, $namespace);

	$composerJson = ProjectBuilder\File::makeFileFromTemplate(TEMPLATE_FOLDER, $rootFolder->getPath(), 'composer.json');


	ProjectBuilder\Output::outputString("Making public folder...");
	$publicFolder = new ProjectBuilder\Folder($rootFolder->getPath(), 'public');

	$index = ProjectBuilder\File::makeFileFromTemplate(TEMPLATE_FOLDER, $publicFolder->getPath(), 'index.php');
	$htaccess = ProjectBuilder\File::makeFileFromTemplate(TEMPLATE_FOLDER, $publicFolder->getPath(), '.htaccess');


	ProjectBuilder\Output::outputString("Making src folder...");
	$srcFolder = new ProjectBuilder\Folder($rootFolder->getPath(), 'src');
	$projectFolder = new ProjectBuilder\Folder($srcFolder->getPath(), $namespace);

	$app = ProjectBuilder\File::makeFileFromTemplate(TEMPLATE_FOLDER, $projectFolder->getPath(), 'Application.php');


	ProjectBuilder\Output::outputString("Making tests folder...");
	$testsFolder = new ProjectBuilder\Folder($rootFolder->getPath(), 'tests');
	$srcTestsFolder = new ProjectBuilder\Folder($testsFolder->getPath(), 'src');
	$projectTestsFolder = new ProjectBuilder\Folder($srcTestsFolder->getPath(), $namespace);

	$appTest = ProjectBuilder\File::makeFileFromTemplate(TEMPLATE_FOLDER, $projectTestsFolder->getPath(), 'ApplicationTest.php');


	ProjectBuilder\Output::outputString("Making bin folder...");
	$binFolder = new ProjectBuilder\Folder($rootFolder->getPath(), 'bin');

	ProjectBuilder\Output::outputString("Downloading composer.phar...");
	$composerPhar = ProjectBuilder\File::makeFileFromUrl('http://getcomposer.org/composer.phar', $binFolder->getPath(), 'composer.phar');

	ProjectBuilder\Output::outputString("Project {$namespace} is complete.");
} catch (Exception $e) {
	ProjectBuilder\Output::outputString(
		"------------ Houston, we have a problem ------------". PHP_EOL
		"--". $e->getMessage();
	);
}