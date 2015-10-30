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
if (!is_plugin_active('tauch-terminal/tauch-terminal.php')) {
    exit; // need TTT plugin to be activated
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
            <div class="summary entry-summary relative">
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
            ?>
                <?php if ($product->has_child()): ?>
                    <?php $available_variations = $product->get_available_variations() ?>
                    <form class="form-horizontal variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr(json_encode($available_variations)) ?>">
                        <?php do_action('woocommerce_before_add_to_cart_form'); ?>
                        <div class="form-group">
                            <label for="datepicker" class="col-sm-3 control-label"><?php echo __('Date', 'tauchterminal') ?></label>
                            <div class="col-sm-9">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control star-date" name="start" />
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control end-date" name="end" />
                                </div>
                                <p class="help-block"><?php echo __('By default the range is set to 6 nights.', 'tauchterminal') ?></p>
                            </div>
                        </div>
                        <?php
                        // var_dump($product->get_attributes());
                        wc_get_template('single-product-rooms/add-to-cart/attributes.php', array(
                            'attributes' => $product->get_attributes())
                        );

                        // Enqueue variation scripts
                        wp_enqueue_script('wc-add-to-cart-variation');
                        wc_get_template('single-product-rooms/add-to-cart/variable.php', array(
                                'available_variations'  => $available_variations,
                                'attributes'            => $product->get_variation_attributes(),
                                'selected_attributes'   => $product->get_variation_default_attributes()
                            ));
                        ?>
                        <div class="row">
                            <div class="col-sm-9 col-sm-offset-3">
                                <a href="#" class="btn btn-primary check-room-availability hidden"><?php echo __('Check Room Availability', 'tauchterminal') ?></a>
                            </div>

                            <?php do_action('woocommerce_before_add_to_cart_button'); ?>
                            <div class="col-sm-9 col-sm-offset-3">
                                <div class="alert alert-room-availability hidden" role="alert">

                                </div>
                            </div>

                            <div class="col-sm-9 col-sm-offset-3 single_variation_wrap text-right hidden" style="display:none;">
                                <?php do_action('woocommerce_before_single_variation'); ?>

                                <div class="single_variation"></div>

                                <div class="variations_button pull-right">
                                    <input type="hidden" name="quantity" value="1" />
                                    <button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
                                </div>

                                <input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
                                <input type="hidden" name="product_id" value="<?php echo esc_attr($post->ID); ?>" />
                                <input type="hidden" name="variation_id" class="variation_id" value="" />

                                <?php do_action('woocommerce_after_single_variation'); ?>
                            </div>
                        </div>

                        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                    </form>
                    <?php do_action('woocommerce_after_add_to_cart_form'); ?>

                <?php else: ?>
                    wc_get_template('single-product-rooms/add-to-cart/simple.php');
                <?php endif; ?>

                <?php wc_get_template('single-product/meta.php'); ?>
                <?php wc_get_template('single-product/share.php'); ?>
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

<script type="text/javascript">
    var roomjson = JSON.parse('<?php echo TauchTerminal_DB::getTTOption("rooms") ?>');
    jQuery(document).ready(function($) {
        var rooms = {};
        var count_similarities = function(arrayA, arrayB) {
            var matches = [];
            for (i=0;i<arrayA.length;i++) {
                if (arrayB.indexOf(arrayA[i]) != -1)
                    matches.push(arrayA[i]);
            }
            return matches;
        }
        var checkSpecialRequests = function() {
            var sku = $('span.sku').text();
            var isFamily = $('input[name="isFamily"]').val();
            var isBungalow = $('input[name="isBungalow"]').val();
            var king = $('select[name="attribute_bed"]').val();
            var wheelchair = $('select[name="attribute_special-requests"]').val();

            if (isFamily) {
                var familyrooms = roomjson.rooms.filter(function(eq) {
                    return eq.family === true;
                });
                rooms = familyrooms;
                return true;
            } else if (isBungalow) {
                var bungalowrooms = roomjson.rooms.filter(function(eq) {
                    return eq.bungalow === true;
                });
                rooms = bungalowrooms;
                return true;
            }

            if (king != 0) {
                rooms = roomjson.rooms.filter(function(eq) {
                    return eq.kingbed == king;
                });
            }

            if (wheelchair != 0) {
                var wheelchair = roomjson.rooms.filter(function(eq) {
                    return eq.upstairs == false;
                });
                if (king != 0) {
                    rooms = wheelchair;
                } else {
                    rooms = count_similarities(rooms, wheelchair);
                }
            }

            if ($.isEmptyObject(rooms)) {
                rooms = roomjson.rooms;
            }

            return rooms;
        };

        checkSpecialRequests();

        $('.variations_form .input-daterange').datepicker({
            weekStart: 1,
            startDate: "today",
            todayHighlight: true,
            autoclose: true
        }).on('changeDate', function(e) {
            // set default range to 6 nights
            if ($('.star-date').val() === $('.end-date').val()) {
                var date = new Date($('.end-date').val());
                date.setDate(date.getDate() + 6);
                $('.end-date').datepicker('setDate', date);

            }
            $('.single_variation_wrap').addClass('hidden');
            $('.check-room-availability').removeClass('hidden');
        });

        $('.summary select').on('change', function(e) {
            checkSpecialRequests();
            $('.single_variation_wrap').addClass('hidden');
            $('.check-room-availability').removeClass('hidden');
        });

        $('.check-room-availability').on('click', function(e) {
            e.preventDefault();
            var start = new Date($('.star-date').val());
            var end = new Date($('.end-date').val());
            $('.summary').prepend('<div class="ajaxloader"></div>');
            checkSpecialRequests();

            $.post('<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php',
                {
                    action: 'tttajax',
                    tttaction: 'hotelsystem-availableRooms',
                    data: {
                        'start': start,
                        'end': end,
                        'rooms': rooms
                    }
                },
                function(response) { // on success
                    $('.check-room-availability').addClass('hidden');

                    if (!$.isEmptyObject(response)) {
                        var count = Object.keys(response).length;
                        if (count <= 5) {
                            $('.alert-room-availability').removeClass('hidden').addClass('alert-warning').html("<strong><?php echo __('Only " + count + " left!', 'tauchterminal') ?></strong> <?php echo __('Book now, there are not many rooms left.', 'tauchterminal') ?>");
                        }
                        $('.single_variation_wrap').removeClass('hidden');
                    } else {
                        $('.alert-room-availability').removeClass('hidden').addClass('alert-danger').html("<strong><?php echo __('Oh snap!', 'tauchterminal') ?></strong> <?php echo __('There are no rooms left for your chosen date and configuration.', 'tauchterminal') ?>");
                    }
                    $('.summary .ajaxloader').remove();
                }
            );

        })
    });
</script>
