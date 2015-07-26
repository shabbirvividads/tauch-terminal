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

define('TAUCHTERMINAL_VERSION', '1.0.0');
define('TAUCHTERMINAL__MINIMUM_WP_VERSION', '3.1');
define('TAUCHTERMINAL__PLUGIN_URL', plugin_dir_url(__FILE__ ));
define('TAUCHTERMINAL__PLUGIN_DIR', plugin_dir_path(__FILE__ ));
define('TAUCHTERMINAL_DELETE_LIMIT', 100000);

register_activation_hook(__FILE__, array('TauchTerminal', 'plugin_activation' ));
register_deactivation_hook(__FILE__, array('TauchTerminal', 'plugin_deactivation' ));

require_once(TAUCHTERMINAL__PLUGIN_DIR . 'class.tauch-terminal.php');

if (is_admin()) {
    require_once(TAUCHTERMINAL__PLUGIN_DIR . 'sites.php');
    require_once(TAUCHTERMINAL__PLUGIN_DIR . 'admin.php');
    add_action('init', array('TauchTerminal_Admin', 'init' ));
}
