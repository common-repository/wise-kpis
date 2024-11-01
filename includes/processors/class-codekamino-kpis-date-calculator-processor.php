<?php

class Codekamino_Kpis_Date_Calculator_Processor implements Codekamino_Kpis_Processor_interface {
	private $timeframe;

	public function __construct( Codekamino_Kpis_Timeframe_Model $timeframe ) {
		$this->timeframe = $timeframe;
	}

	public function process(): string {
		$start_date = $this->timeframe->get_start_date();
		$end_date   = $this->timeframe->get_end_date();

		if ( empty( $this->timeframe->get_start_date() ) ) {
			$start_date = date( 'Y-m-d' ) . ' 00:00:00';
			$end_date   = date( 'Y-m-d H:i:s' );
		} elseif ( empty( $this->timeframe->get_end_date() ) && $this->timeframe->get_time_unit() === 'yesterday' ) {
			$start_date = date( 'Y-m-d', strtotime( '-1 day' ) );
			$end_date   = date( 'Y-m-d H:i:s', strtotime( '-1 day' ) );
		}

		$strategy = Codekamino_Kpis_Date_Range_Strategy_Factory::createStrategy( $this->timeframe->get_time_unit() );
		if ( $strategy ) {
			[ $compare_start_date, $compare_end_date ] = $strategy->calculateDateRange( $start_date, $end_date );
		}
		$response = [
			'unit'          => htmlentities( $this->timeframe->get_time_unit() ),
			'start_date'    => htmlentities( $start_date ),
			'end_date'      => htmlentities( $end_date ),
			'compare_start' => htmlentities( $compare_start_date ),
			'compare_end'   => htmlentities( $compare_end_date )
		];

		return json_encode( $response );
	}
}
