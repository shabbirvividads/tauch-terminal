<?php

class TauchTerminal_Tulamben {

    public static function display_ratings() {
        if (isset($_POST['action'])) {
            TauchTerminal_DB::saveSettings($_POST);
        }

        $settings = TauchTerminal_DB::getSettings();

        TauchTerminal::view('tulamben/settings', array('settings' => $settings));
    }

    public static function ca_handler() {
        $globalStatistics = '';
        $ca_api_external = TauchTerminal_DB::getTTOption('ca_api_external');
        $ca_api_reviews = TauchTerminal_DB::getTTOption('ca_api_reviews');
        $errors = array();
        libxml_use_internal_errors(true);

        if (($response_xml_data = file_get_contents($ca_api_external))===false ||
            ($response_xml_data_review = file_get_contents($ca_api_reviews))===false) {
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
        $data_review = $data_review->reviews->review;
        if (!empty($errors)) {
            TauchTerminal::view('tulamben/rating_default', array('error' => $errors));
        }

        // pagination
        global $wp_query;
        $page = ($wp_query->query_vars['page']) ? $wp_query->query_vars['page'] : 1;
        $pagination = new LimitPagination($page, $data_review->count(), 20);

        TauchTerminal::view('tulamben/rating', array('data_review' => $pagination->getLimitIterator($data_review), 'globalStatistics' => $globalStatistics, 'pagination' => $pagination));
    }
}
