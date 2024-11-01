<?php

if ( ! class_exists( 'Codekamino_Kpis_System_Kpis_Item' ) ) :
	class Codekamino_Kpis_System_Kpis_Item {
		public static function create_menu_items(): void {
			Codekamino_Kpis_Menu_Item_Factory::create_sub_menu_item(
				'woowise-kpis',
				'System KPIs',
				'System KPIs',
				'manage_options',
				'woowise-system-kpis',
				[ Codekamino_Kpis_System_Kpis_Page::class, 'render' ]
			);
		}
	}
endif;
