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
?>

    <?php $loop = 0; foreach ($attributes as $name => $options) : $loop++; ?>
        <tr>
            <td><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label($name); ?></label></td>
            <td class="value"><select id="<?php echo esc_attr(sanitize_title($name)); ?>" name="attribute_<?php echo sanitize_title($name); ?>" data-attribute_name="attribute_<?php echo sanitize_title($name); ?>">
                <?php
                    // var_dump($options);
                    if (is_array($options)) {

                        if (isset($_REQUEST[ 'attribute_' . sanitize_title($name) ])) {
                            $selected_value = $_REQUEST[ 'attribute_' . sanitize_title($name) ];
                        } elseif (isset($selected_attributes[ sanitize_title($name) ])) {
                            $selected_value = $selected_attributes[ sanitize_title($name) ];
                        } else {
                            $selected_value = '';
                        }

                        // Get terms if this is a taxonomy - ordered
                        if (taxonomy_exists($name)) {

                            $terms = wc_get_product_terms($post->ID, $name, array('fields' => 'all'));

                            foreach ($terms as $term) {
                                if (! in_array($term->slug, $options)) {
                                    continue;
                                }
                                echo '<option value="' . esc_attr($term->slug) . '" ' . selected(sanitize_title($selected_value), sanitize_title($term->slug), false) . '>' . apply_filters('woocommerce_variation_option_name', $term->name) . '</option>';
                            }

                        } else {

                            foreach ($options as $option) {
                                echo '<option value="' . esc_attr(sanitize_title($option)) . '" ' . selected(sanitize_title($selected_value), sanitize_title($option), false) . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $option)) . '</option>';
                            }

                        }
                    }
                ?>
            </select> <?php
                if (sizeof($attributes) === $loop) {
                    echo '<a class="reset_variations" href="#reset">' . __('Clear selection', 'woocommerce') . '</a>';
                }
            ?></td>
        </tr>
    <?php endforeach;?>
