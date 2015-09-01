<?php
/**
* Cart totals
*
* @author 		WooThemes
* @package 	WooCommerce/Templates
* @version     2.3.6
*/

if ( ! defined( 'ABSPATH' ) ) {
exit;
}

?>

<tr class="cart-subtotal">
	<td></td>
    <th colspan="3"><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
	<td class="text-right"><?php wc_cart_totals_subtotal_html(); ?></td>
    <td></td>
</tr>

<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
	<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
		<td></td>
        <th colspan="3"><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
		<td class="text-right"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
        <td></td>
	</tr>
<?php endforeach; ?>

<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

	<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

	<?php wc_cart_totals_shipping_html(); ?>

	<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

<?php elseif ( WC()->cart->needs_shipping() ) : ?>

	<tr class="shipping">
		<td></td>
        <th colspan="3"><?php _e( 'Shipping', 'woocommerce' ); ?></th>
		<td class="text-right"><?php woocommerce_shipping_calculator(); ?></td>
        <td></td>
	</tr>

<?php endif; ?>

<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
	<tr class="fee">
		<td></td>
        <th colspan="3"><?php echo esc_html( $fee->name ); ?></th>
		<td class="text-right"><?php wc_cart_totals_fee_html( $fee ); ?></td>
        <td></td>
	</tr>
<?php endforeach; ?>

<?php if ( WC()->cart->tax_display_cart == 'excl' ) : ?>
	<?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) : ?>
		<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
			<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
				<td></td>
                <th colspan="3"><?php echo esc_html( $tax->label ); ?></th>
				<td class="text-right"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                <td></td>
			</tr>
		<?php endforeach; ?>
	<?php else : ?>
		<tr class="tax-total">
			<td></td>
            <th colspan="3"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
			<td class="text-right"><?php wc_cart_totals_taxes_total_html(); ?></td>
            <td></td>
		</tr>
	<?php endif; ?>
<?php endif; ?>

<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

<tr class="order-total">
	<td></td>
    <th colspan="3"><?php _e( 'Total', 'woocommerce' ); ?></th>
	<td class="text-right"><?php wc_cart_totals_order_total_html(); ?></td>
    <td></td>
</tr>

<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
