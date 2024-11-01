<?php

if ( ! class_exists( 'Codekamino_Kpis_Filename_Block_Converter_Processor' ) ) :
	class Codekamino_Kpis_Filename_Block_Converter_Processor implements Codekamino_Kpis_Processor_interface {
		private $filename;
		private $prefix;

		public function __construct( string $filename, string $prefix = 'class-' ) {
			$this->filename = $filename;
			$this->prefix   = $prefix;
		}

		public function process(): string {
			// convert class name from full filename
			$classname = ucwords(
				str_replace(
					$this->prefix,
					'',
					basename( $this->filename, '.php' )
				),
				'-'
			);

			return str_replace( '-', '_', $classname );
		}
	}
endif;
