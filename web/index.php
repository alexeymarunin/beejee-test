<?php

// Находим файл с настройками окружения
if ( file_exists( '.env' ) ) {
    require __DIR__ . '/BeeJee.php';
}
elseif ( file_exists( '../.env' ) ) {
    require dirname( __DIR__ ) . '/BeeJee.php';
}
elseif ( file_exists( '../../.env' ) ) {
    require dirname( dirname( __DIR__ ) ) . '/BeeJee.php';
}
else {
    header( $_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500 );
    echo 'You should configure project first';
    exit;
}

( new \app\components\Application( require BEEJEE_ROOT . '/config/main.php' ) )->run();