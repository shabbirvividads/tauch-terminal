<?php

class TauchTerminal_Admin {

    private static $initiated = false;

    public static function init() {
        if (! self::$initiated) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {
        self::$initiated = true;

        add_action('admin_init', array('TauchTerminal_Admin', 'admin_init'));
        add_action('admin_menu', array('TauchTerminal_Admin', 'admin_menu'));
    }

    public static function admin_init() {
        load_plugin_textdomain('tauch-terminal');
    }

    public static function admin_menu() {
        add_menu_page('TauchTerminal', 'Tauch Terminal', 'manage_options', 'tauch-terminal', array('TauchTerminal_Admin', 'display_page'), TAUCHTERMINAL__PLUGIN_URL.'img/logo.png', 22);
        add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Dashboard', 'manage_options', 'tauch-terminal' );
        if (get_current_blog_id() == 1) {
            add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Websites', 'manage_options', 'tauch-terminal-sites', array('TauchTerminal_Sites', 'display_sites') );
            add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Resort Ratings', 'manage_options', 'tauch-terminal-ratings', array('TauchTerminal_Tulamben', 'display_ratings') );
        }
        add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Settings', 'manage_options', 'tauch-terminal-settings', array('TauchTerminal_Sites', 'default_website') );
    }

    public static function admin_head() {
        if (!current_user_can('manage_options'))
            return;
    }

    public static function display_page() {
        $sites = TauchTerminal_Sites::getSites();
        $current = TauchTerminal_Sites::getCurrentSite();

        wp_enqueue_style(
            'tauch-terminal-styles',
            plugins_url('tauch-terminal/css/dashboard.css', TAUCHTERMINAL__PLUGIN_DIR)
        );
        TauchTerminal::view('start', array('sites' => $sites, 'currentsite' => $current));
    }
}
