<?php

/**
 * A factory class to create new menu items when activating the plugin
 *
 * @since      1.0.0
 * @package    Wise_Kpis
 * @subpackage Wise_Kpis/includes
 * @author     CodeKamino <info@codekamino.com>
 */

if ( ! class_exists( 'Codekamino_Kpis_Menu_Item_Factory' ) ) {
	class Codekamino_Kpis_Menu_Item_Factory {
		/**
		 * Create a new menu item.
		 *
		 * @param string $page_title The text to be displayed in the title tags of the page when the menu is selected
		 * @param string $menu_title The text to be used for the menu
		 * @param string $capability The capability required for this menu to be displayed to the user
		 * @param string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
		 * @param callable $callback The function to be called to output the content for this page
		 * @param string $icon_url The URL to the icon to be used for this menu
		 * @param int $position The position in the menu order this item should appear
		 *
		 * @return MenuItem The created MenuItem instance
		 */
		public static function create_menu_item(
			string $page_title,
			string $menu_title,
			string $capability,
			string $menu_slug,
			callable $callback,
			string $icon_url = '',
			int $position = null
		): Codekamino_Kpis_Menu_Item_Model {
			$menu_item = new Codekamino_Kpis_Menu_Item_Model(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback,
				$icon_url,
				$position
			);

			add_action( 'admin_menu', function () use ( $menu_item ) {
				add_menu_page(
					$menu_item->getPageTitle(),
					$menu_item->getMenuTitle(),
					$menu_item->getCapability(),
					$menu_item->getMenuSlug(),
					$menu_item->getCallback(),
					$menu_item->getIconUrl(),
					$menu_item->getPosition()
				);
			} );

			return $menu_item;
		}

		/**
		 * Create a new submenu item.
		 *
		 * @param string $parent_slug The slug name for the parent menu (should match that used in createMenuItem())
		 * @param string $page_title The text to be displayed in the title tags of the page when the menu is selected
		 * @param string $menu_title The text to be used for the menu
		 * @param string $capability The capability required for this menu to be displayed to the user
		 * @param string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
		 * @param callable|array $callback The function or class method to be called to output the content for this page
		 *
		 * @return MenuItem The created MenuItem instance
		 */
		public static function create_sub_menu_item(
			string $parent_slug,
			string $page_title,
			string $menu_title,
			string $capability,
			string $menu_slug,
			$callback
		): Codekamino_Kpis_Menu_Item_Model {
			$menu_item = new Codekamino_Kpis_Menu_Item_Model(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback
			);

			add_action( 'admin_menu', function () use ( $menu_item, $parent_slug ) {
				add_submenu_page(
					$parent_slug,
					$menu_item->getPageTitle(),
					$menu_item->getMenuTitle(),
					$menu_item->getCapability(),
					$menu_item->getMenuSlug(),
					$menu_item->getCallback()
				);
			} );

			return $menu_item;
		}
	}
}
