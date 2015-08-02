<?php

class TauchTerminal {

    public static function plugin_activation() {
        global $wpdb;
        $table = $wpdb->prefix."tt_sites";
        $structure = "CREATE TABLE $table (
            id INT(9) NOT NULL AUTO_INCREMENT,
            tt_name VARCHAR(80) NOT NULL,
            tt_desc VARCHAR(80) NOT NULL,
            tt_slug VARCHAR(80) NOT NULL,
            tt_url VARCHAR(80) NOT NULL,
            tt_logo VARCHAR(200) NOT NULL,
            tt_bg VARCHAR(200) NOT NULL,
        UNIQUE KEY id (id)
       );";
        $wpdb->query($structure);
    }

    public static function plugin_deactivation() {
        //tidy up
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