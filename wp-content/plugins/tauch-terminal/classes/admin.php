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
            $sites = add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Websites', 'manage_options', 'tauch-terminal-sites', array('TauchTerminal_Sites', 'display_sites') );
            add_action('admin_print_scripts-' . $sites, array('TauchTerminal_Admin', 'enqueue_admin_custom_scripts'));

            $tttsettings = add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Tulamben', 'manage_options', 'tauch-terminal-tulamben-settings', array('TauchTerminal_Tulamben', 'display_settings') );
            add_action('admin_print_scripts-' . $tttsettings, array('TauchTerminal_Admin', 'enqueue_admin_custom_scripts'));
        }

        $certifications = add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Certifications', 'manage_options', 'tauch-terminal-certifications', array('TauchTerminal_Certifications', 'display_certifications') );
        add_submenu_page('tauch-terminal', 'Tauch Terminal', 'Settings', 'manage_options', 'tauch-terminal-settings', array('TauchTerminal_Sites', 'default_website') );

        add_action('admin_print_scripts-' . $certifications, array('TauchTerminal_Admin', 'enqueue_admin_custom_scripts'));

    }

    public static  function enqueue_admin_custom_scripts() {
        wp_enqueue_script('media-upload'); //Provides all the functions needed to upload, validate and give format to files.
        wp_enqueue_script('thickbox'); //Responsible for managing the modal window.
        wp_enqueue_style('thickbox'); //Provides the styles needed for this window.
        wp_enqueue_script('script', plugins_url('../js/upload.js', __FILE__), array('jquery'), '', true); //It will initialize the parameters needed to show the window properly.

        // load theme css to also have bootstrap in Admin
        // Our base theme CSS that adds colored sections and padding.
        $my_theme = wp_get_theme('tauchterminal');
        if ($my_theme->exists() && wp_get_theme() == $my_theme) {
            wp_enqueue_script('tauchterminal', get_template_directory_uri() . '/dist/js/tauchterminal.min.js', array('jquery'), '20140913', true);
            wp_enqueue_style('tauchterminal', get_template_directory_uri() . '/dist/css/tauchterminal.css', array(), '20150927', 'all');
        }
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
