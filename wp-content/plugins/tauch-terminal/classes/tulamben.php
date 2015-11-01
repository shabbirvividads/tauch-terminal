<?php

class TauchTerminal_Tulamben {

    public static function display_settings() {
        if (isset($_POST['action'])) {
            TauchTerminal_DB::saveSettings($_POST);
        }

        $settings = TauchTerminal_DB::getSettings();

        TauchTerminal::view('tulamben/settings', array('settings' => $settings));
    }

    public static function formatDateFromTo($start_date, $end_date) {
        $string = '';

        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        if ($start->format('m') == $end->format('m')) {
            $string .= $start->format('l, d.');
        } else {
            $string .= $start->format('l, d. F');
        }

        $string .= ' - ';

        $string .= $end->format('l, d. F Y');

        return $string;
    }

    public static function getProductTypeBySKU($sku) {
        if (strpos($sku,'family') !== false) {
            return 'family';
        } else if (strpos($sku,'bungalow') !== false) {
            return 'bungalow';
        } else if (strpos($sku,'room') !== false) {
            return 'room';
        } else if (strpos($sku,'diving') !== false) {
            return 'diving';
        }
        return $sku;
    }

    public static function isRoomProduct($sku) {
        $type = self::getProductTypeBySKU($sku);
        return (in_array($type, ['family', 'bungalow', 'room']));
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

    private static function getAttributeLabel($attributes, $attribute, $position) {
        $attributeLabel = str_replace("attribute_", "", $attribute);
        $attributeValues = explode('|', $attributes[$attributeLabel]['value']);

        return array('name' => $attributes[$attributeLabel]['name'], 'value' => $attributeValues[$position]);
    }

    public static function addCustomDataToProduct($cart_item_data, $product_id, $variation_id) {
        global $woocommerce;
        $_pf = new WC_Product_Factory();
        $data = $_POST;

        // Split all the products added to the cart
        $unique_cart_item_key = md5(microtime().rand()."Hi Mom!");
        $cart_item_data['unique_key'] = $unique_cart_item_key;

        $product = $_pf->get_product($product_id);
        if (TauchTerminal_Tulamben::isRoomProduct($product->get_sku())) {
            $cart_item_meta['start_date'] = $data['start'];
            $cart_item_meta['end_date'] = $data['end'];
            $attributes = $product->get_attributes();
            if ($data['attribute_bed']) {
                $labels = self::getAttributeLabel($attributes, 'attribute_bed', $data['attribute_bed']);
                $name = $labels['name'];
                $cart_item_meta['ttt_meta'][$name] = $labels['value'];
            }
            if ($data['attribute_special-requests']) {
                $labels = self::getAttributeLabel($attributes, 'attribute_special-requests', $data['attribute_special-requests']);
                $name = $labels['name'];
                $cart_item_meta['ttt_meta'][$name] = $labels['value'];
            }
        }

        return $cart_item_meta;
    }

}
