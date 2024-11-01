<?php
/**
 * Class Codekamino_Kpis_Average_Comments_Per_Post_Block.
 *
 * Implements Codekamino_Kpis_Kpi_Block_Interface to calculate the average comments per post.
 */
if ( ! class_exists( 'Codekamino_Kpis_Average_Comments_Per_Post_Block' ) ) :
	class Codekamino_Kpis_Average_Comments_Per_Post_Block implements Codekamino_Kpis_Kpi_Block_Interface {

		/**
		 * The WordPress database object.
		 *
		 * @var wpdb The WordPress database object.
		 */
		private $wpdb;

		/**
		 * Constructs a new Codekamino_Kpis_Average_Comments_Per_Post_Block object.
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
			return __( 'Average Comments Per Post', 'wise-kpis');
		}

		/**
		 * Gets the description of the block.
		 *
		 * @return string The description of the block.
		 */
		public function get_description(): string {
			return __( 'How many comments a post gets on average all over the site.', 'wise-kpis');
		}

		/**
		 * Gets the current value of the block.
		 *
		 * @param object $query_timeframe The query timeframe object.
		 *
		 * @return float The current value of the block.
		 */
		public function get_current_value( string $start_date, string $end_date ): float {
			$total_comments = $this->wpdb->get_var( "
				SELECT COUNT(*)
				FROM {$this->wpdb->prefix}comments
				WHERE comment_type = 'comment'
					AND comment_type <> 'WooCommerce'
					AND comment_approved = 1
					AND DATE(comment_date) >= $start_date
					AND DATE(comment_date) <= $end_date
			" );

			$total_posts = $this->wpdb->get_var( "
				SELECT COUNT(*)
				FROM {$this->wpdb->prefix}posts
				WHERE post_type = 'post'
					AND post_status = 'publish'
					AND DATE(post_date) >= $start_date
					AND DATE(post_date) <= $end_date
			" );

			if ( $total_posts > 0 ) {
				return round( $total_comments / $total_posts, 2 );
			}

			return 0;
		}

		/**
		 * Gets the percentage change between the current and compared values of the block.
		 *
		 * @return float The percentage change between the current and compared values of the block.
		 */
		public function get_change_percentage( float $currentValue, float $previousValue ): float {
			return ( new Codekamino_Kpis_Calculate_Kpi_Change( $currentValue, $previousValue ) )->calculate();
		}
	}
endif;
