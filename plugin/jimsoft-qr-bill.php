<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jimsoft.ch
 * @since             1.0.0
 * @package           Jimsoft_Qr_Bill
 *
 * @wordpress-plugin
 * Plugin Name:       JimSoft QR Bill
 * Plugin URI:        https://jimsoft.ch
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            JimSoft
 * Author URI:        https://jimsoft.ch
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jimsoft-qr-bill
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require __DIR__ . '/vendor/autoload.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'JIMSOFT_QR_BILL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jimsoft-qr-bill-activator.php
 */
function activate_jimsoft_qr_bill() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jimsoft-qr-bill-activator.php';
	Jimsoft_Qr_Bill_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jimsoft-qr-bill-deactivator.php
 */
function deactivate_jimsoft_qr_bill() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jimsoft-qr-bill-deactivator.php';
	Jimsoft_Qr_Bill_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jimsoft_qr_bill' );
register_deactivation_hook( __FILE__, 'deactivate_jimsoft_qr_bill' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jimsoft-qr-bill.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jimsoft_qr_bill() {

	$plugin = new Jimsoft_Qr_Bill();
	$plugin->run();

}
run_jimsoft_qr_bill();
