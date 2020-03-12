<?php

// Запуск возможен только в консольном режиме
if (PHP_SAPI != 'cli') {
    die();
}

if (!version_compare(phpversion(), '7.4', '>=')) {
    die('You should use PHP version >= 7.4');
}
if (!extension_loaded('pdo')) {
    die('PDO extension should be installed.');
}
if (!extension_loaded('pdo_sqlite')) {
    die('PDO SQLite extension should be installed.');
}

echo 'All required extensions are installed!' . PHP_EOL;


define('BEEJEE_ENV', 'install');

require 'BeeJee.php';

$options = getopt('u::', ['uninstall::']);
$action = isset($options['uninstall']) || isset($options['u']) ? 'uninstall' : 'install';

$app = new \app\components\Application(require BEEJEE_ROOT . '/config/main.php');
$app->runAction('migration', $action);
