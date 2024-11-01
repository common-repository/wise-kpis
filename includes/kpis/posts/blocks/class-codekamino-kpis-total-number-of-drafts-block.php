<?php

/**
 * Class Codekamino_Kpis_Total_Number_Of_Drafts_Block.
 *
 * Implements Codekamino_Kpis_Kpi_Block_Interface to calculate the total number of drafts.
 */
if ( ! class_exists( 'Codekamino_Kpis_Total_Number_Of_Drafts_Block' ) ) :
	class Codekamino_Kpis_Total_Number_Of_Drafts_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The WordPress database object.
		 *
		 * @var wpdb The WordPress database object.
		 */
		private $wpdb;

		/**
		 * Constructs a new Codekamino_Kpis_Total_Number_Of_Drafts_Block object.
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
			return __( 'Total Number of Drafts', 'wise-kpis');
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'The total number of drafts across all post types.', 'wise-kpis');
		}

		/**
		 * Gets the current value of the block.
		 *
		 * @param object $query_timeframe The query timeframe object.
		 *
		 * @return float The current value of the block.
		 */
		public function get_current_value( string $start_date, string $end_date ): float {

			$query = $this->wpdb->prepare(
				"
				SELECT COUNT(*)
				FROM {$this->wpdb->prefix}posts
				WHERE post_status = 'draft'
					AND post_date >= %s
					AND post_date <= %s
			",
				$start_date,
				$end_date
			);

			return (float) $this->wpdb->get_var( $query ) ?: 0;
		}

		/**
		 * Gets the compared value of the block.
		 *
		 * @param object $query_timeframe The query timeframe object.
		 *
		 * @return float The compared value of the block.
		 */
		public function get_compared_value( object $query_timeframe ): float {
			$compare_start_date = $query_timeframe->compare_start;
			$compare_end_date   = $query_timeframe->compare_end;

			$query = $this->wpdb->prepare(
				"
				SELECT COUNT(*)
				FROM {$this->wpdb->prefix}posts
				WHERE post_status = 'draft'
					AND post_date >= %s
					AND post_date <= %s
			",
				$compare_start_date,
				$compare_end_date
			);

			return (float) $this->wpdb->get_var( $query ) ?: 0;
		}

		/**
		 * Gets the percentage change between the current and compared values of the block.
		 *
		 * @param float $currentValue The current value of the block.
		 * @param float $previousValue The compared value of the block.
		 *
		 * @return float The percentage change between the current and compared values of the block.
		 */
		public function get_change_percentage( float $currentValue, float $previousValue ): float {
			return ( new Codekamino_Kpis_Calculate_Kpi_Change( $currentValue, $previousValue ) )->calculate();
		}
	}
endif;
