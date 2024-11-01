<?php

/**
 * Class Codekamino_Kpis_Number_Of_Nav_Menu_Items_Block.
 *
 * Implements Codekamino_Kpis_Kpi_Block_Interface to calculate the number of navigation menu items.
 */
if ( ! class_exists( 'Codekamino_Kpis_Number_Of_Nav_Menu_Items_Block' ) ) :
	class Codekamino_Kpis_Number_Of_Nav_Menu_Items_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The WordPress database object.
		 *
		 * @var wpdb The WordPress database object.
		 */
		private $wpdb;

		/**
		 * Constructs a new Codekamino_Kpis_Number_Of_Nav_Menu_Items_Block object.
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
			return __( 'Number of Nav Menu Items', 'wise-kpis');
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'The total number of navigation menu items on the site.', 'wise-kpis');
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
        FROM {$this->wpdb->prefix}posts p
        WHERE p.post_type = 'nav_menu_item'
            AND p.post_date >= %s
            AND p.post_date <= %s
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
