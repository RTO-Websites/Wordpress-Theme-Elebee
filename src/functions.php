<?php
/**
 * @since 0.1.0
 * @author RTO GmbH <info@rto.de>
 * @licence MIT
 */
require_once( 'vendor/autoload.php' );

if ( !defined( 'Elebee_TEXTDOMAIN' ) ) {

    define( 'Elebee_TEXTDOMAIN', 'elebee' );

}

define( 'Elebee_VERISON', '1.1.2' );

define( 'Elebee_URL', get_stylesheet_directory_uri() );
define( 'Elebee_DIR', str_replace( '\\', '/', __DIR__ ) );


\ElebeeCore\Lib\Elebee::run();
