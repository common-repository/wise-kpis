<?php

/**
 * Woowise KPIs Number of Spam Comments Block.
 *
 * Calculates the total number of spam comments.
 *
 * @package Codekamino_Kpis
 */

if ( class_exists( 'Codekamino_Kpis_Number_Of_Spam_Comments_Block' ) ) :
	class Codekamino_Kpis_Number_Of_Spam_Comments_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The WordPress database object.
		 *
		 * @var wpdb The WordPress database object.
		 */
		private $wpdb;

		/**
		 * Constructs a new Codekamino_Kpis_Number_Of_Spam_Comments_Block object.
		 *
		 * @param wpdb $wpdb The WordPress database object.
		 */
		public function __construct( wpdb $wpdb ) {
			$this->wpdb = $wpdb;
		}

		/**
		 * Gets the name of the block.
		 *
		 * @return string The name of the block.
		 */
		public function get_name(): string {
			return __( 'Total Number Of Spam Comments', 'wise-kpis');
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'Total amount of spam comments.', 'wise-kpis');
		}

		/**
		 * Gets the current value of the block.
		 *
		 * @return float The current value of the block.
		 */
		public function get_current_value( string $start_date, string $end_date ): float {
			$query = $this->wpdb->prepare(
				"
            SELECT COUNT(*)
            FROM {$this->wpdb->prefix}comments
            WHERE comment_type = 'comment'
                AND comment_approved = 'spam'
                AND comment_date >= %s
                AND comment_date <= %s
            ",
				$start_date,
				$end_date
			);

			return (float) $this->wpdb->get_var( $query ) ?: 0;
		}

		/**
		 * Gets the percentage change between the current and previous day values of the block.
		 *
		 * @return float The percentage change between the current and previous day values of the block.
		 */
		public function get_change_percentage( float $currentValue, float $previousValue ): float {
			return ( new Codekamino_Kpis_Calculate_Kpi_Change( $currentValue, $previousValue ) )->calculate();
		}
	}
endif;
