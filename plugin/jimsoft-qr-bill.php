<?php

/**
 * Plugin Name: QR Rechnung
 * Version: 0.0.1
 * Plugin URI: https://jimsoft.ch/
 * Description: QR Rechnung für schweizer Webshops
 * Author: JimSoft
 * Author URI: https://jimsoft.ch
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: jimsoft-qr-bill
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Fabio Büsser
 * @since 1.0.0
 */

namespace JimSoft\QrBill;

if (!defined('WPINC')) {
    die;
}


define('JIMSOFT_QR_BILL_VERSION', '0.0.1');

function __($string)
{
    return \__($string, 'jimsoft-qr-bill');
}

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . '/wp-admin/includes/plugin.php');
}

require __DIR__ . '/Plugin.php';

register_activation_hook(__FILE__, [Plugin::class, 'activate']);
register_deactivation_hook(__FILE__, [Plugin::class, 'deactivate']);


function run()
{
    if (Plugin::check_requirements()) {

    }
}

run();


