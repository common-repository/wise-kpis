<?php

if ( ! class_exists( 'Codekamino_Kpis_Kpi_Block_Model' ) ) :
	class Codekamino_Kpis_Kpi_Block_Model {
		private $name;
		private $description;
		private $currentValue;
		private $previousValue;

		public function __construct( string $name, string $description, float $currentValue, float $previousValue ) {
			$this->name          = $name;
			$this->description   = $description;
			$this->currentValue  = $currentValue;
			$this->previousValue = $previousValue;
		}

		public function getName(): string {
			return $this->name;
		}

		public function getDescription(): string {
			return $this->description;
		}

		public function getCurrentValue(): float {
			return $this->currentValue;
		}

		public function getPreviousValue(): float {
			return $this->previousValue;
		}

		public function getChangePercentage(): float {
			return ( new Codekamino_Kpis_Calculate_Kpi_Change( $this->currentValue, $this->previousValue ) )->calculate();
		}
	}
endif;
