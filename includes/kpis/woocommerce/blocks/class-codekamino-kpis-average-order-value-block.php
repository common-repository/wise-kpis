<?php

/**
 * Calculates the Average Order Value (AOV) per day.
 */
if ( ! class_exists( 'Codekamino_Kpis_Average_Order_Value_Block' ) ) :
	class Codekamino_Kpis_Average_Order_Value_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The WordPress database object.
		 *
		 * @var wpdb
		 */
		private $wpdb;

		/**
		 * Constructor.
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
			return __( 'Average Order Value in', 'wise-kpis' );
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'The average value of completed orders per day', 'wise-kpis' ) . ' ' . get_woocommerce_currency_symbol();
		}

		/**
		 * Returns the current value of the KPI block.
		 *
		 * @param object $query_timeframe The query timeframe object.
		 *
		 * @return float The current value of the KPI block.
		 */
		public function get_current_value( string $start_date, string $end_date ): float {
			$query = $this->wpdb->prepare( "
		        SELECT AVG(total_sales)
		        FROM {$this->wpdb->prefix}wc_order_stats
		        WHERE status IN ('wc-completed', 'wc-processing')
		        AND DATE(date_created) >= %s
		        AND DATE(date_created) <= %s
		    ", $start_date, $end_date );

			$result = $this->wpdb->get_var( $query ) ?: 0;

			return round( $result, 2 );
		}


		/**
		 * Calculates the percentage change between the current and previous day's values.
		 *
		 * @param float $currentValue The current value of the KPI.
		 * @param float $previousValue The previous day's value of the KPI.
		 *
		 * @return float The percentage change between the current and previous day's values.
		 */
		public function get_change_percentage( float $currentValue, float $previousValue ): float {
			return ( new Codekamino_Kpis_Calculate_Kpi_Change( $currentValue, $previousValue ) )->calculate();
		}
	}
endif;
