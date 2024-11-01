<?php

interface Codekamino_Kpis_Date_Range_Strategy_Interface {
	public function calculateDateRange(string $start_date, string $end_date): array;
}