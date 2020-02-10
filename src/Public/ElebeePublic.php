<?php
/**
 * The public-facing functionality of the theme.
 *
 * @since   0.1.0
 *
 * @package ElebeeCore\Pub
 * @author  RTO GmbH <info@rto.de>
 * @licence GPL-3.0
 * @link    https://rto-websites.github.io/elebee-core-api/master/ElebeeCore/Pub/ElebeePublic.html
 */

namespace ElebeeCore\Pub;


use ElebeeCore\Admin\Setting\Google\Analytics\SettingAnonymizeIp;
use ElebeeCore\Admin\Setting\Google\Analytics\SettingTrackingId;
use ElebeeCore\Admin\Setting\SettingJQuery;
use ElebeeCore\Admin\Setting\SettingJQueryNoMigrate;
use ElebeeCore\Lib\Util\Template;

\defined( 'ABSPATH' ) || exit;

/**
 * The public-facing functionality of the theme.
 *
 * Defines the theme name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since   0.1.0
 *
 * @package ElebeeCore\Pub
 * @author  RTO GmbH <info@rto.de>
 * @licence GPL-3.0
 * @link    https://rto-websites.github.io/elebee-core-api/master/ElebeeCore/Pub/ElebeePublic.html
 */
class ElebeePublic {

    /**
     * The ID of this theme.
     *
     * @since 0.1.0
     * @var string The ID of this theme.
     */
    private $themeName;

    /**
     * The version of this theme.
     *
     * @since 0.1.0
     * @var string $version The current version of this theme.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $themeName The name of the theme.
     * @param string $version The version of this theme.
     * @since 0.1.0
     *
     */
    public function __construct( string $themeName, string $version ) {

        $this->themeName = $themeName;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @return void
     * @since 0.1.0
     *
     */
    public function enqueueStyles() {

        wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/css/main.min.css', [], $this->version, 'all' );

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @return void
     * @since 0.1.0
     *
     */
    public function enqueueScripts() {

        $settingJQuery = ( new SettingJQuery() )->getOption();
        switch ( $settingJQuery ) {
            case 'latest-cdn':
                wp_deregister_script( 'jquery' );
                wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', [], '3.4.1' );
                break;
            case 'latest-local':
                wp_deregister_script( 'jquery' );
                wp_register_script( 'jquery', Elebee_URL . '/Public/assets/js/jquery.min.js', [], '3.4.1' );
                wp_enqueue_script( 'jquery-migrate-301', Elebee_URL . '/Public/assets/js/jquery-migrate-301.min.js', [ 'jquery' ], '3.0.1' );
                break;
        }

        $settingJQueryNoMigrate = ( new SettingJQueryNoMigrate() )->getOption();
        if ( !empty( $settingJQueryNoMigrate ) ) {
            wp_deregister_script( 'jquery-migrate');
            wp_deregister_script( 'jquery-migrate-301');
        }

        if ( file_exists( Elebee_DIR . '/js/vendor.min.js' ) ) {
            wp_enqueue_script( $this->themeName . '-elebee-vendor', Elebee_URL . '/js/vendor.min.js', [ 'jquery' ], $this->version, true );
        }

        // Comment this in if we add some js to the theme
        //wp_enqueue_script( $this->themeName . '-elebee-main', Elebee_URL . '/js/main.min.js', [ 'jquery' ], $this->version, true );

        wp_add_inline_script( 'jquery', 'let themeVars = ' . json_encode( [
                'websiteName' => get_bloginfo( 'name' ),
                'websiteUrl' => esc_url( get_site_url() ),
                'themeUrl' => esc_url( Elebee_URL ),
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'isSearch' => number_format( is_search() ),
                'isMobile' => number_format( wp_is_mobile() ),
                'debug' => number_format( WP_DEBUG ),
                'live' => '<!-- heartbeat alive -->',
            ] ) . ';', 'after' );

        if ( WP_DEBUG ) {
            wp_enqueue_script( 'livereload', '//localhost:35729/livereload.js' );
        }

    }


    public function embedGoogleAnalytics() {
        $trackingId = ( new SettingTrackingId() )->getOption();

        if ( empty( $trackingId ) ) {
            return;
        }

        $googleAnalyticsTemplate = new Template( __DIR__ . '/partials/google-analytics.php', [
            'gaTrackingId' => $trackingId,
            'anonymizeIp' => ( new SettingAnonymizeIp() )->getOption() ? 'true' : 'false',
        ] );
        $googleAnalyticsTemplate->render();

    }

    public function embedIEConditionals() {
        $ieConditionals = new Template( __DIR__ . '/partials/ie-conditionals.php' );
        $ieConditionals->render();
    }

}
