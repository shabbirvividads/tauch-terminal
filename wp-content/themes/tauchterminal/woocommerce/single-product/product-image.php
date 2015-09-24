<?php
/**
 * Single Product Image
 *
 * @author         WooThemes
 * @package     WooCommerce/Templates
 * @version     2.0.14
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

?>
<div class="images">
<?php if (has_post_thumbnail()): ?>
    <div class="slider-for">
        <?php
            $image_title     = esc_attr(get_the_title(get_post_thumbnail_id()));
            $image_caption   = get_post(get_post_thumbnail_id())->post_excerpt;
            $image_link      = wp_get_attachment_url(get_post_thumbnail_id());
            $mainimage       = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
                'title'    => $image_title,
                'alt'    => $image_title
            ));
            $mainimage_small = get_the_post_thumbnail($post->ID, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail'), array(
                'title' => $image_title,
                'alt'   => $image_title
            ));

            $attachment_count = count($product->get_gallery_attachment_ids());

            if ($attachment_count > 0) {
                $gallery = '[product-gallery]';
            } else {
                $gallery = '';
            }

            echo '<div>';
            echo apply_filters('woocommerce_single_product_image_html', sprintf('%s', $mainimage), $post->ID);
            echo '</div>';

            $attachment_ids = $product->get_gallery_attachment_ids();

            if ($attachment_ids) {
                $loop       = 0;
                $columns    = apply_filters('woocommerce_product_thumbnails_columns', 3);

                foreach ($attachment_ids as $attachment_id) {

                    $classes = array('zoom', 'col-sm-' . floor(12/$columns));

                    if ($loop == 0 || $loop % $columns == 0)
                        $classes[] = 'first';

                    if (($loop + 1) % $columns == 0)
                        $classes[] = 'last';

                    $image_link = wp_get_attachment_url($attachment_id);

                    if (! $image_link)
                        continue;

                    $image       = wp_get_attachment_image($attachment_id, apply_filters('single_product_large_thumbnail_size', 'shop_single'));
                    $image_class = esc_attr(implode(' ', $classes));
                    $image_title = esc_attr(get_the_title($attachment_id));
                    echo '<div>';
                    echo apply_filters('woocommerce_single_product_image_html', sprintf('%s', $image), $attachment_id, $post->ID, $image_class);
                    echo '</div>';

                    $loop++;
                }
            }
        ?>
        </div>
        <?php if ($attachment_ids): ?>
            <div class="slider-nav">
                <div>
                   <?php echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('%s', $mainimage_small), $post->ID); ?>
                </div>

            <?php
                $loop       = 0;
                $columns    = apply_filters('woocommerce_product_thumbnails_columns', 3);

                foreach ($attachment_ids as $attachment_id) {

                    $classes = array('zoom', 'col-sm-' . floor(12/$columns));

                    if ($loop == 0 || $loop % $columns == 0)
                        $classes[] = 'first';

                    if (($loop + 1) % $columns == 0)
                        $classes[] = 'last';

                    $image_link = wp_get_attachment_url($attachment_id);

                    if (! $image_link)
                        continue;

                    $image       = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail'));
                    $image_class = esc_attr(implode(' ', $classes));
                    $image_title = esc_attr(get_the_title($attachment_id));
                    echo '<div>';
                    echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('%s', $image), $attachment_id, $post->ID, $image_class);
                    echo '</div>';

                    $loop++;
                }
            ?>
            </div>
        <?php endif; ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.slider-for').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '.slider-nav'
                });
                $('.slider-nav').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '.slider-for',
                    dots: true,
                    centerMode: true,
                    focusOnSelect: true
                });
            });
        </script>
<?php else: ?>
    <?php echo apply_filters('woocommerce_single_product_image_html', sprintf('<img src="%s" alt="%s" />', wc_placeholder_img_src(), __('Placeholder', 'woocommerce')), $post->ID); ?>
<?php endif; ?>
</div>
