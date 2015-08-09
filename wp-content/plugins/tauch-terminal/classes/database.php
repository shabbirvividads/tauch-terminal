<?php

class TauchTerminal_DB {

    public static function upgrade_version($version, $force = false){
        global $wpdb, $tt_version;

        if ($force || (get_site_option('tt_version') && version_compare(get_site_option('tt_version'), $version, '<' ))) {
            $upg_file = TAUCHTERMINAL__PLUGIN_DIR . 'upgrade/upgrade-' . $version . '.php';
            if (file_exists($upg_file) && is_readable($upg_file)) {
                include_once $upg_file;
            }
        }
    }

    public static function migrations($tt_version) {
        global $wpdb;

        self::upgrade_version('1.0.1');
        self::upgrade_version('1.0.2');
    }
}
