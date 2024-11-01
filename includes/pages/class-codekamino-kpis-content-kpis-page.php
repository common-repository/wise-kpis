<?php

if ( ! class_exists( 'Codekamino_Kpis_Content_Kpis_Page' ) ) :
	class Codekamino_Kpis_Content_Kpis_Page {
		public static function render() {
			global $wpdb;
			$start_date = isset( $_POST['start-date'] ) ? sanitize_text_field( $_POST['start-date'] ) . ' 00:00:00' : '';
			$end_date   = isset( $_POST['end-date'] ) ? sanitize_text_field( $_POST['end-date'] ) . ' ' . date( 'H:i:s' ) : '';
			$unit_type  = isset( $_POST['unit-type'] ) ? sanitize_text_field( $_POST['unit-type'] ) : 'yesterday'; // Default unit type

			$frameObject         = (object) [
				'start_date' => $start_date,
				'end_date'   => $end_date,
				'unit_type'  => $unit_type
			];
			$query_timeframe     = new Codekamino_Kpis_Timeframe_Model( $frameObject );
			$timeframe_processor = new Codekamino_Kpis_Date_Calculator_Processor( $query_timeframe );
			$query_timeframe     = $timeframe_processor->process();
			$kpi_blocks_iterator = new Codekamino_Kpis_Blocks_Iterator( $wpdb, 'kpis/content/blocks', $query_timeframe );
			$kpi_blocks          = new Codekamino_Kpis_Kpi_Blocks( $kpi_blocks_iterator );
			?>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<div class="wrap">
				<?php if ( ! isset( $_GET['auto_refresh'] ) ) : ?>
					<button onclick="activateAutoRefresh()"
							class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
						<?php _e( 'Activate Auto Refresh', 'wise-kpis' ); ?>
					</button>
				<?php endif; ?>
				<h1 class="text-3xl font-bold mb-8"><?php _e( 'Engagement KPIs', 'wise-kpis' ); ?></h1>
				<!-- Date Range and Unit Type Selection Form -->
				<?php if ( ! isset( $_GET['auto_refresh'] ) ) : ?>
					<form method="POST">
						<div class="mb-4 flex flex-col sm:flex-row sm:items-center">
							<label for="start-date" class="mr-2"><?php _e( 'Start Date:', 'wise-kpis' ); ?></label>
							<input type="date" id="start-date" name="start-date"
								   value="<?= $start_date ? esc_attr( date( 'Y-m-d', strtotime( $start_date ) ) ) : date( 'Y-m-d' ); ?>"
								   class="p-2 rounded-md mb-2 sm:mb-0 sm:mr-4">

							<label for="end-date" class="mr-2"><?php _e( 'End Date:', 'wise-kpis' ); ?></label>
							<input type="date" id="end-date" name="end-date"
								   value="<?= $end_date ? esc_attr( date( 'Y-m-d', strtotime( $end_date ) ) ) : date( 'Y-m-d' ); ?>"
								   class="p-2 rounded-md mb-2 sm:mb-0 sm:mr-4">

							<label for="unit-type"
								   class="mr-2"><?php _e( 'Compared Unit:', 'wise-kpis' ); ?></label>
							<select id="unit-type" name="unit-type" class="p-2 rounded-md">
								<option value="yesterday"><?php _e( 'Yesterday', 'wise-kpis' ); ?></option>
								<option value="last-week"><?php _e( 'Last Week', 'wise-kpis' ); ?></option>
								<option value="last-month"><?php _e( 'Last Month', 'wise-kpis' ); ?></option>
								<option value="last-year"><?php _e( 'Last Year', 'wise-kpis' ); ?></option>
							</select>

							<button type="submit" name="submit"
									class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><?php _e( 'Submit', 'wise-kpis' ); ?>
							</button>
						</div>
						<div class="mb-4 text-xl">
							<?php
							if ( empty( $frameObject->start_date ) ) {
								?>
								<span class="text-gray-600"><?php _e( 'Selected Date', 'wise-kpis' ); ?> <b>Today</b></span>
								<span class="text-gray-600"><?php _e( 'Compared Unit:', 'wise-kpis' ); ?></span>
								<span class="font-bold"><?= esc_html( ucfirst( str_replace( '-', ' ', $frameObject->unit_type ) ) ); ?></span>
								<?php
							} else {
								?>
								<span class="text-gray-600"><?php _e( 'Selected Date Range:', 'wise-kpis' ); ?></span>
								<span class="font-bold"><b><?= esc_html( date_i18n( get_option( 'date_format' ), strtotime( $frameObject->start_date ) ) ); ?></b></span>
								<span class="text-gray-600"><?php _e( 'to', 'wise-kpis' ); ?></span>
								<span class="font-bold"><b><?= esc_html( date_i18n( get_option( 'date_format' ), strtotime( $frameObject->end_date ) ) ); ?></b></span>
								<span class="text-gray-600"><?php _e( 'Compared Unit:', 'wise-kpis' ); ?></span>
								<span class="font-bold"><b><?= esc_html( ucfirst( str_replace( '-', ' ', $frameObject->unit_type ) ) ); ?></b></span>
								<?php
							}
							?>
						</div>
					</form>
				<?php endif; ?>
				<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
					<?php $kpi_blocks->render( $query_timeframe ); ?>
				</div>
			</div>
			<script>
					function activateAutoRefresh() {
						window.location.href = '<?php echo add_query_arg( 'auto_refresh', 'true' ); ?>';
					}

			   <?php if (isset( $_GET['auto_refresh'] )) : ?>
					// Auto Refresh
					setInterval(function () {
						location.reload();
					}, 300000); // 5 minutes in milliseconds
			   <?php endif; ?>
			</script>
			<?php
		}
	}
endif;
