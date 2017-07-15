<?php

declare(strict_types = 1);

use Nette\Loaders\RobotLoader;
use Tester\Environment;

require_once __DIR__ . '/../vendor/autoload.php';

Environment::setup();
date_default_timezone_set('Europe/Prague');

define('TEMP_DIR', __DIR__ . '/../temp/');

if (!@mkdir(TEMP_DIR) && !is_dir(TEMP_DIR)) {
	throw new \RuntimeException(sprintf('Unable to create temporary directory (%s)!', TEMP_DIR));
}

$loader = new RobotLoader;
$loader
	->setTempDirectory(TEMP_DIR)
	->setAutoRefresh()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../src');

return $loader->register();
