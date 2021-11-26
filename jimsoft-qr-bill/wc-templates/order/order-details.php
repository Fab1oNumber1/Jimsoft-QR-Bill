<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.6.0
 */

/** @var string $pdf_color_primary */
/** @var Jimsoft_Qr_Bill_Invoice_Generator $this */
defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array(
	'completed',
	'processing'
) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

$td_widths = [ '50%', '20%', '30%' ];
if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>

<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>


<?php if ( $value = $this->get_option( 'pdf_order_details_title' ) ): ?>
    <h2 class="woocommerce-order-details__title"><?= $value; ?></h2>
<?php endif; ?>


<?php if ( $value = $this->get_option( 'pdf_order_details_text' ) ): ?>
	<?= nl2br($value); ?>
    <br/>
    <br/>
<?php endif; ?>

    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details" cellpadding="<?= $this->get_option('pdf_table_cellpadding'); ?>">

        <thead>
        <tr>
            <th class="woocommerce-table__product-name product-name" width="<?= $td_widths[0] ?>"
                style="color: white; background-color: <?= $pdf_color_primary ?>"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
            <th class="woocommerce-table__product-name product-name" width="<?= $td_widths[1] ?>" align="right"
                style="color: white; background-color: <?= $pdf_color_primary ?>"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
            <th class="woocommerce-table__product-table product-total" width="<?= $td_widths[2] ?>" align="right"
                style="color: white; background-color: <?= $pdf_color_primary ?>"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
        </tr>
        </thead>

        <tbody>
		<?php
		do_action( 'woocommerce_order_details_before_order_table_items', $order );

		$i = 0;
		foreach ( $order_items as $item_id => $item ) {
			$product = $item->get_product();

			$purchase_note = $product ? $product->get_purchase_note() : '';
			include __DIR__ . '/order-details-item.php';
			$i ++;
		}

		do_action( 'woocommerce_order_details_after_order_table_items', $order );
		?>
        </tbody>

        <tfoot>
		<?php
		foreach ( $order->get_order_item_totals() as $key => $total ) {
			if ( $key === 'payment_method' ) {
				continue;
			}
			?>
            <tr>
                <th scope="row" width="<?= $td_widths[0] ?>"><?php echo esc_html( $total['label'] ); ?></th>
                <th width="<?= $td_widths[1] ?>"></th>
                <td width="<?= $td_widths[2] ?>"
                    align="right"><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
            </tr>
			<?php
		}
		?>

		<?php if ( false && $order->get_customer_note() ) : ?>
            <tr>
                <th width="<?= $td_widths[0] ?>"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
                <th width="<?= $td_widths[1] ?>"></th>
                <td width="<?= $td_widths[2] ?>"
                    align="right"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
            </tr>
		<?php endif; ?>
        </tfoot>
    </table>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>


<?php
/**
 * Action hook fired after the order details.
 *
 * @param WC_Order $order Order data.
 *
 * @since 4.4.0
 */
do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	//wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
