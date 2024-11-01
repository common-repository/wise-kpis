<?php

if ( ! class_exists( 'Codekamino_Kpis_News_Dashboard' ) ) :

	class Codekamino_Kpis_News_Dashboard {

		public function __construct() {
			add_action( 'wp_dashboard_setup', [ $this, 'codekamino_news_dashboard' ] );
		}

		public function codekamino_news_dashboard() {
			wp_add_dashboard_widget(
				'codekamino_news_dashboard',
				'Code Kamino News & Updates',
				[ $this, 'codekamino_news_get' ]
			);
			global $wp_meta_boxes;
			$normal_dashboard                 = $wp_meta_boxes['dashboard']['normal']['core'];
			$codekamino_news_dashboard_backup = array( 'codekamino_news_dashboard' => $normal_dashboard['codekamino_news_dashboard'] );
			unset( $normal_dashboard['codekamino_news_dashboard'] );
			$sorted_dashboard                             = array_merge( $codekamino_news_dashboard_backup, $normal_dashboard );
			$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
		}

		public function codekamino_news_get() {

			$curl = curl_init();

			curl_setopt_array( $curl, array(
				CURLOPT_URL            => 'https://codekamino.com//wp-json/codekamino/v1/news',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING       => '',
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST  => 'GET',
			) );

			$response = curl_exec( $curl );

			curl_close( $curl );
			$news = json_decode( $response );
			ob_start();

			if ( ! empty( $news ) ):
				foreach ( $news as $post ) {
					?>
					<div style="margin-bottom: 20px;">
						<h3>
							<?php
							echo esc_html( $post->title ); ?> -
							<span style="color: <?php echo ( $post->type == 'critical' ) ? 'red' : 'black'; ?>">
                <?php echo esc_html( $post->type ); ?>
            </span>
						</h3>
						<p><?php echo esc_html( $post->content ); ?></p>
						<?php if ( $post->url ): ?>
							<p><a style="padding:5px" href="<?php echo esc_url( $post->url ); ?>" target="_blank">Watch
									it now</a></p>
						<?php endif; ?>
					</div>
					<?php
				}

				$output = ob_get_clean();
				echo $output;
			endif;
		}

	}

	new Codekamino_Kpis_News_Dashboard();
endif;