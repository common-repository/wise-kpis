<?php

if ( ! class_exists( 'Codekamino_Kpis_Menu_Item_Model' ) ) :
	class Codekamino_Kpis_Menu_Item_Model {
		private $menuTitle;
		private $pageTitle;
		private $capability;
		private $menuSlug;
		private $callback;
		private $iconUrl;
		private $position;

		public function __construct( $menuTitle, $pageTitle, $capability, $menuSlug, $callback, $iconUrl = '', $position = null ) {
			$this->menuTitle  = $menuTitle;
			$this->pageTitle  = $pageTitle;
			$this->capability = $capability;
			$this->menuSlug   = $menuSlug;
			$this->callback   = $callback;
			$this->iconUrl    = $iconUrl;
			$this->position   = $position;
		}

		public function getMenuTitle() {
			return $this->menuTitle;
		}

		public function getPageTitle() {
			return $this->pageTitle;
		}

		public function getCapability() {
			return $this->capability;
		}

		public function getMenuSlug() {
			return $this->menuSlug;
		}

		public function getCallback() {
			return $this->callback;
		}

		public function getIconUrl() {
			return $this->iconUrl;
		}

		public function getPosition() {
			return $this->position;
		}
	}
endif;
