<?php
/**
 * @since 0.1.0
 * @author RTO GmbH <info@rto.de>
 * @licence MIT
 */
require_once( 'vendor/autoload.php' );

if( ! defined( 'TEXTDOMAIN' ) ) {

    define( 'TEXTDOMAIN', 'elebee' );

}

\ElebeeCore\Lib\Elebee::run();
