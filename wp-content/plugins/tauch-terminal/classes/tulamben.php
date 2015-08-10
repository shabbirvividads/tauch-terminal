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
        $globalStatistics = '';
        $ca_api_external = self::getTauchTerminalOptions('ca_api_external');
        $ca_api_reviews = self::getTauchTerminalOptions('ca_api_reviews');
        $errors = array();
        libxml_use_internal_errors(true);

        if (($response_xml_data = file_get_contents($ca_api_external))===false ||
            $response_xml_data_review = file_get_contents($ca_api_reviews)) {
            TauchTerminal::view('tulamben/rating_default', array('error' => "Error fetching XML"));
        } else {
            $data = simplexml_load_string($response_xml_data);
            if (!$data) {
                $errors[0] = "Error loading XML";
                foreach(libxml_get_errors() as $error) {
                    $errors[] = $error->message;
                }
            } else {
                $globalStatistics = $data->globalStatistics;
            }
        }

        $data_review = simplexml_load_string($response_xml_data_review);
        if (!$data_review) {
            $errors[0] = "Error loading XML";
            foreach(libxml_get_errors() as $error) {
                $errors[] = $error->message;
            }
        }
        if (!empty($errors)) {
            TauchTerminal::view('tulamben/rating_default', array('error' => $errors));
        }

        TauchTerminal::view('tulamben/rating', array('data' => $data_review, 'globalStatistics' => $data->globalStatistics));
    }
}
