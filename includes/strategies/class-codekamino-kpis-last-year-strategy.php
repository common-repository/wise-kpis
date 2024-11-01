<?php

class Codekamino_Kpis_Last_Year_Strategy implements Codekamino_Kpis_Date_Range_Strategy_Interface {

	public function calculateDateRange( string $start_date, string $end_date ): array {
		$start_date = date( 'Y-m-d 00:00:00', strtotime( '-1 year', strtotime( $start_date ) ) );
		$end_date   = date( 'Y-m-d H:i:s', strtotime( '-1 year', strtotime( $end_date ) ) );

		return [ $start_date, $end_date ];
	}
}