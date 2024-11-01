<?php

interface Codekamino_Kpis_Kpi_Block_Interface {
	public function get_name(): string;

	public function get_description(): string;

	public function get_current_value( string $start_date, string $end_date ): float;

	public function get_change_percentage( float $currentValue, float $previousValue ): float;
}
