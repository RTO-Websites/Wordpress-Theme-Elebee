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

class SettingJQueryNoMigrate extends SettingChoice {

    /**
     * JQuery-Migrate constructor.
     */
    public function __construct() {

        parent::__construct( 'jquery-no-migrate', __( 'Disable jQuery-Migrate', 'elebee' ), '0' );
        $this->addChoice( '0', __( 'off', 'elebee' ) );
        $this->addChoice( '1', __( 'on', 'elebee' ) );

    }

}