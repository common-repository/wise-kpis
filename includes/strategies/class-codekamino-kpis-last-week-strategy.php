<?php

class Codekamino_Kpis_Last_Week_Strategy implements Codekamino_Kpis_Date_Range_Strategy_Interface {

	public function calculateDateRange( string $start_date, string $end_date ): array {
		$start_date = date( 'Y-m-d 00:00:00', strtotime( '-1 week', strtotime( $start_date ) ) );
		$end_date   = date( 'Y-m-d H:i:s', strtotime( '-1 day', strtotime( $end_date ) ) );

		return [ $start_date, $end_date ];
	}
}