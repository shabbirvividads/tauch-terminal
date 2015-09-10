<?php

class TauchTerminal {

    public static function plugin_activation() {
        add_site_option('tt_version', '1.0.0');

        $upg_file = TAUCHTERMINAL__PLUGIN_DIR . 'upgrade/install-1.0.0.php';
        if (file_exists($upg_file) && is_readable($upg_file)) {
            include_once $upg_file;
        }
    }

    public static function plugin_deactivation() {
        global $wpdb;

        if (false == delete_site_option('tt_version')) {
            $html = '<div class="error">';
                $html .= '<p>';
                    $html .= __( 'There was a problem deactivating the Tauch Terminal Plugin. Please try again.', 'tauch-terminal' );
                $html .= '</p>';
            $html .= '</div>';
            echo $html;
        }
    }

    public static function view($name, array $args = array()) {
        $args = apply_filters('tt_view_arguments', $args, $name);

        foreach ($args AS $key => $val) {
            $$key = $val;
        }

        load_plugin_textdomain('tauch-terminal');

        $file = TAUCHTERMINAL__PLUGIN_DIR . 'views/'. $name . '.php';

        include($file);
    }
}
