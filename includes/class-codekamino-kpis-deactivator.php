<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://codekamino.com
 * @since      1.0.0
 *
 * @package    Wise_Kpis
 * @subpackage Wise_Kpis/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wise_Kpis
 * @subpackage Wise_Kpis/includes
 * @author     CodeKamino <info@codekamino.com>
 */

if ( ! class_exists( 'Codekamino_Kpis_Deactivator' ) ) :
	class Codekamino_Kpis_Deactivator {
		public static function deactivate() {
		}
	}
endif;
