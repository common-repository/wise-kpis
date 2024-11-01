<?php

/**
 * Class Codekamino_Kpis_Average_Comments_Per_User_Block.
 *
 * Implements Codekamino_Kpis_Kpi_Block_Interface to calculate the average comments per user.
 */
if ( ! class_exists( 'Codekamino_Kpis_Average_Comments_Per_User_Block' ) ) :
	class Codekamino_Kpis_Average_Comments_Per_User_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The WordPress database object.
		 *
		 * @var wpdb The WordPress database object.
		 */
		private $wpdb;

		/**
		 * Constructs a new Codekamino_Kpis_Average_Comments_Per_User_Block object.
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
			return __( 'Average Comments per User', 'wise-kpis');
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'The average number of comments per user across all post types.', 'wise-kpis');
		}

		/**
		 * Gets the current value of the block.
		 *
		 * @param object $query_timeframe The query timeframe object.
		 *
		 * @return float The current value of the block.
		 */
		public function get_current_value(string $start_date,string $end_date ): float {
			$query = $this->wpdb->prepare(
				"
				SELECT COUNT(c.comment_ID) / COUNT(DISTINCT c.user_id) as average_comments_per_user
				FROM {$this->wpdb->prefix}comments c
				INNER JOIN {$this->wpdb->prefix}posts p ON c.comment_post_ID = p.ID
				WHERE p.post_status = 'publish'
					AND p.post_type = 'post'
					AND c.comment_approved = 1
					AND c.comment_date >= %s
					AND c.comment_date <= %s
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
