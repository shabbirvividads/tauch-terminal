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

    public static function getSites() {
        global $wpdb;
        $table = $wpdb->prefix."tt_sites";
        $sites = $wpdb->get_results("SELECT * FROM $table");
        return $sites;
    }

    public static function updateSites($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_sites";
        foreach ($data['tt'] as $key => $array) {
            if ($array['if'] !== '') {
                $wpdb->update($table,
                    array(
                        'tt_name' => $array['name'],
                        'tt_desc' => $array['desc'],
                        'tt_slug' => $array['slug'],
                        'tt_url' => $array['url']
                    ),
                    array('id' => $array['id'])
                );
            } else if ($array['name'] !== '') {
                $wpdb->insert($table,
                    array(
                        'tt_name' => $array['name'],
                        'tt_desc' => $array['desc'],
                        'tt_slug' => $array['slug'],
                        'tt_url' => $array['url']
                    )
                );
            }
        }
    }

    public static function getCertifications() {
        return [["http://www.tauch-terminal.com/images/ssi_diamond_resort.jpg", "ssi diamond instructor resort bali"],
                ["http://www.tauch-terminal.com/images/diamond_diving_school.jpg", "ssi diamant tauchschule bali"],
                ["http://www.tauch-terminal.com/sponsor/unud.jpg", "udayana university partner"],
                ["http://www.tauch-terminal.com/sponsor/screwit.jpg", "lets dive bali campaign"],
                ["http://www.tauch-terminal.com/sponsor/comments_taucher.jpg", "tauch terminal bali kommentare auf taucher.net"],
                ["http://www.tauch-terminal.com/sponsor/unud_text_dt.jpg", "udayana university partner"],
                ["http://www.tauch-terminal.com/sponsor/tauchterminal.jpg", "tauch terminal dive resort tulamben"],
                ["http://www.tauch-terminal.com/sponsor/resort.jpg", "SSI dive education &amp; licenses"],
                ["http://www.tauch-terminal.com/sponsor/liveaboard.jpg", "indonedsia liveaboard tauch kreuzfahrten"]];
    }
}
