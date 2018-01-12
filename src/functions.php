<?php
/**
 * @since 0.1.0
 * @author RTO GmbH <info@rto.de>
 * @licence MIT
 */
require_once( 'vendor/autoload.php' );

ini_set( "display_errors", WP_DEBUG || current_user_can( 'debug' ) );
ini_set( 'error_reporting', E_ALL );

if( ! defined( 'TEXTDOMAIN' ) ) {

    define( 'TEXTDOMAIN', 'elebee' );

}

\Elebee\Lib\Elebee::run();
