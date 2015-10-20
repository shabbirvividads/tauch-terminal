<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 */

if (! defined('ABSPATH')) {
    exit;
}

global $product, $post;

$attribute_keys = array_keys( $attributes );
?>

<?php foreach ( $attributes as $attribute_name => $options ) : ?>
     <div class="form-group variations">
        <label for="<?php echo sanitize_title( $attribute_name ); ?>" class="col-sm-3 control-label"><?php echo wc_attribute_label( $attribute_name ); ?></label>
        <div class="col-sm-9 value">
            <?php
                $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
                wc_dropdown_variation_attribute_options(
                    array(
                        'options' => $options,
                        'attribute' => $attribute_name,
                        'product' => $product,
                        'selected' => $selected,
                        'class' => 'form-control'
                    )
                );
                echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations" href="#" style="visibility: hidden;">' . __( 'Clear selection', 'woocommerce' ) . '</a>' : '';
            ?>
        </div>
    </div>
<?php endforeach;?>
