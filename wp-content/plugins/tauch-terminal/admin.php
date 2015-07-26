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
        add_menu_page('TauchTerminal', 'Tauch Terminal', 'manage_options', 'tauch-terminal', array('TauchTerminal_Admin', 'display_page'),  plugin_dir_url( __FILE__ ).'img/logo.png', 22);
        add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Dashboard', 'manage_options', 'tauch-terminal' );
        add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Edit Sites', 'manage_options', 'tauch-terminal-edit-sites', array('TauchTerminal_Sites', 'display_sites') );
    }

    public static function admin_head() {
        if (!current_user_can('manage_options'))
            return;
    }

    public static function display_page() {
        $sites = TauchTerminal::getSites();

        wp_enqueue_style(
            'tauch-terminal-styles',
            plugins_url('css/dashboard.css', __FILE__)
        );
        TauchTerminal::view('start', array( 'sites' => $sites ));
    }
}
