<?php

add_action( 'init', function () {
	Codekamino_Kpis_Main_Item::create_menu_items();
	Codekamino_Kpis_Content_Kpis_Item::create_menu_items();
	Codekamino_Kpis_Users_Kpis_Item::create_menu_items();
	Codekamino_Kpis_Posts_Kpis_Item::create_menu_items();
	Codekamino_Kpis_System_Kpis_Item::create_menu_items();
	if ( class_exists( 'WooCommerce' ) ) {
		Codekamino_Kpis_Woocommerce_Kpis_Item::create_menu_items();
	}
} );

add_action( 'admin_enqueue_scripts', function () {
	wp_enqueue_style( 'wise-kpis-tailwind', WISE_KPIS_DIR_URL . 'admin/css/tailwind.css', [], '2.2.19', 'all' );
	wp_enqueue_style( 'wise-kpis', WISE_KPIS_DIR_URL . 'admin/css/wise-kpis.css', [], '1.0.0', 'all' );
    wp_enqueue_script( 'wise-kpis-apex', WISE_KPIS_DIR_URL . 'admin/js/apexcharts.js', [], '3.41.0', true );

    wp_enqueue_script('kpis-charts', WISE_KPIS_DIR_URL . 'admin/js/kpis-charts.js', [], '1.0.0', true);
    wp_localize_script('kpis-charts', 'kpis_charts_obj', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('kpis_charts_nonce'),
    ]);
} );
