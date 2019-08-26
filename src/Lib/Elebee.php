<?php
/**
 * Elebee.php
 *
 * @since   0.1.0
 *
 * @package ElebeeCore\Lib
 * @author  RTO GmbH <info@rto.de>
 * @licence GPL-3.0
 * @link    https://rto-websites.github.io/elebee-core-api/master/ElebeeCore/Lib/Elebee.html
 */

namespace ElebeeCore\Lib;


use ElebeeCore\Admin\ElebeeAdmin;
use ElebeeCore\Admin\Setting\Google\Analytics\SettingAnonymizeIp;
use ElebeeCore\Admin\Setting\Google\Analytics\SettingTrackingId;
use ElebeeCore\Elementor\ElebeeElementor;
use ElebeeCore\Lib\CustomPostType\CustomCss\CustomCss;
use ElebeeCore\Lib\PostTypeSupport\PostTypeSupportExcerpt;
use ElebeeCore\Lib\ThemeCustomizer\Panel;
use ElebeeCore\Lib\ThemeCustomizer\Section;
use ElebeeCore\Lib\ThemeCustomizer\Setting;
use ElebeeCore\Lib\ThemeCustomizer\ThemeCustomizer;
use ElebeeCore\Lib\ThemeSupport\ThemeSupportCustomLogo;
use ElebeeCore\Lib\ThemeSupport\ThemeSupportFeaturedImage;
use ElebeeCore\Lib\ThemeSupport\ThemeSupportHTML5;
use ElebeeCore\Lib\ThemeSupport\ThemeSupportMenus;
use ElebeeCore\Lib\ThemeSupport\ThemeSupportSvg;
use ElebeeCore\Lib\ThemeSupport\ThemeSupportTitleTag;
use ElebeeCore\Lib\Util\AdminNotice\AdminNotice;
use ElebeeCore\Lib\Util\Config;
use ElebeeCore\Lib\Util\Template;
use ElebeeCore\Pub\ElebeePublic;
use Elementor\Settings;

\defined( 'ABSPATH' ) || exit;

/**
 * Class Elebee
 *
 * @since   0.1.0
 *
 * @package ElebeeCore\Lib
 * @author  RTO GmbH <info@rto.de>
 * @licence GPL-3.0
 * @link    https://rto-websites.github.io/elebee-core-api/master/ElebeeCore/Lib/Elebee.html
 */
class Elebee {
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the theme.
     *
     * @since 0.1.0
     * @var ElebeeLoader Maintains and registers all hooks for the theme.
     */
    private $loader;

    /**
     * The unique identifier of this theme.
     *
     * @since 0.1.0
     * @var string The string used to uniquely identify this theme.
     */
    private $themeName;

    /**
     * @since 0.2.0
     * @var ThemeCustomizer
     */
    private $themeCustomizer;

    /**
     * Define the core functionality of the theme.
     *
     * Set the theme name and the theme version that can be used throughout the theme.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    0.1.0
     */
    public function __construct() {

        $this->themeName = 'elebee';

        $this->loadDependencies();
        $this->setLocale();
        $this->setupThemeSupport();
        $this->setupThemeCustomizer();
        $this->defineAdminHooks();
        $this->definePublicHooks();
        if ( class_exists( 'Elementor\Settings' ) ) {
            $this->defineElementorHooks();
        }

    }

    /**
     * Load the required dependencies for this theme.
     *
     * Include the following files that make up the theme:
     *
     * - ElebeeLoader. Orchestrates the hooks of the theme.
     * - ElebeeI18n. Defines internationalization functionality.
     * - ElebeeAdmin. Defines all hooks for the admin area.
     * - ElebeePublic. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @return void
     * @since    0.1.0
     *
     */
    private function loadDependencies() {

        $this->loader = new ElebeeLoader();

    }

    /**
     * Define the locale for this theme for internationalization.
     *
     * Uses the ElebeeI18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @return void
     * @since 0.1.0
     *
     */
    private function setLocale() {

        $elebeeI18n = new ElebeeI18n();
        $elebeeI18n->setDomain( $this->getThemeName() );
        $elebeeI18n->loadThemeTEXTDOMAIN();

    }

    /**
     * @return void
     * @since 0.1.0
     *
     */
    private function setupThemeSupport() {

        $themeSupportMenus = new ThemeSupportMenus();
        $themeSupportMenus->getLoader()->run();

        $themeSupportTitleTag = new ThemeSupportTitleTag();
        $themeSupportTitleTag->getLoader()->run();

        $themeSupportHTML5 = new ThemeSupportHTML5();
        $themeSupportHTML5->getLoader()->run();

        $themeSupportFeaturedImage = new ThemeSupportFeaturedImage();
        $themeSupportFeaturedImage->getLoader()->run();

        $themeSupportCustomLogo = new ThemeSupportCustomLogo();
        $themeSupportCustomLogo->getLoader()->run();

        $themeSupportSvg = new ThemeSupportSvg();
        $themeSupportSvg->getLoader()->run();

    }

    /**
     * @return void
     * @since 0.2.0
     *
     */
    public function setupThemeCustomizer() {

        $this->themeCustomizer = new ThemeCustomizer();
        $this->setupThemeSettingsCoreData();
        $this->setupThemeSettingsGoogle();
        $this->themeCustomizer->register();

    }

    /**
     * @return void
     * @since 0.2.0
     *
     */
    public function setupThemeSettingsCoreData() {

        $settingCoreDataAddress = new Setting(
            'elebee_core_data_address',
            [
                'type' => 'option',
                'default' => '',
            ],
            [
                'label' => __( 'Address', 'elebee' ),
                'description' => '[coredata]address[/coredata]', 'elebee',
                'type' => 'textarea',
            ]
        );

        $settingCoreDataEmail = new Setting(
            'elebee_core_data_email',
            [
                'type' => 'option',
                'default' => '',
            ],
            [
                'label' => __( 'E-Mail address', 'elebee' ),
                'description' => '[coredata]email[/coredata]',
                'type' => 'text',
            ]
        );

        $settingCoreDataPhone = new Setting(
            'elebee_core_data_phone',
            [
                'type' => 'option',
                'default' => '',
            ],
            [
                'label' => __( 'Phone', 'elebee' ),
                'description' => '[coredata]phone[/coredata]',
                'type' => 'text',
            ]
        );

        $description = __( 'You can use the [coredata]key[/coredata] shortcode to display the core data field inside a post.', 'elebee' );
        $sectionCoreData = new Section( 'elebee_core_data_section', [
            'title' => __( 'Core data', 'elebee' ),
            'priority' => 700,
            'description' => $description,
        ] );
        $sectionCoreData->addSetting( $settingCoreDataAddress );
        $sectionCoreData->addSetting( $settingCoreDataEmail );
        $sectionCoreData->addSetting( $settingCoreDataPhone );

        $this->themeCustomizer->addSection( $sectionCoreData );

    }

    /**
     *
     */
    function setupThemeSettingsGoogle() {

        $settingGoogleAnalyticsTrackingId = new SettingTrackingId();
        $themeCustomizerSettingGoogleAnalyticsTrackingId = new Setting(
            $settingGoogleAnalyticsTrackingId->getName(),
            [
                'type' => 'option',
            ],
            [
                'label' => $settingGoogleAnalyticsTrackingId->getTitle(),
                'type' => 'text',
                'input_attrs' => [
                    'placeholder' => 'UA-XXXXX-X',
                ],
            ]
        );

        $settingGoogleAnalyticsAnonymizeIp = new SettingAnonymizeIp();
        $themeCustomizerSettingGoogleAnalyticsAnonymizeIp = new Setting(
            $settingGoogleAnalyticsAnonymizeIp->getName(),
            [
                'type' => 'option',
                'default' => $settingGoogleAnalyticsAnonymizeIp->getDefault(),
            ],
            [
                'label' => $settingGoogleAnalyticsAnonymizeIp->getTitle(),
                'type' => 'checkbox',
                'input_attrs' => [
                    'checked' => true,
                ],
            ]
        );

        $sectionGoogleAnalytics = new Section( 'elebee_google_analytics_section', [
            'title' => __( 'Analytics', 'elebee' ),
            'description' => __( 'After entering the tracking ID, the Google Analytics Script is automatically included.', 'elebee' ),
        ] );
        $sectionGoogleAnalytics->addSetting( $themeCustomizerSettingGoogleAnalyticsTrackingId );
        $sectionGoogleAnalytics->addSetting( $themeCustomizerSettingGoogleAnalyticsAnonymizeIp );

        $panelGoogle = new Panel( 'elebee_google_panel', [
            'priority' => 800,
            'title' => __( 'Google', 'elebee' ),
            'description' => '',
        ] );
        $panelGoogle->addSection( $sectionGoogleAnalytics );

        $this->themeCustomizer->addElement( $panelGoogle );

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the theme.
     *
     * @return void
     * @since 0.1.0
     *
     */
    private function defineAdminHooks() {

        global $wp_version;
        if ( version_compare( $wp_version, '5.0', '<' ) ) {
            $this->loader->addAction( 'tiny_mce_before_init', Config::class, 'switchTinymceEnterMode' );
            $this->loader->addFilter( 'tiny_mce_plugins', Config::class, 'disableTinymceEmojies' );
        }

        $elebeeAdmin = new ElebeeAdmin( $this->getThemeName(), $this->getVersion() );

        $this->loader->addAction( 'admin_init', $elebeeAdmin, 'settingsApiInit' );

        if ( class_exists( 'Elementor\Settings' ) ) {
            $this->loader->addAction( 'admin_menu', $elebeeAdmin, 'addMenuPage', Settings::MENU_PRIORITY_GO_PRO + 1 );
        } else {
            $this->loader->addAction( 'admin_notices', $elebeeAdmin, 'elementorNotExists' );
        }

        $this->loader->addAction( 'admin_enqueue_scripts', $elebeeAdmin, 'enqueueStyles', 100 );
        $this->loader->addAction( 'admin_enqueue_scripts', $elebeeAdmin, 'enqueueScripts' );

        $this->loader->addAction( 'wp_ajax_get_post_id_by_url', $elebeeAdmin, 'getPostIdByUrl' );

        $utilAdminNotice = new AdminNotice();
        $this->loader->addAction( 'admin_enqueue_scripts', $utilAdminNotice, 'enqueueScripts' );
        $this->loader->addAction( 'admin_enqueue_scripts', $utilAdminNotice, 'localizeScripts' );
        $this->loader->addAction( 'wp_ajax_dismiss_notice', $utilAdminNotice, 'dismissNotice' );

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the theme.
     *
     * @return void
     * @since 0.1.0
     *
     */
    private function definePublicHooks() {

        $this->loader->addAction( 'init', Config::class, 'cleanUpHead' );
        $this->loader->addAction( 'init', Config::class, 'disableEmojies' );
        $this->loader->addFilter( 'status_header', Config::class, 'disableRedirectGuess' );

        $elebeePublic = new ElebeePublic( $this->getThemeName(), $this->getVersion() );

        $this->loader->addAction( 'wp_head', $elebeePublic, 'embedGoogleAnalytics', 0 );
        $this->loader->addAction( 'wp_enqueue_styles', $elebeePublic, 'enqueueStyles' );
        $this->loader->addAction( 'wp_enqueue_scripts', $elebeePublic, 'enqueueScripts' );

    }

    /**
     * @return void
     * @since 0.3.2
     *
     */
    private function defineElementorHooks() {

    }

    /**
     * The name of the theme used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return string The name of the theme.
     * @since 0.1.0
     *
     */
    public function getThemeName() {

        return $this->themeName;
    }

    /**
     * The reference to the class that orchestrates the hooks with the theme.
     *
     * @return ElebeeLoader Orchestrates the hooks of the theme.
     * @since 0.1.0
     *
     */
    public function getLoader() {

        return $this->loader;

    }

    /**
     * Retrieve the version number of the theme.
     *
     * @return string The version number of the theme.
     * @since 0.1.0
     *
     */
    public function getVersion() {

        return Elebee_VERISON;

    }

    /**
     * @return void
     * @since 0.1.0
     *
     */
    public function phpVersionFail() {

        $message = esc_html__( 'The Elementor RTO plugin requires PHP version 7.0+, plugin is currently NOT ACTIVE.', 'elebee' );
        $errorTemplate = new Template( __DIR__ . '/partials/element-default.php', [
            'tag' => 'div',
            'attributes' => 'class="error"',
            'content' => wpautop( $message ),
        ] );
        $errorTemplate->render();

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @return void
     * @since 0.1.0
     *
     */
    public static function run() {

        $elebee = new self();

        if ( !version_compare( PHP_VERSION, '7.0', '>=' ) ) {

            $elebee->getLoader()->addAction( 'admin_notices', $elebee, 'phpVersionFail' );

        }

        $elebee->getLoader()->run();

    }

}