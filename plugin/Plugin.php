<?php

namespace JimSoft\QrBill;

class Plugin {


    public static function check_requirements() {
        if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            return true;
        } else {
            add_action( 'admin_notices', [self::class, 'missing_wc_notice'] );
            return false;
        }
    }

    public static function  missing_wc_notice() {
        $class = 'notice notice-error';
        $message = __( 'QR Rechnung böntigt eine aktive WooCommerce-Installation.');

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }

    public static function activate() {

    }

    public static function deactivate() {

    }
}