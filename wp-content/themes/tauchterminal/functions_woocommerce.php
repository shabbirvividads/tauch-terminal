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

###########################################################
// Category View
###########################################################

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

// Category Hide Products from Subcategory
function exclude_product_cat_children($wp_query) {
    if (isset ( $wp_query->query_vars['product_cat'] ) && $wp_query->is_main_query()) {
        $wp_query->set('tax_query', array(
                array (
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $wp_query->query_vars['product_cat'],
                    'include_children' => false
                )
            )
        );
    }
}
add_filter('pre_get_posts', 'exclude_product_cat_children');


/**
 * Display product sub categories as title and List
 *
 * @subpackage  Loop
 * @param array $args
 * @return null|boolean
 */
function woocommerce_product_subcategories( $args = array() ) {
    global $wp_query;

    $defaults = array(
        'before'        => '',
        'after'         => '',
        'force_display' => false
    );

    $args = wp_parse_args( $args, $defaults );

    extract( $args );

    // Main query only
    if ( ! is_main_query() && ! $force_display ) {
        return;
    }

    // Don't show when filtering, searching or when on page > 1 and ensure we're on a product archive
    if ( is_search() || is_filtered() || is_paged() || ( ! is_product_category() && ! is_shop() ) ) {
        return;
    }

    // Check categories are enabled
    if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == '' ) {
        return;
    }

    // Find the category + category parent, if applicable
    $term           = get_queried_object();
    $parent_id      = empty( $term->term_id ) ? 0 : $term->term_id;

    if ( is_product_category() ) {

        $display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

        switch ( $display_type ) {
            case 'products' :
                return;
            break;
            case '' :
                if ( get_option( 'woocommerce_category_archive_display' ) == '' ) {
                    return;
                }
            break;
        }
    }

    // NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( http://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work
    $product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
        'parent'       => $parent_id,
        'menu_order'   => 'ASC',
        'hide_empty'   => 0,
        'hierarchical' => 1,
        'taxonomy'     => 'product_cat',
        'pad_counts'   => 1
    ) ) );

    if ( ! apply_filters( 'woocommerce_product_subcategories_hide_empty', false ) ) {
        $product_categories = wp_list_filter( $product_categories, array( 'count' => 0 ), 'NOT' );
    }

    if ( $product_categories ) {
        echo $before;

        foreach ( $product_categories as $category ) {
            echo '<h2 class="col-xs-12">' . $category->name . '</h2>';

            $args = array(
                // 'post__not_in' => array( $post->ID ),
                'posts_per_page' => 5,
                'no_found_rows' => 1,
                'post_status' => 'publish',
                'post_type' => 'product',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $category->term_taxonomy_id
                    )
                )
            );

            $the_query = new WP_Query($args);

            if ($the_query->have_posts()) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    wc_get_template_part('taxonomy', 'product_list-diving');
                }
            }

        }

        // // If we are hiding products disable the loop and pagination
        // if ( is_product_category() ) {
        //     $display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

        //     switch ( $display_type ) {
        //         case 'subcategories' :
        //             $wp_query->post_count    = 0;
        //             $wp_query->max_num_pages = 0;
        //         break;
        //         case '' :
        //             if ( get_option( 'woocommerce_category_archive_display' ) == 'subcategories' ) {
        //                 $wp_query->post_count    = 0;
        //                 $wp_query->max_num_pages = 0;
        //             }
        //         break;
        //     }
        // }

        // if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == 'subcategories' ) {
        //     $wp_query->post_count    = 0;
        //     $wp_query->max_num_pages = 0;
        // }

        echo $after;

        return true;
    }
}
