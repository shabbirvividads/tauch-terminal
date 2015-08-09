<?php

class TauchTerminal_Tulamben {

    public static function display_ratings() {
        if (isset($_POST['action'])) {
            self::saveSettings($_POST);
        }

        $settings = self::getSettings();

        TauchTerminal::view('ratings/settings', array('settings' => $settings));
    }

    public static function getSettings() {
        global $wpdb;
        $table = $wpdb->prefix."tt_tulamben_settings";
        $select = "SELECT * FROM $table";
        $settings = $wpdb->get_results($select);
        return $settings;
    }

    public static function getTauchTerminalOptions($option) {
        $settings = self::getSettings();
        foreach ($settings as $setting) {
            if ($setting->option_name == $option) {
                return $setting->option_value;
            }
        }
        return false;
    }

    public static function saveSettings($data) {
        $table = $wpdb->prefix."tt_tulamben_settings";
        $select = "SELECT * FROM $table";
        $settings = $wpdb->get_results($select);
        return $settings;
    }
}
