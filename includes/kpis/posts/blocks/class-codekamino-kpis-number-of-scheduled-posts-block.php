<?php

/**
 * Class Codekamino_Kpis_Number_Of_Scheduled_Posts_Block.
 *
 * Implements Codekamino_Kpis_Kpi_Block_Interface to calculate the number of scheduled posts.
 */
if ( ! class_exists( 'Codekamino_Kpis_Number_Of_Scheduled_Posts_Block' ) ) :
	class Codekamino_Kpis_Number_Of_Scheduled_Posts_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The WordPress database object.
		 *
		 * @var wpdb The WordPress database object.
		 */
		private $wpdb;

		/**
		 * Constructs a new Codekamino_Kpis_Number_Of_Scheduled_Posts_Block object.
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
			return __( 'Number of Scheduled Posts', 'wise-kpis');
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'For this KPI you should select future dates only.', 'wise-kpis');
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
                FROM {$this->wpdb->prefix}posts
                WHERE post_status = 'future'
                    AND post_date >= %s
                    AND post_date <= %s
            ",
				$start_date,
				$end_date
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
