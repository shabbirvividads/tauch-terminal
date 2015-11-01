<?php
/**
 * Cart Page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

wc_print_notices();

do_action('woocommerce_before_cart'); ?>
<div class="col-sm-8">
    <h3><?php echo __('Booking overview', 'tauch-terminal') ?></h3>
    <form action="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" method="post">

    <?php do_action('woocommerce_before_cart_table'); ?>

    <table class="table cart" cellspacing="0">
        <thead>
            <tr>
                <th class="product-thumbnail-ttt">&nbsp;</th>
                <th class="product-name"><?php _e('Product', 'woocommerce'); ?></th>
                <th class="product-price"><?php _e('Price', 'woocommerce'); ?></th>
                <th class="product-quantity"><?php _e('Quantity', 'woocommerce'); ?></th>
                <th class="product-subtotal"><?php _e('Total', 'woocommerce'); ?></th>
                <th class="product-remove">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product     = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id   = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    ?>
                    <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                        <td class="product-thumbnail-ttt">
                            <?php
                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                if (!$_product->is_visible()) {
                                    echo $thumbnail;
                                } else {
                                    printf('<a href="%s">%s</a>', esc_url($_product->get_permalink($cart_item)), $thumbnail);
                                }
                            ?>
                        </td>

                        <td class="product-name">
                            <?php
                                if (!$_product->is_visible()) {
                                    echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key) . '&nbsp;';
                                } else {
                                    echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s </a>', esc_url($_product->get_permalink($cart_item)), $_product->get_title()), $cart_item, $cart_item_key);
                                }

                                // Meta data
                                if ($cart_item['start_date'] && $cart_item['end_date']):
                                ?>
                                <dl class="variation">
                                    <dt class="variation-<?php echo sanitize_html_class('Travel dates'); ?>"><?php echo wp_kses_post(__('Travel dates')); ?>:</dt>
                                    <dd class="variation-<?php echo sanitize_html_class('Travel dates'); ?>"><?php echo TauchTerminal_Tulamben::formatDateFromTo($cart_item['start_date'], $cart_item['end_date']) ?></dd>
                                </dl>
                                <?
                                endif;

                                foreach ($cart_item['ttt_meta'] as $name => $value) {
                                    if ($value):
                                    ?>
                                    <dl class="variation">
                                        <dt class="variation-<?php echo sanitize_html_class($name); ?>"><?php echo wp_kses_post($name); ?>:</dt>
                                        <dd class="variation-<?php echo sanitize_html_class($name); ?>"><?php echo $value ?></dd>
                                    </dl>
                                    <?
                                    endif;
                                }


                                echo WC()->cart->get_item_data($cart_item);

                                // Backorder notification
                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                    echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>';
                                }
                            ?>
                        </td>

                        <td class="product-price">
                            <?php
                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                            ?>
                        </td>

                        <td class="product-quantity">
                            <?php
                                if ($_product->is_sold_individually()) {
                                    $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                } else {
                                    $product_quantity = woocommerce_quantity_input(array(
                                        'input_name'  => "cart[{$cart_item_key}][qty]",
                                        'input_value' => $cart_item['quantity'],
                                        'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                                        'min_value'   => '0'
                                   ), $_product, false);
                                }

                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key);
                            ?>
                        </td>

                        <td class="product-subtotal">
                            <?php
                                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                            ?>
                        </td>

                        <td class="product-remove">
                            <?php
                                echo apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url(WC()->cart->get_remove_url($cart_item_key)), __('Remove this item', 'woocommerce')), $cart_item_key);
                            ?>
                        </td>

                    </tr>
                    <?php
                }
            }

            do_action('woocommerce_cart_contents');
            ?>
            <tr>
                <td colspan="6" class="actions">

                    <?php if (WC()->cart->coupons_enabled()) { ?>
                        <div class="coupon">

                            <label for="coupon_code"><?php _e('Coupon', 'woocommerce'); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e('Coupon code', 'woocommerce'); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e('Apply Coupon', 'woocommerce'); ?>" />

                            <?php do_action('woocommerce_cart_coupon'); ?>
                        </div>
                    <?php } ?>

                    <input type="submit" class="button" name="update_cart" value="<?php _e('Update Cart', 'woocommerce'); ?>" />

                    <?php do_action('woocommerce_cart_actions'); ?>

                    <?php wp_nonce_field('woocommerce-cart'); ?>
                </td>
            </tr>

            <?php do_action('woocommerce_after_cart_contents'); ?>
        </tbody>
    </table>

    <?php do_action('woocommerce_after_cart_table'); ?>

    </form>
</div>

<div class="col-sm-4">
    <div class="cart-collaterals">
        <?php do_action('woocommerce_cart_collaterals'); ?>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>
