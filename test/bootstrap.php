<?php

// Set the default timezone. While this doesn't cause any tests to fail, PHP
// complains if 'date.timezone' is not set in php.ini.
date_default_timezone_set('UTC');

function includeIfExists($file) {
  if (file_exists($file)) {
    return include $file;
  }
}

if ((!$loader = includeIfExists(__DIR__.'/../vendor/autoload.php')) && (!$loader = includeIfExists(__DIR__.'/../../../.composer/autoload.php'))) {
  die('You must set up the project dependencies, run the following commands:'.PHP_EOL.
    'curl -s http://getcomposer.org/installer | php'.PHP_EOL.
    'php composer.phar install'.PHP_EOL);
}

$loader->addPsr4('Eloqua\\Tests\\', __DIR__ . '/src');

return $loader;
