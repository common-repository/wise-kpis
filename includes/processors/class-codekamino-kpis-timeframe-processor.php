<?php

if ( ! class_exists( 'Codekamino_Kpis_Timeframe_Processor' ) ):
	class Codekamino_Kpis_Timeframe_Processor implements Codekamino_Kpis_Processor_interface {
		private $timeframe;

		public function __construct( Codekamino_Kpis_Timeframe_Model $timeframe ) {
			$this->timeframe = $timeframe;
		}

		public function process(): string {
			$startDate = $this->timeframe->get_start_date();
			$endDate   = $this->timeframe->get_end_date();
			$timeUnit  = $this->timeframe->get_time_unit();

			$customized = ! empty( $startDate ); // Check if start date is filled

			$data = [
				"start_date" => $startDate,
				"end_date"   => $customized ? $endDate : "", // Use end date only if customized is true
				"unit"       => $timeUnit,
				"customized" => $customized
			];

			return json_encode( $data );
		}
	}
endif;