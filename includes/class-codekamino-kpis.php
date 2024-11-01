<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://codekamino.com
 * @since      1.0.0
 *
 * @package    Wise_Kpis
 * @subpackage Wise_Kpis/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wise_Kpis
 * @subpackage Wise_Kpis/includes
 * @author     CodeKamino <info@codekamino.com>
 */

if ( ! class_exists( 'Codekamino_Kpis' ) ) :
	class Codekamino_Kpis {

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      Codekamino_Kpis_Loader $loader Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string $plugin_name The string used to uniquely identify this plugin.
		 */
		protected $plugin_name;

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string $version The current version of the plugin.
		 */
		protected $version;

		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			if ( defined( 'WISE_KPIS_VERSION' ) ) {
				$this->version = WISE_KPIS_VERSION;
			} else {
				$this->version = '1.0.0';
			}
			$this->plugin_name = 'woowise-kpis';

			$this->load_dependencies();
			$this->set_locale();
		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - Codekamino_Kpis_Loader. Orchestrates the hooks of the plugin.
		 * - Codekamino_Kpis_i18n. Defines internationalization functionality.
		 * - Codekamino_Kpis_Admin. Defines all hooks for the admin area.
		 * - Codekamino_Kpis_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function load_dependencies() {

			// Global Functions
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions.php';

			// Interfaces
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/interfaces/class-codekamino-kpis-calculator-interface.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/interfaces/class-codekamino-kpis-kpi-block-interface.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/interfaces/class-codekamino-kpis-processor-interface.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/interfaces/class-codekamino-kpis-chart-calculator-interface.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/interfaces/class-codekamino-kpis-kpi-query-interface.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/interfaces/class-codekamino-kpis-date-range-strategy-interface.php';

			// Blocks Templates
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/blocks-templates/class-codekamino-kpis-dark-mode-block-template.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/blocks-templates/class-codekamino-kpis-simple-clean-block-template.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/blocks-templates/class-codekamino-kpis-rounded-block-template.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/blocks-templates/class-codekamino-kpis-centered-text-block-template.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/blocks-templates/class-codekamino-kpis-vertical-aligned-centered-block-template.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/blocks-templates/class-codekamino-kpis-gradient-background-block-template.php';

			// Factories
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/factories/class-codekamino-kpis-menu-item-factory.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/factories/class-codekamino-kpis-date-range-strategy-factory.php';

			// Strategies
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/strategies/class-codekamino-kpis-yesterday-strategy.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/strategies/class-codekamino-kpis-last-week-strategy.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/strategies/class-codekamino-kpis-last-month-strategy.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/strategies/class-codekamino-kpis-last-year-strategy.php';

			// Activators
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/activators/class-codekamino-kpis-main-item.php'; // Menu Item
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/activators/class-codekamino-kpis-content-kpis-item.php'; // Menu Item
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/activators/class-codekamino-kpis-system-kpis-item.php'; // Menu Item
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/activators/class-codekamino-kpis-posts-kpis-item.php'; // Menu Item
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/activators/class-codekamino-kpis-woocommerce-kpis-item.php'; // Menu Item
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/activators/class-codekamino-kpis-users-kpis-item.php'; // Menu Item

			// Models
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/models/codekamino-kpis-menu-item-model.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/models/codekamino-kpis-kpi-block-model.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/models/codekamino-kpis-timeframe-model.php';

			// Pages
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pages/class-codekamino-kpis-basic-docs-page.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pages/class-codekamino-kpis-content-kpis-page.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pages/class-codekamino-kpis-users-kpis-page.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pages/class-codekamino-kpis-woocommerce-kpis-page.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pages/class-codekamino-kpis-system-kpis-page.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pages/class-codekamino-kpis-posts-kpis-page.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pages/class-codekamino-kpis-settings-page.php';

			// Processors
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/processors/class-codekamino-kpis-filename-block-converter-processor.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/processors/class-codekamino-kpis-design-block-converter-processor.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/processors/class-codekamino-kpis-timeframe-processor.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/processors/class-codekamino-kpis-date-calculator-processor.php';

			// Classes
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codekamino-kpis-kpi-blocks.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codekamino-kpis-blocks-iterator.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codekamino-kpis-calculate-kpi-change.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codekamino-kpis-kpi-box-builder.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codekamino-kpis-get-current-kpi-query.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codekamino-kpis-news-dashboard.php';

            // Charts
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/charts/woocommerce/class-codekamino-kpis-sales-chart-calculator.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/charts/woocommerce/class-codekamino-kpis-net-sales-chart-calculator.php';
			/**
			 * The class responsible for orchestrating the actions and filters of the
			 * core plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codekamino-kpis-loader.php';

			/**
			 * The class responsible for defining internationalization functionality
			 * of the plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codekamino-kpis-i18n.php';

			$this->loader = new Codekamino_Kpis_Loader();
		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 * Uses the Codekamino_Kpis_i18n class in order to set the domain and to register the hook
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function set_locale() {

			$plugin_i18n = new Codekamino_Kpis_i18n();

			$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since    1.0.0
		 */
		public function run() {
			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @return    string    The name of the plugin.
		 * @since     1.0.0
		 */
		public function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @return    Codekamino_Kpis_Loader    Orchestrates the hooks of the plugin.
		 * @since     1.0.0
		 */
		public function get_loader() {
			return $this->loader;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @return    string    The version number of the plugin.
		 * @since     1.0.0
		 */
		public function get_version() {
			return $this->version;
		}
	}
endif;
