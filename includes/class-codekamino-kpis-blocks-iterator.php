<?php

if ( ! class_exists( 'Codekamino_Kpis_Blocks_Iterator' ) ) :
	class Codekamino_Kpis_Blocks_Iterator {
		private $wpdb;
		private $path;
		private $date_calculator_processor;

		public function __construct( $wpdb, $path, string $date_calculator_processor ) {
			$this->wpdb                      = $wpdb;
			$this->path                      = $path;
			$this->date_calculator_processor = json_decode( $date_calculator_processor );
		}

		public function get_blocks() {
			$directory = dirname( __FILE__ ) . "/$this->path";
			$blocks    = array_map( function ( $filename ) {

				require_once( $filename );
				$block_processor = new Codekamino_Kpis_Filename_Block_Converter_Processor( $filename );

				$classname = $block_processor->process();

				if ( class_exists( $classname ) ) {
					$reflector = new ReflectionClass( $classname );

					if ( $reflector->implementsInterface( Codekamino_Kpis_Kpi_Block_Interface::class ) ) {
						return $reflector->newInstance( $this->wpdb, $this->date_calculator_processor );
					}
				}
			}, glob( "{$directory}/*.php" ) );

			return array_filter( $blocks ); // Removes null values from the array
		}
	}
endif;
