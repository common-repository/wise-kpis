<?php

/**
 * The `Codekamino_Kpis_Coupons_Usage_Per_Day_Block` class implements the `Codekamino_Kpis_Kpi_Block_Interface`
 * interface and represents a KPI block that displays the total number of coupons used per day.
 *
 * @package Codekamino_Kpis
 */
if ( ! class_exists( 'Codekamino_Kpis_Coupons_Usage_Per_Day_Block' ) ) :
	class Codekamino_Kpis_Coupons_Usage_Per_Day_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The instance of the WordPress database access abstraction class.
		 *
		 * @var wpdb
		 */
		private $wpdb;

		/**
		 * Constructs the KPI block object and sets the database object for data access.
		 *
		 * @param wpdb $wpdb The instance of the WordPress database access abstraction class.
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
			return __( 'Coupons Usage', 'wise-kpis');
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'The total number of coupons usage.', 'wise-kpis');
		}

		/**
		 * Returns the current value of the KPI block.
		 *
		 * @param object $query_timeframe The query timeframe object.
		 *
		 * @return float The current value of the KPI block.
		 */
		public function get_current_value( string $start_date, string $end_date ): float {
			$couponData = $this->wpdb->get_results( $this->wpdb->prepare( "
				SELECT COUNT(DISTINCT order_id) as count
				FROM {$this->wpdb->prefix}wc_order_product_lookup
				WHERE coupon_amount > 0 AND DATE(date_created) >= %s AND DATE(date_created) <= %s
			", $start_date, $end_date ) );

			if ( isset( $couponData[0]->count ) ) {
				return $couponData[0]->count;
			}

			return 0;
		}

		/**
		 * Returns the percentage change between the current value and the previous day's value.
		 *
		 * @param float $currentValue The current value of the KPI.
		 * @param float $previousValue The previous day's value of the KPI.
		 *
		 * @return float The percentage change between the current value and the previous day's value.
		 */
		public function get_change_percentage( float $currentValue, float $previousValue ): float {
			return ( new Codekamino_Kpis_Calculate_Kpi_Change( $currentValue, $previousValue ) )->calculate();
		}
	}
endif;
