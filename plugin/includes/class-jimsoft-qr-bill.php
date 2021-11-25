<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://jimsoft.ch
 * @since      1.0.0
 *
 * @package    Jimsoft_Qr_Bill
 * @subpackage Jimsoft_Qr_Bill/includes
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
 * @package    Jimsoft_Qr_Bill
 * @subpackage Jimsoft_Qr_Bill/includes
 * @author     JimSoft <info@jimsoft.ch>
 */
class Jimsoft_Qr_Bill {

	const PREFIX = 'jimsoft-qr-bill_';
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Jimsoft_Qr_Bill_Loader $loader Maintains and registers all hooks for the plugin.
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
		if ( defined( 'JIMSOFT_QR_BILL_VERSION' ) ) {
			$this->version = JIMSOFT_QR_BILL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'jimsoft-qr-bill';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Jimsoft_Qr_Bill_Loader. Orchestrates the hooks of the plugin.
	 * - Jimsoft_Qr_Bill_i18n. Defines internationalization functionality.
	 * - Jimsoft_Qr_Bill_Admin. Defines all hooks for the admin area.
	 * - Jimsoft_Qr_Bill_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jimsoft-qr-bill-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jimsoft-qr-bill-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-jimsoft-qr-bill-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-jimsoft-qr-bill-public.php';

		$this->loader = new Jimsoft_Qr_Bill_Loader();

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jimsoft-qr-bill-invoice-generator.php';


	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Jimsoft_Qr_Bill_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Jimsoft_Qr_Bill_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Jimsoft_Qr_Bill_Admin( $this->get_plugin_name(), $this->get_version() );


		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_filter( 'woocommerce_get_settings_pages', $plugin_admin, 'woocommerce_add_settings' );
		$this->loader->add_filter( 'woocommerce_order_actions', $plugin_admin, 'add_order_meta_box_action_download_invoice' );

		$this->loader->add_action( 'woocommerce_order_action_' . Jimsoft_Qr_Bill::PREFIX . 'download_pdf', $plugin_admin, 'process_order_meta_box_action_download_invoice' );

		$this->loader->add_filter('manage_edit-shop_order_columns', $plugin_admin, 'shop_order_columns_add_download_invoice');
		$this->loader->add_action('manage_shop_order_posts_custom_column', $plugin_admin, 'manage_shop_order_posts_custom_column_download_invoice_content', 10, 2);


		add_action( 'template_redirect', function () {
			if ( isset( $_REQUEST['jimsoft_order_id'] ) ) {
				$id = $_REQUEST['jimsoft_order_id'];

				$generator = new Jimsoft_Qr_Bill_Invoice_Generator($id);

				$generator->generate( );
				exit;
			}
		} );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Jimsoft_Qr_Bill_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
	 * @return    Jimsoft_Qr_Bill_Loader    Orchestrates the hooks of the plugin.
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
