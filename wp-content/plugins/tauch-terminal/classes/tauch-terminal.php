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
        //tidy up
        global $wpdb;

        // foreach (array('tt_sites', 'tt_tulamben_settings', 'tt_default_site') as $tablename) {
        //     $table = $wpdb->prefix.$tablename;
        //     $wpdb->query("DROP TABLE IF EXISTS $table");
        // }
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

    public static function getCertifications() {
        return [["http://localhost/~nessie/wordpress/wp-content/uploads/2015/07/ssi_diamond_resort.png", "ssi diamond instructor resort bali"],
                ["http://localhost/~nessie/wordpress/wp-content/uploads/2015/07/diamond_diving_school.png", "ssi diamant tauchschule bali"],
                ["http://localhost/~nessie/wordpress/wp-content/uploads/2015/07/unud.png", "udayana university partner"],
                ["http://localhost/~nessie/wordpress/wp-content/uploads/2015/07/screwit.png", "lets dive bali campaign"],
                ["http://localhost/~nessie/wordpress/wp-content/uploads/2015/07/comments_taucher.jpg", "tauch terminal bali kommentare auf taucher.net"],
                ["http://localhost/~nessie/wordpress/wp-content/uploads/2015/07/unud_text_dt.png", "udayana university partner"],
                ["http://localhost/~nessie/wordpress/wp-content/uploads/2015/07/tauchterminal.png", "tauch terminal dive resort tulamben"],
                ["http://localhost/~nessie/wordpress/wp-content/uploads/2015/07/resort.png", "SSI dive education &amp; licenses"],
                ["http://localhost/~nessie/wordpress/wp-content/uploads/2015/07/liveaboard.png", "indonedsia liveaboard tauch kreuzfahrten"]];
    }
}
