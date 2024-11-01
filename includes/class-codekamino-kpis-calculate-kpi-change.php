<?php

if ( ! class_exists( 'Codekamino_Kpis_Calculate_Kpi_Change' ) ) :
	class Codekamino_Kpis_Calculate_Kpi_Change {
		private $currentValue;
		private $previousValue;

		public function __construct( $currentValue, $previousValue ) {
			$currentValue        = is_numeric( $currentValue ) ? (float) $currentValue : 0;
			$this->currentValue  = apply_filters( 'wise_kpis_current_value', $currentValue );
			$previousValue       = is_numeric( $previousValue ) ? (float) $previousValue : 0;
			$this->previousValue = apply_filters( 'wise_kpis_previous_value', $previousValue );
		}

		public function calculate() {
			do_action( 'wise_kpis_before_calculate_change', $this->currentValue, $this->previousValue );

			if ( $this->previousValue == 0 ) {
				return 0;
			}

			$change = ( $this->currentValue - $this->previousValue ) / abs( $this->previousValue ) * 100;
			$change = round( $change, 2 );

			$change = apply_filters( 'wise_kpis_calculate_change', $change );
			do_action( 'wise_kpis_after_calculate_change', $this->currentValue, $this->previousValue, $change );

			return $change;
		}
	}
endif;
