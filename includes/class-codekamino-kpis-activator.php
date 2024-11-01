<?php

/**
 * Fired during plugin activation
 *
 * @link       https://codekamino.com
 * @since      1.0.0
 *
 * @package    Wise_Kpis
 * @subpackage Wise_Kpis/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wise_Kpis
 * @subpackage Wise_Kpis/includes
 * @author     CodeKamino <info@codekamino.com>
 */
if ( ! class_exists( 'Codekamino_Kpis_Activator' ) ) :
	class Codekamino_Kpis_Activator {

		/**
		 * Short Description. (use period)
		 *
		 * Long Description.
		 *
		 * @since    1.0.0
		 */
		public static function activate() {
			add_option( 'woowise-kpis-block-design', 'simple-clean' );
		}
	}
endif;
