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


/**
 * Outputs a checkout/address form field.
 *
 * @subpackage  Forms
 * @param string $key
 * @param mixed $args
 * @param string $value (default: null)
 * @todo This function needs to be broken up in smaller pieces
 */
function woocommerce_form_field( $key, $args, $value = null ) {
    $defaults = array(
        'type'              => 'text',
        'label'             => '',
        'description'       => '',
        'placeholder'       => '',
        'maxlength'         => false,
        'required'          => false,
        'id'                => $key,
        'class'             => array(),
        'label_class'       => array(),
        'input_class'       => array(),
        'return'            => false,
        'options'           => array(),
        'custom_attributes' => array(),
        'validate'          => array(),
        'default'           => '',
    );

    $args = wp_parse_args( $args, $defaults );
    $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

    if ( $args['required'] ) {
        $args['class'][] = 'validate-required';
        $required = ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce'  ) . '">*</abbr>';
    } else {
        $required = '';
    }

    $args['maxlength'] = ( $args['maxlength'] ) ? 'maxlength="' . absint( $args['maxlength'] ) . '"' : '';

    if ( is_string( $args['label_class'] ) ) {
        $args['label_class'] = array( $args['label_class'] );
    }

    if ( is_null( $value ) ) {
        $value = $args['default'];
    }

    // Custom attribute handling
    $custom_attributes = array();

    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
        foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
            $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
        }
    }

    if ( ! empty( $args['validate'] ) ) {
        foreach( $args['validate'] as $validate ) {
            $args['class'][] = 'validate-' . $validate;
        }
    }

    $field = '';
    $label_id = $args['id'];
    $field_container = '<p class="form-row %1$s" id="%2$s">%3$s</p>';

    switch ( $args['type'] ) {
        case 'country' :

            $countries = $key == 'shipping_country' ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

            if ( sizeof( $countries ) == 1 ) {

                $field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

                $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys($countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" />';

            } else {

                $field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="form-control country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . '>'
                        . '<option value="">'.__( 'Select a country&hellip;', 'woocommerce' ) .'</option>';

                foreach ( $countries as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" '.selected( $value, $ckey, false ) .'>'.__( $cvalue, 'woocommerce' ) .'</option>';
                }

                $field .= '</select>';

                $field .= '<noscript><input type="submit" class="btn btn-primary" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '" /></noscript>';

            }

            break;
        case 'state' :

            /* Get Country */
            $country_key = $key == 'billing_state'? 'billing_country' : 'shipping_country';
            $current_cc  = WC()->checkout->get_value( $country_key );
            $states      = WC()->countries->get_states( $current_cc );

            if ( is_array( $states ) && empty( $states ) ) {

                $field_container = '<p class="form-row %1$s" id="%2$s" style="display: none">%3$s</p>';

                $field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key )  . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" />';

            } elseif ( is_array( $states ) ) {

                $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="form-control state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '">
                    <option value="">'.__( 'Select a state&hellip;', 'woocommerce' ) .'</option>';

                foreach ( $states as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" '.selected( $value, $ckey, false ) .'>'.__( $cvalue, 'woocommerce' ) .'</option>';
                }

                $field .= '</select>';

            } else {

                $field .= '<input type="text" class="input-text form-control ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

            }

            break;
        case 'textarea' :

            $field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text form-control ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>'. esc_textarea( $value  ) .'</textarea>';

            break;
        case 'checkbox' :

            $field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) .'" ' . implode( ' ', $custom_attributes ) . '>
                    <input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" '.checked( $value, 1, false ) .' /> '
                     . $args['label'] . $required . '</label>';

            break;
        case 'password' :

            $field .= '<input type="password" class="input-text form-control ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

            break;
        case 'text' :

            $field .= '<input type="text" class="input-text form-control ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

            break;
        case 'email' :

            $field .= '<input type="email" class="input-text form-control ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

            break;
        case 'tel' :

            $field .= '<input type="tel" class="input-text form-control ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

            break;
        case 'select' :

            $options = $field = '';

            if ( ! empty( $args['options'] ) ) {
                foreach ( $args['options'] as $option_key => $option_text ) {
                    if ( "" === $option_key ) {
                        // If we have a blank option, select2 needs a placeholder
                        if ( empty( $args['placeholder'] ) ) {
                            $args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
                        }
                        $custom_attributes[] = 'data-allow_clear="true"';
                    }
                    $options .= '<option value="' . esc_attr( $option_key ) . '" '. selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) .'</option>';
                }

                $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select form-control '.esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '">
                        ' . $options . '
                    </select>';
            }

            break;
        case 'radio' :

            $label_id = current( array_keys( $args['options'] ) );

            if ( ! empty( $args['options'] ) ) {
                foreach ( $args['options'] as $option_key => $option_text ) {
                    $field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
                    $field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) .'">' . $option_text . '</label>';
                }
            }

            break;
    }

    if ( ! empty( $field ) ) {
        $field_html = '';

        if ( $args['label'] && 'checkbox' != $args['type'] ) {
            $field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) .'">' . $args['label'] . $required . '</label>';
        }

        $field_html .= $field;

        if ( $args['description'] ) {
            $field_html .= '<span class="description">' . esc_html( $args['description'] ) . '</span>';
        }

        $container_class = 'form-row ' . esc_attr( implode( ' ', $args['class'] ) );
        $container_id = esc_attr( $args['id'] ) . '_field';

        $after = ! empty( $args['clear'] ) ? '<div class="clear"></div>' : '';

        $field = sprintf( $field_container, $container_class, $container_id, $field_html ) . $after;
    }

    $field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

    if ( $args['return'] ) {
        return $field;
    } else {
        echo $field;
    }
}
