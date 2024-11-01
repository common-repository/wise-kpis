<?php

if ( ! class_exists( 'Codekamino_Kpis_Kpi_Box_Builder' ) ) :
	class Codekamino_Kpis_Kpi_Box_Builder {
		private $kpi_name;
		private $current_value;
		private $previous_value;
		private $change_percentage;
		private $description;
		/**
		 * @var mixed
		 */
		private $compare_unit;

		public function __construct( string $kpi_name, string $description, float $current_value, float $previous_value, float $change_percentage, $compare_unit ) {
			$this->kpi_name          = apply_filters( 'wise_kpis_builder_kpi_name', $kpi_name );
			$this->description       = apply_filters( 'wise_kpis_builder_description', $description );
			$this->current_value     = apply_filters( 'wise_kpis_builder_current_value', $current_value );
			$this->change_percentage = apply_filters( 'wise_kpis_builder_change_percentage', $change_percentage );
			$this->previous_value    = apply_filters( 'wise_kpis_builder_previous_value', $previous_value );
			$this->compare_unit      = apply_filters( 'wise_kpis_builder_compare_unit', $compare_unit );
		}


		public function build() {
			do_action( 'wise_kpis_before_build', $this );
			$selected_design_converter = new Codekamino_Kpis_Design_Block_Converter_Processor( get_option( 'woowise-kpis-block-design' ) );
			$class_name                = $selected_design_converter->process();

			$built_block = $class_name::get_designed_block( $this->kpi_name, $this->description, $this->current_value, $this->previous_value, $this->change_percentage, $this->compare_unit );
			$built_block = apply_filters( 'wise_kpis_built_block', $built_block, $this );

			return $built_block;
		}
	}
endif;
