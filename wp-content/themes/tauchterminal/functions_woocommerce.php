<?php
/**
 * Theme: Tauch Terminal Bootstrap
 *
 * Theme Functions, includes, etc.
 *
 * @package tauchterminal
 */

######################################################################################################################
// WooCommerce
######################################################################################################################

 // Remove default woocommerce style
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
    unset( $enqueue_styles['woocommerce-general'] );    // Remove the gloss
    unset( $enqueue_styles['woocommerce-layout'] );     // Remove the layout
    unset( $enqueue_styles['woocommerce-smallscreen'] );    // Remove the smallscreen optimisation
    return $enqueue_styles;
}

// unhook theme wrapper
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// add custom theme wrapper hook
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
    echo '<div class="container"><div id="main-grid" class="row"><div id="primary" class="content-area-wide col-md-12"><main id="main" class="site-main" role="main">';
}

function my_theme_wrapper_end() {
    echo '</main><!-- #main --></div><!-- #primary -->';
    // don't show sidebar
    echo '<div style="display:none;">';
    get_sidebar();
    echo '</div>';
    echo '</div></div>';
}

// declare theme support
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support() {
    add_theme_support('woocommerce');
}

// don't merge products in cart
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_cart_collaterals_upsell', 'woocommerce_cross_sell_display');

add_filter('woocommerce_add_cart_item_data','namespace_force_individual_cart_items',10,2);
function namespace_force_individual_cart_items($cart_item_data, $product_id)
{
    $unique_cart_item_key = md5(microtime().rand()."Hi Mom!");
    $cart_item_data['unique_key'] = $unique_cart_item_key;

    return $cart_item_data;
}

// Category Description wrap in Bootstrap
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description');
add_action( 'woocommerce_archive_description', 'woocommerce_category_archive_description');
function woocommerce_category_archive_description() {
    if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
        $description = wc_format_content( term_description() );
        $image = false;
        if (is_tax() || is_tag() || is_category()) {
            $term = get_queried_object();
            $thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
            if ( $thumbnail_id ) {
                $image = wp_get_attachment_image($thumbnail_id, 250);
            } else {
                $image = wc_placeholder_img_src();
            }
        }
        if ( $description ) {
            $string = '<div class="row margin-bottom">';
            if ($image) {
                $string .= '<div class="col-sm-4 col-sm-push-8">' . $image . '</div>';
            }
            $string .= '<div class="term-description col-sm-8';
            if ($image) {
                $string .= ' col-sm-pull-4';
            }
            $string .= '">' . $description . '</div></div>';
            echo $string;
        }
    }
}
// Category Description allow HTML
foreach ( array( 'pre_term_description' ) as $filter ) {
    remove_filter( $filter, 'wp_filter_kses' );
}
foreach ( array( 'term_description' ) as $filter ) {
    remove_filter( $filter, 'wp_kses_data' );
}
