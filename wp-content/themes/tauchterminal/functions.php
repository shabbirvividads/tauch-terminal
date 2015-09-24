<?php
/**
 * Theme: Tauch Terminal Bootstrap
 *
 * Theme Functions, includes, etc.
 *
 * @package tauchterminal
 */

/**
 * SET THEME OPTIONS HERE
 *
 * Theme options. Can override in child theme. For theme developers, this is an array so
 * you can add these items to the customizer and store them all as a single options entry.
 *
 * Parameters:
 * background_color - Hex code for default background color without the #. eg) ffffff
 *
 * content_width - Only for determining "full width" image. Actual width in Bootstrap.css
 *         is 1170 for screens over 1200px resolution, otherwise 970.
 *
 * embed_video_width - Sets the maximum width of videos that use the <embed> tag. The
 *         default is 1170 to handle full-width page templates. If you will ALWAYS display
 *         the sidebar, can set to 600 for better performance.
 *
 * embed_video_height - Leave empty to automatically set at a 16:9 ratio to the width
 *
 * post_formats - Array of WordPress extra post formats. i.e. aside, image, video, quote,
 *         and/or link
 *
 * touch_support - Whether to load touch support for carousels (sliders)
 *
 * fontawesome - Whether to load font-awesome font set or not
 *
 * bootstrap_gradients - Whether to load Bootstrap "theme" CSS for gradients
 *
 * navbar_classes - One or more of navbar-default, navbar-inverse, navbar-fixed-top, etc.
 *
 * custom_header_location - If 'header', displays the custom header above the navbar. If
 *         'content-header', displays it below the navbar in place of the colored content-
 *        header section.
 *
 * image_keyboard_nav - Whether to load javascript for using the keyboard to navigate image attachment pages
 *
 * sample_widgets - Whether to display sample widgets in the footer and page-bottom widet areas.
 *
 * sample_footer_menu - Whether to display sample footer menu with Top and Home links
 *
 * testimonials - Whether to activate testimonials custom post type if Jetpack plugin is
 *         active
 */
$defaults = array(
    'background_color'             => 'f2f2f2',
    'content_width'             => 1170, // used for full-width images
    'embed_video_width'         => 1170, // full-width videos on full-width pages
    'embed_video_height'         => null, // i.e. calculate it automatically
    'post_formats'                 => null,
    'touch_support'             => true,
    'fontawesome'                 => true,
    'bootstrap_gradients'         => false,
    'navbar_classes'            => 'navbar-default navbar-static-top',
    'custom_header_location'     => 'header',
    'image_keyboard_nav'         => true,
    'sample_widgets'             => true,
    'sample_footer_menu'        => true,
    'testimonials'                => true // requires Jetpack plugin
);

/**
 * NOTE: $theme_options is being deprecated and replaced with $xsbf_theme_options. You'll
 * need to update your child themes.
 */
if (isset ($xsbf_theme_options) AND is_array ($xsbf_theme_options) AND ! empty ($xsbf_theme_options)) {
    $xsbf_theme_options = wp_parse_args($xsbf_theme_options, $defaults);
} elseif (isset ($theme_options) AND is_array ($theme_options) AND ! empty ($theme_options)) {
    $xsbf_theme_options = wp_parse_args($theme_options, $defaults);
} else {
    $xsbf_theme_options = $defaults;
}
$theme_options = $xsbf_theme_options;

// Plugins expect this as discreet variable, so set it
$content_width = $xsbf_theme_options['content_width'];

/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
if (! function_exists('xsbf_setup')) :
function xsbf_setup() {

    global $xsbf_theme_options;

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Enable support for Post Thumbnails on posts and pages. As of WordPress v3.9,
    // specific crop parameters handled.
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(640, 360, array('left', 'top')); // crop left top
    //add_image_size('section-image', 1600, 400, array('center', 'center')); // section image

    // This theme uses wp_nav_menu() in two locations. As of WordPress v3.0.
    register_nav_menus(array(
        'primary'     => __('Header Menu', 'tauchterminal'),
        'footer'     => __('Footer Menu', 'tauchterminal'),
   ));

    // This feature outputs HTML5 markup for the comment forms, search forms and
    // comment lists. As of WordPress v3.6.
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form'));

    // Add editor CSS to style the WordPress visual post / page editor. Ours mainly
    // pulls in all of our front-end CSS.
    add_editor_style('/css/editor-style.css');

    // Setup the WordPress core custom background feature. As of WordPress v3.4. This
    // theme is full-width up to 1600px, so background will only show when user's
    // screen is wider than that.
    add_theme_support('custom-background', apply_filters('xsbf_custom_background_args', array(
            'default-color' => $xsbf_theme_options['background_color'],
            'default-image' => '',
       )));

    // Enable support for Post Formats. Note we haven't included any special styling.
    // Look at TwentyEleven theme for this.  As of WordPress v3.1.
    if(! empty ($xsbf_theme_options['post_formats'])) {
        add_theme_support('post-formats', $xsbf_theme_options['post_formats']);
     }

    // Enable support for excerpts on Pages. This is mainly for the Page with Subpages
    // page template, but also nice for search results.
    add_post_type_support('page', 'excerpt');

    // Make theme available for translation. Translations can be filed in the /languages/
    // directory. If you want to translate this theme, please contact me!
    add_filter('locale', 'set_my_locale');
    function set_my_locale($lang) {
        $lang = (isset($_GET['language'])) ? $_GET['language'] : $lang;
        return $lang;
    }
    load_theme_textdomain('tauchterminal');

} // end function
add_action('after_setup_theme', 'xsbf_setup');
endif; // end ! function_exists

/**
 * Register widgetized areas
 */
if (! function_exists('xsbf_widgets_init')) :
function xsbf_widgets_init() {

    // Put sidebar first as this is standard in almost all WordPress themes
    register_sidebar(array(
        'name'          => __('Sidebar', 'tauchterminal'),
        'id'            => 'sidebar-1',
        'description'     => __('Main sidebar (right or left)', 'tauchterminal'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
   ));

    // Put footer next as most themes put them here. Default # columns is 3.
    register_sidebar(array(
        'name'             => __('Footer', 'tauchterminal'),
        'id'             => 'sidebar-2',
        'description'     => __('Optional site footer widgets. Add 1-4 widgets here to display in columns.', 'tauchterminal'),
        'before_widget' => '<aside id="%1$s" class="widget col-sm-4 clearfix %2$s">',
        'after_widget'     => "</aside>",
        'before_title'     => '<h2 class="widget-title">',
        'after_title'     => '</h2>',
   ));

    // Page Top (After Header) Widget Area. Single column.
    register_sidebar(array(
        'name'             => __('Page Top', 'tauchterminal'),
        'id'             => 'sidebar-3',
        'description'     => __('Optional section after the header. This is a single column area that spans the full width of the page.', 'tauchterminal'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix"><div class="container">',
        'before_title'     => '<h2 class="widget-title">',
        'after_title'     => '</h2>',
        'after_widget'     => '</div><!-- container --></aside>',
   ));

    // Page Bottom (Before Footer) Widget Area. Single Column.
    register_sidebar(array(
        'name'             => __('Page Bottom', 'tauchterminal'),
        'id'             => 'sidebar-4',
        'description'     => __('Optional section before the footer. This is a single column area that spans the full width of the page.', 'tauchterminal'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix"><div class="container">',
        'before_title'     => '<h2 class="widget-title">',
        'after_title'     => '</h2>',
        'after_widget'     => '</div><!-- container --></aside>',
   ));

} //end function
add_action('widgets_init', 'xsbf_widgets_init');
endif; // end ! function_exists

/**
 * Load CSS Styles and Javascript Files
 */
if (! function_exists('xsbf_scripts')) :
function xsbf_scripts() {

    global $xsbf_theme_options;

    // load minifide if not in debug
    if (WP_DEBUG) {
        // Our base theme CSS that adds colored sections and padding.
        wp_register_style('tauchterminal', get_template_directory_uri() . '/css/tauchterminal.css', array(), '20150708', 'all');
        wp_enqueue_style('tauchterminal');
        /* LOAD JAVASCRIPT */
        // Our theme's javascript for smooth scrolling and optional for touch carousels
        wp_enqueue_script('tauchterminal', get_template_directory_uri() . '/dist/js/tauchterminal.js', array('jquery'), '20140913', true);
    } else {
        // Our base theme CSS that adds colored sections and padding.
        wp_register_style('tauchterminal', get_template_directory_uri() . '/dist/css/tauchterminal.min.css', array(), '20150708', 'all');
        wp_enqueue_style('tauchterminal');
        /* LOAD JAVASCRIPT */
        // Our theme's javascript for smooth scrolling and optional for touch carousels
        wp_enqueue_script('tauchterminal', get_template_directory_uri() . '/dist/js/tauchterminal.min.js', array('jquery'), '20140913', true);
    }

    // Optional script from _S theme to allow keyboard nvigation through image pages
    if ($xsbf_theme_options['image_keyboard_nav'] AND is_singular() AND wp_attachment_is_image()) {
        wp_enqueue_script('keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20120202', true);
    }

    // For single pages or posts, add javascript to reply inline
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // For IE8 or older, load HTML5 compatibility files
    preg_match ('|MSIE\s([0..9]*)|', $_SERVER['HTTP_USER_AGENT'], $browser);
    if ($browser AND $browser[1] < 9) {
        wp_enqueue_script('html5shiv', get_template_directory_uri() . '/html5/html5shiv.js', null, '3.7.0', true);
        wp_enqueue_script('respond', get_template_directory_uri() . '/html5/respond.min.js', null, '1.4.2', true);
    }

} // end function
add_action('wp_enqueue_scripts', 'xsbf_scripts');
endif; // end ! function_exists

/**
 * LOAD OUR REQUIRED AND OPTIONAL INCLUDE FILES FOR VARIOUS THEME FEATURES
 */
if (! function_exists('xsbf_load_includes')) :
function xsbf_load_includes() {

    /**
     * REQUIRED INCLUDE FILES
     */

    // Custom template tags for this theme. This is needed for sure.
    require_once get_template_directory() . '/inc/template-tags.php';

    // Functions not related to template tags. This is needed for sure.
    require_once get_template_directory() . '/inc/theme-functions.php';

    //Overide the standard WordPress nav menu with Bootstrap divs, data attributes, and CSS
    require_once get_template_directory() . '/inc/bootstrap-navmenu.php';

    /**
     * OPTIONAL INCLUDE FILES
     */

    // Implement the WordPress Custom Header feature. Optional.
    include_once get_template_directory() . '/inc/custom-header.php';

    // WordPress Theme Customizer. Optional.
    include_once get_template_directory() . '/inc/customizer.php';

    // Custom functions that act independently of the theme templates. Optional.
    include_once get_template_directory() . '/inc/extras.php';

    // Jetpack compatibility file to handle endless posts, responsive videos,
    // testimonials custom post type. Optional.
    include_once get_template_directory() . '/inc/jetpack.php';

    // Recommend plugins that compliment this theme. Optional.
    include_once get_template_directory() . '/inc/xsbf-plugin-recommendations.php';

} // end function
xsbf_load_includes();
endif; // end ! function_exists

######################################################################################################################
// WooCommerce
######################################################################################################################
// unhook theme wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

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
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
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
