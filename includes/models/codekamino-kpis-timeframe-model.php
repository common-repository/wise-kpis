<?php

if ( ! class_exists( 'Codekamino_Kpis_Timeframe_Model' ) ):
	class Codekamino_Kpis_Timeframe_Model {
		private $timeframe;

		public function __construct( object $query_timeframe ) {
			$this->timeframe = $query_timeframe;
		}


		/**
		 * @return mixed
		 */
		public function get_end_date() {
			return $this->timeframe->end_date;
		}

		/**
		 * @return mixed
		 */
		public function get_start_date() {
			return $this->timeframe->start_date;

		}

		/**
		 * @return mixed
		 */
		public function get_time_unit() {
			return $this->timeframe->unit_type;
		}
	}

endif;