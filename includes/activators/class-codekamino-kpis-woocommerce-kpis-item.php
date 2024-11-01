<?php

if ( ! class_exists( 'Codekamino_Kpis_Woocommerce_Kpis_Item' ) ) :
	class Codekamino_Kpis_Woocommerce_Kpis_Item {
		public static function create_menu_items(): void {
			Codekamino_Kpis_Menu_Item_Factory::create_sub_menu_item(
				'woowise-kpis',
				'Woocommerce KPIs',
				'Woocommerce KPIs',
				'manage_options',
				'woowise-woocommerce-kpis',
				[ Codekamino_Kpis_Woocommerce_Kpis_Page::class, 'render' ]
			);
		}
	}
endif;
