<?php
/**
 * Class Codekamino_Kpis_Total_Number_Of_Orders_Per_Day_Block
 *
 * This class calculates the total number of shop orders per day.
 */

if ( ! class_exists( 'Codekamino_Kpis_Total_Number_Of_Orders_Per_Day_Block' ) ) :
	class Codekamino_Kpis_Total_Number_Of_Orders_Per_Day_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The WordPress database object.
		 *
		 * @var wpdb
		 */
		private $wpdb;

		/**
		 * Codekamino_Kpis_Total_Number_Of_Orders_Per_Day_Block constructor.
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
			return __( 'Total Number Of Orders', 'wise-kpis');
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'The total number of shop orders.', 'wise-kpis');
		}

		/**
		 * Get the current value of the KPI.
		 *
		 * @param object $query_timeframe The query timeframe object.
		 *
		 * @return float The current value of the KPI.
		 */
		public function get_current_value( string $start_date, string $end_date ): float {
			$query = $this->wpdb->prepare( "
				SELECT COUNT(*)
				FROM {$this->wpdb->prefix}posts
				WHERE post_type = 'shop_order'
				AND DATE(post_date) >= %s
				AND DATE(post_date) <= %s
				AND post_status <> 'auto-draft'
			", $start_date, $end_date );

			return $this->wpdb->get_var( $query ) ?: 0;
		}

		/**
		 * Get the percentage change in the KPI value between the current day and the previous day.
		 *
		 * @return float The percentage change in the KPI value.
		 */
		public function get_change_percentage( float $currentValue, float $previousValue ): float {
			return ( new Codekamino_Kpis_Calculate_Kpi_Change( $currentValue, $previousValue ) )->calculate();
		}
	}
endif;
