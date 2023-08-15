<?php

//error_reporting(0);
header('content-type: text/html; charset=utf-8');
//mb_internal_encoding("UTF-8");
date_default_timezone_set('Europe/Berlin');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'functions.php');

putenv('BASEDIR=' . realpath( __DIR__ . DIRECTORY_SEPARATOR . '../../') . DIRECTORY_SEPARATOR );
checkEnvExistence();
require_once(getenv('BASEDIR') . 'vendor/autoload.php');

try {
	if (
		isset($_GET['conf'])
		and
		file_exists(getenv('BASEDIR') . '.env.' . $_GET['conf'])
	) {
		$configfile = '.env.' . $_GET['conf'];
	}
	else {
		$configfile = '.env';
	}
	$dotenv = Dotenv\Dotenv::createUnsafeImmutable(getenv('BASEDIR'), $configfile);
	$dotenv->load();
} catch (\Exception $e) {
	echo $e->getMessage();
	exit;
}

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'PassCard.php');

$loader = new \Twig\Loader\FilesystemLoader([
	env('BASEDIR') . 'template' . DIRECTORY_SEPARATOR,
]);
$twig = new \Twig\Environment($loader, array());

$env = new \Twig\TwigFunction('env', function ($var) {
    return env($var);
});
$twig->addFunction($env);
