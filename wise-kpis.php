<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codekamino.com
 * @since             1.0.0
 * @package           Codekamino_Kpis
 *
 * @wordpress-plugin
 * Plugin Name:       Wise KPIs
 * Plugin URI:        https://codekamino.com/wise-kpis
 * Description:       Power KPIs for your website hustle free, out of the box.
 * Version:           2.5.1
 * Author:            CodeKamino
 * Author URI:        https://codekamino.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wise-kpis
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WISE_KPIS_VERSION', '2.5.1' );
define( 'WISE_KPIS_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WISE_KPIS_DIR_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-codekamino-kpis-activator.php
 */
function activate_Codekamino_Kpis() {
	do_action('wise_kpis_activate');
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-codekamino-kpis-activator.php';
	Codekamino_Kpis_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-codekamino-kpis-deactivator.php
 */
function deactivate_Codekamino_Kpis() {
	do_action('wise_kpis_deactivate');
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-codekamino-kpis-deactivator.php';
	Codekamino_Kpis_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Codekamino_Kpis' );
register_deactivation_hook( __FILE__, 'deactivate_Codekamino_Kpis' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-codekamino-kpis.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Codekamino_Kpis() {
	$plugin = new Codekamino_Kpis();
	$plugin->run();
}

run_Codekamino_Kpis();
