<?php

if ( ! class_exists( 'Codekamino_Kpis_Kpi_Blocks' ) ) :
	class Codekamino_Kpis_Kpi_Blocks {
		private $iterator;

		public function __construct( Codekamino_Kpis_Blocks_Iterator $iterator ) {
			$this->iterator = $iterator;
		}

		public function render( string $query_timeframe ) {
			$blocks = $this->iterator->get_blocks();
			foreach ( $blocks as $block ) {
				do_action( 'wise_kpis_before_block_render', $block );
				$name        = $block->get_name();
				$description = $block->get_description();
				$timeframe   = json_decode( $query_timeframe );

				$currentValue  = $block->get_current_value( $timeframe->start_date, $timeframe->end_date );
				$previousValue = $block->get_current_value( $timeframe->compare_start, $timeframe->compare_end );

				// Create a new KPIBlock object
				$kpiBlock = new Codekamino_Kpis_Kpi_Block_Model( $name, $description, $currentValue, $previousValue );

				$timeframe_object = json_decode( $query_timeframe );
				// Use the KPIBoxBuilder class to generate the HTML for the block
				$kpiBuilder = new Codekamino_Kpis_Kpi_Box_Builder( $name, $description, $currentValue, $previousValue, $kpiBlock->getChangePercentage(), $timeframe_object->unit );
				$box        = $kpiBuilder->build();
				do_action( 'wise_kpis_after_block_render', $block );
				echo wp_kses_post( $box );
			}
		}
	}
endif;
