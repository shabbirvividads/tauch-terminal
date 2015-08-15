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
        self::upgrade_version('1.0.3');
    }

    public static function getSettings() {
        global $wpdb;
        $table = $wpdb->prefix."tt_settings";
        $select = "SELECT * FROM $table";
        $settings = $wpdb->get_results($select);
        return $settings;
    }

    public static function getTTOption($option) {
        $settings = self::getSettings();
        foreach ($settings as $setting) {
            if ($setting->option_name == $option) {
                return $setting->option_value;
            }
        }
        return false;
    }

    public static function saveSettings($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_settings";

        foreach ($data['settings'] as $key => $value) {
            $sql = 'INSERT INTO '.$table.' (option_name, option_value) ';
            $sql .= 'VALUES('.$key.', "'.$value.'") ';
            $sql .= 'ON DUPLICATE KEY UPDATE ';
            $sql .= 'option_value = "'.$value.'", ';
            $sql .= 'option_name = '.$key.'';
            $wpdb->query($sql);
        }
    }

}
