<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="form-horizontal variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->id ); ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
    <?php do_action( 'woocommerce_before_variations_form' ); ?>

    <?php if (! empty($available_variations)) : ?>

        <div class="variations">
            <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label>
                    <div class="col-sm-9">
                        <?php
                            $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
                            wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected, 'class' => 'form-control' ) );
                            echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations" href="#" style="visibility: hidden;">' . __( 'Clear selection', 'woocommerce' ) . '</a>' : '';
                        ?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>

        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

        <div class="single_variation_wrap pull-right" style="display:none;">
            <?php do_action('woocommerce_before_single_variation'); ?>

            <div class="single_variation"></div>

            <div class="variations_button">
                <input type="hidden" name="quantity" value="1" />
                <button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
            </div>

            <input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
            <input type="hidden" name="product_id" value="<?php echo esc_attr($post->ID); ?>" />
            <input type="hidden" name="variation_id" class="variation_id" value="" />

            <?php do_action('woocommerce_after_single_variation'); ?>
        </div>

        <?php do_action('woocommerce_after_add_to_cart_button'); ?>

    <?php else : ?>

        <p class="stock out-of-stock"><?php _e('This product is currently out of stock and unavailable.', 'woocommerce'); ?></p>

    <?php endif; ?>

</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>
