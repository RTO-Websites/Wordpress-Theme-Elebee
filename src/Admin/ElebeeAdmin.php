<?php

/**
 * The admin-specific functionality of the theme.
 *
 * @since   0.1.0
 *
 * @package ElebeeCore\Admin
 * @author  RTO GmbH <info@rto.de>
 * @licence GPL-3.0
 * @link    https://rto-websites.github.io/elebee-core-api/master/ElebeeCore/Admin/ElebeeAdmin.html
 */

namespace ElebeeCore\Admin;


use ElebeeCore\Admin\Setting\Google\Analytics\SettingAnonymizeIp;
use ElebeeCore\Admin\Setting\Google\Analytics\SettingTrackingId;
use ElebeeCore\Admin\Setting\SettingJQuery;
use ElebeeCore\Admin\Setting\SettingJQueryNoMigrate;
use ElebeeCore\Admin\Setting\SettingNoThemeCss;
use ElebeeCore\Admin\Setting\SettingIsExclusive;
use ElebeeCore\Lib\Util\AdminNotice\AdminNotice;
use ElebeeCore\Lib\Util\Template;
use Elementor\Settings;

\defined( 'ABSPATH' ) || exit;

/**
 * The admin-specific functionality of the theme.
 *
 * Defines the theme name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since   0.1.0
 *
 * @package ElebeeCore\Admin
 * @author  RTO GmbH <info@rto.de>
 * @licence GPL-3.0
 * @link    https://rto-websites.github.io/elebee-core-api/master/ElebeeCore/Admin/ElebeeAdmin.html
 */
class ElebeeAdmin {

    /**
     * The ID of this theme.
     *
     * @since 0.1.0
     * @var   string $themeName The ID of this theme.
     */
    private $themeName;

    /**
     * @since 0.3.1
     * @var string
     */
    private $cssDirUrl;

    /**
     * @since 0.3.1
     * @var string
     */
    private $jsDirUrl;

    /**
     * The version of this theme.
     *
     * @since 0.1.0
     * @var   string $version The current version of this theme.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 0.1.0
     *
     * @param string $themeName The name of this theme.
     * @param string $version   The version of this theme.
     */
    public function __construct( $themeName, $version ) {

        $this->themeName = $themeName;
        $this->version = $version;

        $assetsUrl = untrailingslashit( Elebee_URL ) . '/Admin/assets';
        $this->cssDirUrl = $assetsUrl . '/css';
        $this->jsDirUrl = $assetsUrl . '/js';

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since  0.1.0
     *
     * @return void
     */
    public function enqueueStyles() {

        wp_enqueue_style( $this->themeName, Elebee_URL . '/css/admin.min.css', [], $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function enqueueScripts() {

        wp_enqueue_script( $this->themeName . '-admin', $this->jsDirUrl . '/admin.js', [ 'jquery' ], $this->version, false );
        wp_localize_script( $this->themeName . '-admin', 'l10n', [
            'noticeGoogleTrackingIdInvalid' => __( 'Goolge Tracking ID format is invalid.', 'elebee' )
        ] );

    }

    /**
     * @since 0.1.0
     *
     * @return void
     */
    public function getPostIdByUrl() {

        $url = filter_input( INPUT_POST, 'url' );
        $postId = url_to_postid( $url );
        wp_send_json(
            [
                'postId' => $postId,
                'path' => get_site_url(),
            ]
        );
        die();

    }

    /**
     * @since 0.1.0
     *
     * @return void
     */
    public function settingsApiInit() {

        $settingIsExclusive = new SettingIsExclusive();
        $settingIsExclusive->register( 'elebee_settings' );
        $settingJQuery = new SettingJQuery();
        $settingJQuery->register( 'elebee_settings' );
        $settingJQueryNoMigrate = new SettingJQueryNoMigrate();
        $settingJQueryNoMigrate->register( 'elebee_settings' );
        $settingNoThemeCss = new SettingNoThemeCss();
        $settingNoThemeCss->register( 'elebee_settings' );

        $settingGoogleAnalyticsTrackingId = new SettingTrackingId();
        $settingGoogleAnalyticsTrackingId->register( 'elebee_settings', 'default', [
            'placeholder' => 'UA-XXXXX-X',
        ] );

        $settingGoogleAnonymizeIp = new SettingAnonymizeIp();
        $settingGoogleAnonymizeIp->register( 'elebee_settings' );

    }

    /**
     * @since 0.1.0
     *
     * @return void
     */
    public function addMenuPage() {

        add_submenu_page(
            Settings::PAGE_ID,
            __( 'Elebee Settings', 'elebee' ),
            __( 'Elebee Settings', 'elebee' ),
            'manage_options',
            'elebee_settings',
            [ $this, 'renderAdminPage' ]
        );

    }

    /**
     * Show error message if Elementor not installed/active.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function elementorNotExists() {

        if ( !class_exists( 'ElebeeCore\Lib\Util\AdminNotice\AdminNotice') ) {
            return;
        }

        ( new AdminNotice() )->getNotice(
            'elebee-missing-elementor',
            __( 'The theme Eleebee works best with Elementor. Please install or activate Elementor-Plugin.')
        );

    }

    /**
     * @since 0.1.0
     *
     * @return void
     */
    public function renderAdminPage() {
        ( new Template( dirname( __DIR__ ) . '/Admin/partials/settings.php' ) )->render();
    }

}
