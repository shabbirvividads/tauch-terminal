<?php

class TauchTerminal_Tulamben {

    public static function display_ratings() {
        if (isset($_POST['action'])) {
            TauchTerminal_DB::saveSettings($_POST);
        }

        $settings = TauchTerminal_DB::getSettings();

        TauchTerminal::view('tulamben/settings', array('settings' => $settings));
    }

    public static function hotelbooking_handler() {
        $soap = new HotelsystemSoapClass();
        $result = $soap->AvailableRooms();
        var_dump($result);
    }

    public static function ca_handler() {
        $cacheName = 'ca_api_external.xml.cache';
        $cacheNameReview = 'ca_api_reviews.xml.cache';
        $ageInSeconds = 86400; // one day

        $globalStatistics = '';
        $portalStatistics = '';
        $errors = array();
        libxml_use_internal_errors(true);

        // generate the cache version if it doesn't exist or it's too old!
        clearstatcache();
        if (!file_exists($cacheName) || filemtime($cacheName) + $ageInSeconds < time()) {
            $ca_api_external = TauchTerminal_DB::getTTOption('ca_api_external');
            if (($response_xml_data = file_get_contents($ca_api_external))!==false) {
                file_put_contents($cacheName, $response_xml_data);
            }
        }

        if (!file_exists($cacheNameReview) || filemtime($cacheNameReview) + $ageInSeconds < time()) {
            $ca_api_reviews = TauchTerminal_DB::getTTOption('ca_api_reviews');
            if (($response_xml_data = file_get_contents($ca_api_reviews))!==false) {
                file_put_contents($cacheNameReview, $response_xml_data);
            }
        }

        $data = simplexml_load_file($cacheName);
        if (!$data) {
            $errors[] = "Error loading XML " . $cacheName;
            foreach(libxml_get_errors() as $error) {
                $errors[] = $error->message;
            }
            libxml_clear_errors();
        } else {
            $globalStatistics = $data->globalStatistics;
            $portalStatistics = $data->portalStatistics;
        }

        $data_review = simplexml_load_file($cacheNameReview);
        if (!$data_review) {
            $errors[] = "Error loading XML " . $cacheNameReview;
            foreach(libxml_get_errors() as $error) {
                $errors[] = $error->message;
            }
            libxml_clear_errors();
        } else {
            $data_review = $data_review->reviews->review;
        }

        if (!empty($errors)) {
            TauchTerminal::view('tulamben/rating_default', array('error' => $errors));
        } else {
            // pagination
            global $wp_query;
            $page = ($wp_query->query_vars['page']) ? $wp_query->query_vars['page'] : 1;
            $pagination = new LimitPagination($page, $data_review->count(), 20);

            TauchTerminal::view('tulamben/rating', array('data_review' => $pagination->getLimitIterator($data_review), 'globalStatistics' => $globalStatistics, 'portalStatistics' => $portalStatistics, 'pagination' => $pagination));
        }
    }
}
