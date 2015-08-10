<?php

class TauchTerminal_Tulamben {

    public static function display_ratings() {
        if (isset($_POST['action'])) {
            self::saveSettings($_POST);
        }

        $settings = self::getSettings();

        TauchTerminal::view('tulamben/settings', array('settings' => $settings));
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
        global $wpdb;
        $table = $wpdb->prefix."tt_tulamben_settings";

        foreach ($data['settings'] as $key => $value) {
            $sql = 'INSERT INTO '.$table.' (option_name, option_value) ';
            $sql .= 'VALUES('.$key.', "'.$value.'") ';
            $sql .= 'ON DUPLICATE KEY UPDATE ';
            $sql .= 'option_value = "'.$value.'", ';
            $sql .= 'option_name = '.$key.'';
            $wpdb->query($sql);
        }
    }

    public static function ca_handler() {
        $api = self::getTauchTerminalOptions('ca_api');

        if (($response_xml_data = file_get_contents($api))===false){
            TauchTerminal::view('tulamben/rating_default', array('error' => "Error fetching XML"));
        } else {
            libxml_use_internal_errors(true);
            $data = simplexml_load_string($response_xml_data);
            if (!$data) {
                $errors = array();
                $errors[] = "Error loading XML";
                foreach(libxml_get_errors() as $error) {
                    $errors[] = $error->message;
                }
                TauchTerminal::view('tulamben/rating_default', array('error' => $errors));
            } else {
                TauchTerminal::view('tulamben/rating', array('data' => $data));
            }
        }
    }
}
