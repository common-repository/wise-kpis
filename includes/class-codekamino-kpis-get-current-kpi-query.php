<?php

if ( ! class_exists( 'Codekamino_Kpis_Get_Current_Kpi_Query' ) ) :
	class Codekamino_Kpis_Get_Current_Kpi_Query implements Codekamino_Kpis_Kpi_Query_Interface {
		private $wpdb;
		private $kpiName;

		public function __construct( $wpdb, string $kpiName ) {
			$this->wpdb    = $wpdb;
			$this->kpiName = sanitize_text_field( $kpiName );
		}

		public function get_query(): string {
			do_action( 'wise_kpis_before_query_preparation', $this );

			$query = $this->wpdb->prepare(
				"SELECT value FROM {$this->wpdb->prefix}Codekamino_Kpis 
				WHERE kpi_name = %s ORDER BY timestamp DESC LIMIT 1",
				$this->kpiName
			);

			// This is a filter hook that lets extensions modify the $query
			$query = apply_filters( 'wise_kpis_get_kpi_query', $query, $this );

			return $query;
		}
	}
endif;
