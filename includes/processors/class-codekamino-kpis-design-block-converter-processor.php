<?php

if ( ! class_exists( 'Codekamino_Kpis_Design_Block_Converter_Processor' ) ) :
	class Codekamino_Kpis_Design_Block_Converter_Processor implements Codekamino_Kpis_Processor_interface {
		private $class_name;

		public function __construct( string $class_name ) {
			$this->class_name = $class_name;
		}

		public function process(): string {
			return sprintf(
				'Codekamino_Kpis_%s_Block_Template',
				str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $this->class_name ) ) )
			);
		}
	}
endif;
