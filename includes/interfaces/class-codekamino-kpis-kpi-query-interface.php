<?php


interface Codekamino_Kpis_Kpi_Query_Interface {
	/**
	 * Returns the SQL query to get the value of the KPI for the specified date
	 *
	 * @param string $kpiName The name of the KPI to retrieve
	 * @param \DateTime $date The date to retrieve the KPI value for
	 *
	 * @return string The SQL query to retrieve the KPI value
	 */
	public function get_query(): string;
}
