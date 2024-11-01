<?php

/**
 * Calculates the Revenue Per Customer.
 */
if ( ! class_exists( 'Codekamino_Kpis_Revenue_Per_Customer_Block' ) ) :
	class Codekamino_Kpis_Revenue_Per_Customer_Block implements Codekamino_Kpis_Kpi_Block_Interface {

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
			return __( 'Revenue Per Customer', 'wise-kpis' );
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'The revenue generated per customer', 'wise-kpis' ) . ' ' . get_woocommerce_currency_symbol();
		}

		/**
		 * Returns the current value of the KPI block.
		 *
		 * @param object $query_timeframe The query timeframe object.
		 *
		 * @return float The current value of the KPI block.
		 */
		public function get_current_value( string $start_date, string $end_date ): float {
			$queryRevenue = $this->wpdb->prepare( "
				SELECT SUM(total_sales)
				FROM {$this->wpdb->prefix}wc_order_stats
				WHERE status IN ('wc-completed', 'wc-processing')
				AND DATE(date_created) >= %s
				AND DATE(date_created) <= %s
			", $start_date, $end_date );

			$totalRevenue = $this->wpdb->get_var( $queryRevenue ) ?: 0;

			$queryCustomers = $this->wpdb->prepare( "
				SELECT COUNT(DISTINCT(customer_id))
				FROM {$this->wpdb->prefix}wc_order_stats
				WHERE status IN ('wc-completed', 'wc-processing')
				AND DATE(date_created) >= %s
				AND DATE(date_created) <= %s
			", $start_date, $end_date );

			$totalCustomers = $this->wpdb->get_var( $queryCustomers ) ?: 0;

			return $totalCustomers > 0 ? round( $totalRevenue / $totalCustomers, 2 ) : 0;
		}

		/**
		 * Calculates the percentage change between the current and previous period's values.
		 *
		 * @param float $currentValue The current value of the KPI.
		 * @param float $previousValue The previous period's value of the KPI.
		 *
		 * @return float The percentage change between the current and previous period's values.
		 */
		public function get_change_percentage( float $currentValue, float $previousValue ): float {
			return ( new Codekamino_Kpis_Calculate_Kpi_Change( $currentValue, $previousValue ) )->calculate();
		}
	}
endif;
