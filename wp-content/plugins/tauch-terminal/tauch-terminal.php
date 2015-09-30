<?php
/*
Plugin Name: Tauch Terminal Custom Plugin
Description: Plugin is for Tauch Terminal Bali and their other sites
Author: Vanessa
Version: 1.0.0
Author URI: http://nessie.me
*/
if (!function_exists('add_action' )) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('TAUCHTERMINAL_VERSION', '1.0.4');
define('TAUCHTERMINAL__MINIMUM_WP_VERSION', '3.1');
define('TAUCHTERMINAL__PLUGIN_URL', plugin_dir_url(__FILE__ ));
define('TAUCHTERMINAL__PLUGIN_DIR', plugin_dir_path(__FILE__ ));
define('TAUCHTERMINAL__PLUGIN_CLASSES', plugin_dir_path(__FILE__ ) . 'classes/');
define('TAUCHTERMINAL__DELETE_LIMIT', 100000);

register_activation_hook(__FILE__, array('TauchTerminal', 'plugin_activation' ));
register_deactivation_hook(__FILE__, array('TauchTerminal', 'plugin_deactivation' ));

require_once(TAUCHTERMINAL__PLUGIN_CLASSES . 'tauch-terminal.php');
require_once(TAUCHTERMINAL__PLUGIN_CLASSES . 'database.php');

function tt_update_db_check() {
    if (version_compare(get_site_option('tt_version'), TAUCHTERMINAL_VERSION, '<')) {
        TauchTerminal_DB::migrations(TAUCHTERMINAL_VERSION);
    }
}
add_action('plugins_loaded', 'tt_update_db_check');

require_once(TAUCHTERMINAL__PLUGIN_CLASSES . 'pagination.php');
require_once(TAUCHTERMINAL__PLUGIN_CLASSES . 'sites.php');
require_once(TAUCHTERMINAL__PLUGIN_CLASSES . 'certifications.php');
require_once(TAUCHTERMINAL__PLUGIN_CLASSES . 'tulamben.php');

if (is_admin()) {
    require_once(TAUCHTERMINAL__PLUGIN_CLASSES . 'admin-meta-boxes.php');
    require_once(TAUCHTERMINAL__PLUGIN_CLASSES . 'admin.php');

    add_action('init', array('TauchTerminal_Admin', 'init' ));

    add_action('admin_enqueue_scripts', 'enqueue_admin_custom_scripts');
}

function enqueue_admin_custom_scripts() {
    wp_enqueue_script('media-upload'); //Provides all the functions needed to upload, validate and give format to files.
    wp_enqueue_script('thickbox'); //Responsible for managing the modal window.
    wp_enqueue_style('thickbox'); //Provides the styles needed for this window.
    wp_enqueue_script('script', plugins_url('js/upload.js', __FILE__), array('jquery'), '', true); //It will initialize the parameters needed to show the window properly.

    // load theme css to also have bootstrap in Admin
    // Our base theme CSS that adds colored sections and padding.
    wp_enqueue_script('tauchterminal', get_template_directory_uri() . '/dist/js/tauchterminal.min.js', array('jquery'), '20140913', true);
    wp_enqueue_style('tauchterminal', get_template_directory_uri() . '/dist/css/tauchterminal.css', array(), '20150927', 'all');
}

function customeralliance_handler() {
    TauchTerminal_Tulamben::ca_handler();
}
add_shortcode('tauchterminal-customeralliance', 'customeralliance_handler');

function booking_handler() {
    TauchTerminal_Tulamben::hotelbooking_handler();
}
add_shortcode('tauchterminal-testconnection', 'booking_handler');

add_filter('query_vars', 'parameter_queryvars' );
function parameter_queryvars($qvars) {
    $qvars[] = ' myvar';
    return $qvars;
}
