<?php

// Запуск возможен только в консольном режиме
if ( PHP_SAPI != 'cli' ) die();

if ( !version_compare( phpversion(), '5.5', '>=' ) ) {
    die( 'You should use PHP version >= 5.5' );
}

if ( !extension_loaded( 'apc' ) ) {
    echo 'APC extension recommend to install' . PHP_EOL;
}

if ( !extension_loaded( 'pdo' ) ) {
    die( 'PDO extension should be installed.' );
}

if ( !extension_loaded( 'pdo_sqlite' ) ) {
    die( 'PDO SQLite extension should be installed.' );
}

if ( !extension_loaded( 'gd' ) ) {
    die( 'GD extension should be installed.' );
}

/*
if ( !extension_loaded( 'imagick' ) ) {
    die( 'Imagick extension should be installed.' );
}
else {
    $imagick = new Imagick();
    $imagickFormats = $imagick->queryFormats( '*' );
    if ( !in_array( 'PNG', $imagickFormats ) ) {
        die( 'Imagick extension should be installed with PNG support.' );
    }
    if ( !in_array( 'JPEG', $imagickFormats ) ) {
        die( 'Imagick extension should be installed with JPEG support.' );
    }
    if ( !in_array( 'GIF', $imagickFormats ) ) {
        die( 'Imagick extension should be installed with GIF support.' );
    }
}
*/

echo 'All required extensions are installed!' . PHP_EOL;


define( 'BEEJEE_ENV', 'install' );

require 'BeeJee.php';

$options = getopt( 'u::', [ 'uninstall::' ] );
$action = isset( $options['uninstall'] ) || isset( $options['u'] ) ? 'uninstall' : 'install';

$app = new \app\components\Application( require BEEJEE_ROOT . '/config/main.php' );
$app->runAction( 'migration', $action );