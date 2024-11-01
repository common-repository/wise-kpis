<?php

if ( ! class_exists( 'Codekamino_Kpis_Main_Item' ) ) :
	class Codekamino_Kpis_Main_Item {
		public static function create_menu_items(): void {
			Codekamino_Kpis_Menu_Item_Factory::create_menu_item(
				'Wise KPIs',
				'Wise KPIs',
				'manage_options',
				'woowise-kpis',
				[ Codekamino_Kpis_Basic_Docs_Page::class, 'render' ]
			);
		}
	}
endif;
