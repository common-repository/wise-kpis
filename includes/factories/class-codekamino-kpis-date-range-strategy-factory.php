<?php

/**
 * A factory class to create new menu items when activating the plugin
 *
 * @since      1.0.0
 * @package    Wise_Kpis
 * @subpackage Wise_Kpis/includes
 * @author     CodeKamino <info@codekamino.com>
 */

if ( ! class_exists( 'Codekamino_Kpis_Date_Range_Strategy_Factory' ) ) {
	class Codekamino_Kpis_Date_Range_Strategy_Factory {
		public static function createStrategy( string $time_unit ): ?Codekamino_Kpis_Date_Range_Strategy_Interface {
			$class_name_to_build = ucfirst( $time_unit );
			$class_name_to_build = ucwords( str_replace( '-', ' ', $class_name_to_build ) );
			$strategy_class      = 'Codekamino_Kpis_' . str_replace( ' ', '_', $class_name_to_build ) . '_Strategy';

			if ( class_exists( $strategy_class ) ) {
				return new $strategy_class();
			}

			return null;
		}
	}
}
