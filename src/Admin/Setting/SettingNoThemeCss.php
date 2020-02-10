<?php
/**
 * JQuery.php
 *
 * @author  RTO GmbH <info@rto.de>
 * @licence GPL-3.0
 */

namespace ElebeeCore\Admin\Setting;


use ElebeeCore\Admin\Setting\Lib\SettingChoice;

\defined( 'ABSPATH' ) || exit;

class SettingNoThemeCss extends SettingChoice {

    /**
     * JQuery-Migrate constructor.
     */
    public function __construct() {

        parent::__construct( 'no-theme-css', __( 'Disable Theme-Css', 'elebee' ), '0' );
        $this->addChoice( '0', __( 'off', 'elebee' ) );
        $this->addChoice( '1', __( 'on', 'elebee' ) );

    }

}