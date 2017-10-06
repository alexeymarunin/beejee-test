<?php

define( 'BEEJEE_ROOT', __DIR__ );

require 'vendor/autoload.php';

if ( !function_exists( 'env' ) ) {
    function env( $name, $default = null )
    {

        if ( ( $value = getenv( $name ) ) === false ) {
            $value = $default;
        }

        if ( $value == 'true' ) $value = true;
        if ( $value == 'false' ) $value = false;

        return $value;

    }
}

( new \Dotenv\Dotenv( __DIR__ ) )->load();

defined( 'BEEJEE_DEBUG' ) or define( 'BEEJEE_DEBUG', env( 'BEEJEE_DEBUG', true ) );
defined( 'BEEJEE_ENV' ) || define( 'BEEJEE_ENV', env( 'BEEJEE_ENV', 'dev' ) );
defined( 'BEEJEE_ENV_INSTALL' ) || define( 'BEEJEE_ENV_INSTALL', BEEJEE_ENV == 'install' );
defined( 'BEEJEE_ENV_DEV' ) || define( 'BEEJEE_ENV_DEV', BEEJEE_ENV == 'dev' );
defined( 'BEEJEE_ENV_TEST' ) || define( 'BEEJEE_ENV_TEST', BEEJEE_ENV == 'test' );




