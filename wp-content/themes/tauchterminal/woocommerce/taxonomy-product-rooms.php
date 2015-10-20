<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author         WooThemes
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $post;
?>

<?php
    /**
     * woocommerce_before_single_product hook
     *
     * @hooked wc_print_notices - 10
     */
     do_action('woocommerce_before_single_product');

     if (post_password_required()) {
         echo get_the_password_form();
         return;
     }
?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-md-6">
            <?php
                /**
                 * woocommerce_before_single_product_summary hook
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action('woocommerce_before_single_product_summary');
            ?>
        </div>

        <div class="col-md-6">
            <div class="summary entry-summary">

                <?php
                    /**
                     * woocommerce_single_product_summary hook
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_rating - 10
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     */
                    // do_action('woocommerce_single_product_summary');
                    wc_get_template('single-product/title.php');
                    wc_get_template('single-product/rating.php');
                    wc_get_template('single-product-diving/price.php');
                    wc_get_template('single-product/short-description.php');
                    if ($product->has_child()) { ?>
                        <?php $available_variations = $product->get_available_variations() ?>
                        <form class="form-horizontal variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr(json_encode($available_variations)) ?>">
                            <?php do_action('woocommerce_before_add_to_cart_form'); ?>
                            <?php if (! empty($available_variations)) : ?>
                                <?php
                                // var_dump($product->get_attributes());
                                wc_get_template('single-product-rooms/add-to-cart/attributes.php', array(
                                    'attributes' => $product->get_attributes()));

                                // Enqueue variation scripts
                                wp_enqueue_script('wc-add-to-cart-variation');
                                wc_get_template('single-product-rooms/add-to-cart/variable.php', array(
                                        'available_variations'  => $available_variations,
                                        'attributes'            => $product->get_variation_attributes(),
                                        'selected_attributes'   => $product->get_variation_default_attributes()
                                    ));
                                ?>

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

<?php
                    } else {
                        wc_get_template('single-product-rooms/add-to-cart/simple.php');
                    }
                    wc_get_template('single-product/meta.php');
                    wc_get_template('single-product/share.php');
                ?>

            </div><!-- .summary -->
        </div>

        <div class="col-md-12">
            <?php
                /**
                 * woocommerce_after_single_product_summary hook
                 *
                 * @hooked woocommerce_output_product_data_tabs - 10
                 * @hooked woocommerce_upsell_display - 15
                 * @hooked woocommerce_output_related_products - 20
                 */
                do_action('woocommerce_after_single_product_summary');
            ?>
        </div>

        <div class="col-md-12"><meta itemprop="url" content="<?php the_permalink(); ?>" /></div>
    </div>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action('woocommerce_after_single_product'); ?>
