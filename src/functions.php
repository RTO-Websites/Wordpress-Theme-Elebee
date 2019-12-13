<?php
/**
 * @since 0.1.0
 * @author RTO GmbH <info@rto.de>
 * @licence MIT
 */
require_once( 'vendor/autoload.php' );

if ( !defined( 'TEXTDOMAIN' ) ) {

    define( 'TEXTDOMAIN', 'elebee' );

}

define( 'Elebee_VERISON', '1.0.3' );

define( 'Elebee_URL', get_stylesheet_directory_uri() );
define( 'Elebee_DIR', str_replace( '\\', '/', __DIR__ ) );


\ElebeeCore\Lib\Elebee::run();
