<?php

/**
 * Class Codekamino_Kpis_Number_Of_Users_Per_Day_Kpi_Block
 *
 * A class that implements the Codekamino_Kpis_Kpi_Block_Interface and provides
 * the functionality to retrieve the number of new user registrations on the site per day.
 */
if ( ! class_exists( 'Codekamino_Kpis_Number_Of_Users_Per_Day_Kpi_Block' ) ) :
	class Codekamino_Kpis_Number_Of_Users_Per_Day_Kpi_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The WordPress database object.
		 *
		 * @var wpdb
		 */
		private $wpdb;

		/**
		 * Codekamino_Kpis_Number_Of_Users_Per_Day_Kpi_Block constructor.
		 *
		 * @param wpdb $wpdb The WordPress database object.
		 */
		public function __construct( $wpdb ) {
			$this->wpdb = $wpdb;
		}

		/**
		 * Gets the name of the block.
		 *
		 * @return string The name of the block.
		 */
		public function get_name(): string {
			return __( 'Number of Users Registrations', 'wise-kpis');
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'The total number of new user registrations on the site.', 'wise-kpis');
		}

		/**
		 * Get the current value of the KPI block.
		 *
		 * @param object $query_timeframe The query timeframe object.
		 *
		 * @return float The current value of the KPI block.
		 */
		public function get_current_value( string $start_date, string $end_date ): float {
			$query = $this->wpdb->prepare(
				"
			        SELECT CAST(COUNT(*) AS DECIMAL) AS count
			        FROM {$this->wpdb->prefix}users
			        WHERE user_registered >= %s
			        AND user_registered <= %s
				        ",
				$start_date,
				$end_date
			);

			return (float) $this->wpdb->get_var( $query ) ?: 0;
		}

		/**
		 * Get the percentage change between the current and compared values.
		 *
		 * @param float $currentValue The current value.
		 * @param float $previousValue The compared value.
		 *
		 * @return float The percentage change between the current and compared values.
		 */
		public function get_change_percentage( float $currentValue, float $previousValue ): float {
			return ( new Codekamino_Kpis_Calculate_Kpi_Change( $currentValue, $previousValue ) )->calculate();
		}
	}
endif;
